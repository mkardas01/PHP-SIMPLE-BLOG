<?php

require('mysqldataprovider.class.php');


class Data {
    static private $ds;
    static public function initialize($data_source) {
        return self::$ds = $data_source;
    }

    static public function get_posts(){
        return self::$ds->get_posts();
    }

   static public function get_post($id){
        return self::$ds->get_post($id);
    }

    static public function get_author($post_id){
        return self::$ds->get_author($post_id);
    }

    static public function search_post($search){
        return self::$ds->search_post($search);

    }

    static public function save_post($post, $login){
        return self::$ds->save_post($post, $login);

    }
    static public function delete_post($post){
        return self::$ds->delete_post($post);

    }

    static public function get_comments($post, $login = null){
        return self::$ds->get_comments($post, $login);

    }

    static public function save_comment($comment, $login, $postID){
        return self::$ds->save_comment($comment, $login, $postID);

    }

    static public function update_comment($commentID, $comment, $login, $admin = null){
        return self::$ds->update_comment($commentID, $comment, $login, $admin);

    }

    static public function delete_comment($commentID, $login, $postID, $admin = null){
        return self::$ds->delete_comment($commentID, $login, $postID, $admin);

    }

    static public function user_exists($user, $password, $type){
        return self::$ds->user_exists($user, $password, $type);

    }

    static public function is_admin($login, $password){
        return self::$ds->is_admin($login, $password);

    }

    static public function register_user($login, $email, $password){
        return self::$ds->register_user($login, $email, $password);
    }

    static public function is_favourite($login, $postID){
        return self::$ds->is_favourite($login, $postID);

    }

    static public function put_favourite($login, $postID, $counter){
        return self::$ds->put_favourite($login, $postID, $counter);
    }
    static public function delete_favourite($login, $postID, $counter){
        return self::$ds->delete_favourite($login, $postID, $counter);
    }

    static public function update_post_counters($type, $postID, $counter){
        return self::$ds->update_post_counters($type, $postID, $counter);

    }
}