<?php
require('app/app.php');

$dataProvider = new MySqlDataProvider();

try{
    if(isset($_GET['search_post'])){
        $data = Data::search_post($_GET['search_post']);
    }else{
        $data = Data::get_posts();
    }

    if(empty($data)){
        view('not_found');
        die();
    }

}catch(Exception $e){
    view('not_found');
    die();
}

if(isset($_POST['login'])){
    view('login');
    die();
}

view('index', $data);
