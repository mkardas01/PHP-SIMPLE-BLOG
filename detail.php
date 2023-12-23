<?php
require('app/app.php');

if(isset($_GET['post'])){
    $data = Data::get_post($_GET['post']);

    if(empty($data)){
        view('not_found');
        die();
    }

}else{
    view('not_found');
    die();
}

$view_bag['author'] = Data::get_author($_GET['post']);


view('detail',$data[0]);
