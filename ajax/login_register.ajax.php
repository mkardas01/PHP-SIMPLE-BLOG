<?php

require('../app/app.php');

if(isset($_POST['submit']) && in_array($_POST['submit'], ['login_in','register'])){

    

    session_start();
    $type = $_POST['submit'];

    $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if($type == 'login_in'){
        if(empty($login) || empty($password)){
            send_status('Podaj login i hasło!');
            
        }else{
            if(Data::user_exists($login, $password, 'login')){
      
                $_SESSION['login'] = $login;
                
                if(Data::is_admin($login, $password)){
                    $_SESSION['admin'] = 'true';
                }
                send_status('Sukces!', 'text-success', true);
            }
            else{
                send_status('Podany login lub hasło są nieprawidłowe!');
            }
        }

        
    }
    else if($type == 'register'){

        $password2 = $_POST['password2'];

        if(empty($login) || empty($email) || empty($password) || empty($password2)){
            send_status('Wszystkie pola muszą być wypełnione!');
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            send_status('To nie jest adres email!');
        } else if($password != $password2){
            send_status('Hasła muszą być takie same!');
        } else{
            if(Data::user_exists($login, null, 'login') || Data::user_exists($login, null, 'email')){
                send_status('Taki użytkownik lub email już są w użyciu!');
            } else{
                if(Data::register_user($login, $email,$password)){
                    $_SESSION['login'] = $login;
                    send_status('Sukces!', 'text-success', true);
                }else
                    send_status('Wystąpił błąd, spróbuj ponownie!');
            }
        }
    }
}

send_status('Wystąpił błąd serwera!');