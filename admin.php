<?php
require('app/app.php');

session_start();
if(!isset($_SESSION['admin'])){
    redirect('index');
}
session_write_close();

$data = [];
$name = 'default';

// if(!isset($_GET['post_menage']) && !isset($_GET['edit']) && !isset($_GET['post_add']))
//     $name = 'default';

if(isset($_GET['post_menage']))
    $name = 'post.menage';

if(isset($_GET['post_add']))
    $name = 'post.form';

if(isset($_GET['edit'])){
    $name = 'post.form';
    $data = Data::get_post($_GET['edit'])[0];
}
else if(!isset($_POST['save_post']))
    $data = Data::get_posts(); //table with posts in default view
    
if(isset($_GET['delete']))
    Data::delete_post($_GET['delete']);
    
if(isset($_POST['save_post'])){
    Data::save_post($_POST, $_SESSION['login']);
    redirect('admin');
}

view('admin/admin.'.$name, $data, 'admin/admin');