<?php
session_start();
require('app/app.php');

if(user_logged()){
    redirect('index');
}

session_write_close();

view('login_register');