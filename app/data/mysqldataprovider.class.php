<?php
class MySqlDataProvider{

    public function get_posts(){
        $db = $this -> connect();

        if($db == null)
            return [];

        $sql = 'SELECT * FROM post ORDER BY PostID DESC';
        $query = $db -> query($sql);

        $data = $query ->fetchAll(PDO::FETCH_CLASS, 'BlogPost');

        $query = null;

        return $data;
    }

    public function get_post($id){
        $db = $this -> connect();

        if($db == null)
            return [];

        $sql = 'SELECT * FROM post where PostID=:id';

        $smt = $db -> prepare($sql);
        $smt->execute([
            ':id' => $id
        ]);


        $data = $smt ->fetchAll(PDO::FETCH_CLASS, 'BlogPost');
        
        return $data;
    }

    public function search_post($search){
        $db = $this -> connect();
        if($db == null)
            return [];

        $sql = 'SELECT * FROM post where title LIKE :search or description LIKE :search or content LIKE :search';

        $smt = $db -> prepare($sql);
        $smt->execute([
            ':search' => '%'.$search.'%'
        ]);

        $data = $smt->fetchAll(PDO::FETCH_CLASS, 'BlogPost');

        return $data;


    }

    public function save_post($post, $login){
        $db = $this -> connect();
        if($db == null)
            return [];

        if((trim($post['PostID']) != ""))
        {
            $sql = "UPDATE post SET 
                img = :img,
                title = :title,
                category = :category,
                description = :description,
                content = :content,
                date = (SELECT CURRENT_DATE()),
                time = :time
            WHERE PostID = :PostID";

            $execute =[
                ':img' => $post['img'],
                ':title' => $post['title'],
                ':category' => $post['category'],
                ':description' => $post['description'],
                ':content' => $post['content'],
                ':time' => $post['time'],
                ':PostID' => $post['PostID']
            ];
            
        }else{
            $sql = "INSERT INTO post 
            (img, title, category, description, content, date, time, UserID)
            VALUES (:img, :title, :category, :description, :content, (SELECT CURRENT_DATE()), :time, (SELECT UserID from users where login = :login))";
            $execute = [
                ':img' => $post['img'],
                ':title' => $post['title'],
                ':category' => $post['category'],
                ':description' => $post['description'],
                ':content' => $post['content'],
                ':time' => $post['time'],
                ':login' => $login
            ];
        }
            

        $smt = $db -> prepare($sql);
        $smt->execute($execute);
        
    }
    

    public function delete_post($post){
        $db = $this -> connect();
        if($db == null)
            return [];

        $sql = 'DELETE FROM post where PostID=:post';

        $smt = $db -> prepare($sql);
        $smt->execute([
            ':post' => $post
        ]);

        
    }

    public function get_comments($post, $login = null){
        $db = $this -> connect();

        if($db == null)
            return [];

        $sql = "SELECT CommentID, comment, date, PostID, login from comments c
                    join users u on u.UserID=c.UserID where c.PostID = :PostID ORDER BY date DESC;";

        $smt = $db -> prepare($sql);
        $smt -> execute([
            ':PostID' => $post
        ]);
        $data = $smt -> fetchAll(PDO::FETCH_ASSOC);
        
        return prepare_comments($data, $login);;
    }

    public function save_comment($comment, $login, $postID){
        $db = $this -> connect();
        $data = [
            'status' => '',
            'textColor' => ''
        ];

        if(strlen(trim($comment)) != 0){
            try{

                if($db == null)
                return [];

                $sql = 'INSERT INTO comments (comment, postID, userID) 
                    VALUES (:comment, :postID, (SELECT UserID from users where login=:userID))';
                $smt = $db -> prepare($sql);
                $smt ->execute([
                    ':comment' => $comment,
                    ':postID' => $postID,
                    ':userID' => $login
                ]);
                $this -> update_post_counters('comments', $postID, 1);

                $data['status'] = 'Komentarz dodany';
                $data['textColor'] = 'text-success';

            }catch(PDOException $e){
                $data['status'] = 'Błąd serwera';
                $data['textColor'] = 'text-danger';
            }
        }else{
            $data['status'] = 'Nic nie napisałeś';
            $data['textColor']= 'text-danger';
        }
        
        

        return $data;
            

    }

    public function delete_comment($commentID, $login, $postID, $admin = null){
        $db = $this->connect();
    
        if ($db == null)
            return [];
    
        $sql = "DELETE FROM comments WHERE CommentID = :commentID";
    
        // If admin is specified, allow deletion regardless of UserID
        if (!isset($admin) ) 
            $sql .= " AND UserID = (SELECT UserID FROM users WHERE login = :login)";
    
        $smt = $db->prepare($sql);
        if (isset($admin)) {
            $smt->execute([
                ':commentID' => $commentID
            ]);
        } else {
            $smt->execute([
                ':commentID' => $commentID,
                ':login' => $login
            ]);
        }

        $this -> update_post_counters('comments', $postID, -1);
    }

