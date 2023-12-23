<?php

require('../app/app.php');
$data = [
    'status' => ''
];

session_start();
if($_POST['type'] == 'add' && user_logged()){
    $comment = $_POST['comment'];

    $data['info'] = Data::save_comment($comment, $_SESSION['login'], $_POST['postID']);
    $data['commentSection'] = Data::get_comments($_POST['postID'], $_SESSION['login']);
    
}else if($_POST['type'] == 'delete' && user_logged()){
    Data::delete_comment($_POST['commentID'],$_SESSION['login'],  $_POST['postID'], isset($_SESSION['admin']) ? $_SESSION['admin'] : null);

}else if($_POST['type'] == 'edit' && user_logged()){
    $data['info'] = Data::update_comment($_POST['commentID'], $_POST['comment'], $_SESSION['login'], isset($_SESSION['admin']) ? $_SESSION['admin'] : null);
}

echo json_encode($data);

session_write_close();