    public function update_comment($commentID, $comment, $login, $admin = null){
        $db = $this -> connect();
        $data = [
            'status' => '',
            'textColor' => ''
        ];

        if($db == null)
            return [];

        try{
            $sql = 'UPDATE comments 
                SET comment = :comment
                WHERE CommentID = :commentID ';

            if(!isset($admin)){
                $sql .= ' and UserID = (SELECT UserID from users where login=:login)';
            }

            $smt = $db -> prepare($sql);
            
            if(!isset($admin)){
                $smt -> execute([
                    ':comment' => $comment,
                    ':commentID' => $commentID,
                    ':login' => $login
                ]);
            }else{
                $smt -> execute([
                    ':comment' => $comment,
                    ':commentID' => $commentID
                ]);
            }
            

            $data['status'] =  'Komentarz zaktualizowany';
            $data['textColor']= 'text-success';

        }catch(PDOException $e){
            $data['status'] =  'Wystąpił błąd';
            $data['textColor']= 'text-danger';
        }

        return $data;
    }
    
    
    public function get_author($post_id){
        $db = $this -> connect();

        if($db == null)
            return [];

        $sql = 'SELECT login from users where UserID = (SELECT UserID from post where PostID=:id)';
        $smt = $db ->prepare($sql);
        $smt -> execute([
            ':id' => $post_id
        ]);

        $data = $smt -> fetchAll(PDO::FETCH_ASSOC)[0];
        return $data['login'];
    }


    public function user_exists($user, $password, $type){
        $db = $this -> connect();
        if ($db == null)
            return null;

        if($password == null){
            $sql = "SELECT $type from users where $type=:user";
            //type define if it is login or email
            //user containt login or email
    
            $smt = $db -> prepare($sql);
            $smt->execute([
                ':user' => $user
                ]
            );
            
        }else{
            $sql = "SELECT $type from users where $type=:user and password=:password";
            //type define if it is login or email
            //user containt login or email
    
            $smt = $db -> prepare($sql);
            $smt->execute([
                ':user' => $user,
                ':password'=> md5($password)
                ]
            );
        }
        

        $data = $smt -> fetchAll(PDO::FETCH_ASSOC);

        return !empty($data);

    }

    public function is_admin($user, $password){
        $db = $this -> connect();
        if ($db == null)
            return null;

        $sql = "SELECT admin from users where login=:user and password=:password";
        $smt = $db -> prepare($sql);
        $smt->execute([
            ':user' => $user,
            ':password'=> md5($password)
            ]
        );

        $data = $smt -> fetchAll(PDO::FETCH_ASSOC)[0];
        
        return $data['admin']!='';

    }

    public function register_user($login, $email, $password){
        $db = $this -> connect();
        if($db == null)
            return false;

        $sql = 'INSERT INTO users (login, email, password) values(:login, :email, :password)';

        $smt = $db -> prepare($sql);
        return $smt -> execute([
            ':login' => $login,
            ':email' => $email,
            ':password' => md5($password)
        ]);
    }

    public function is_favourite($login, $postID) {
        $db = $this->connect();
    
        if ($db === null) {
            // Obsługa braku połączenia z bazą danych
            return [];
        }
    
        $sql = 'SELECT ID FROM favourite WHERE UserID = (SELECT UserID FROM users WHERE login=:login) AND PostID=:postID';
    
        $smt = $db->prepare($sql);
        $smt->execute([
            ':login' => $login,
            ':postID' => $postID
        ]);
    
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
        
        return !empty($data);
    }
    

    public function put_favourite($login, $postID, $counter){
        $db = $this->connect();
    
        if($db == null)
            return [];
        
        try{

            $sql = "INSERT INTO favourite (UserID, PostID) 
                VALUES ((SELECT UserID FROM users WHERE login=:login), :postID)";

            $smt = $db->prepare($sql);
            $smt->execute([
                ':login' => $login,
                ':postID' => $postID
            ]);

            $this -> update_post_counters('likes', $postID, $counter);

        }catch(PDOException $e){
            $data['error'] = $e ->getMessage();
        }

    }

    public function delete_favourite($login, $postID, $counter){
        $db = $this->connect();
    
        if($db == null)
            return [];
        
        try{

            $sql = "DELETE FROM favourite
            where UserID=(SELECT UserID FROM users WHERE login=:login)and PostID=:postID";

            $smt = $db->prepare($sql);
            $smt->execute([
                ':login' => $login,
                ':postID' => $postID
            ]);

            $this -> update_post_counters('likes', $postID, $counter);

        }catch(PDOException $e){
            $data['error'] = $e ->getMessage();
        }

    }
    
    private function update_post_counters($type, $postID, $counter){
        $db = $this->connect();
    
        if($db == null)
            return [];
    
        $sql = "UPDATE post 
                SET $type = $type + :counter 
                WHERE PostID = :postID";
    
        $smt = $db->prepare($sql);
        $smt->execute([
            ':postID' => $postID,
            ':counter' => $counter
        ]);
    }
    

    private function connect(){
        try {
            return new PDO(CONFIG['db'], CONFIG['db_user'], CONFIG['db_password']);
        }catch (PDOException $e){
            return  null;
        }
    }

    
    

}