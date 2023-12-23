<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Blog </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/layout.view.css">
    <link rel="stylesheet" href="views/css/<?= isset($diffCss) ? $diffCss : $name ?>.view.css">

</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="http://nemesis96.ct8.pl/">Blog</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Kontakt</a>
                </li>
                <li>
                    <form class="d-flex" role="search" method="GET" action="main">
                        <div class="wrapper">
                            <input class="form-control" type="search" placeholder="Szukaj" aria-label="Search" name="search_post" id="search_post">
                            <button class="btn" type="submit"><i class="fas fa-search" style="color: #a688fa;"></i></button>

                        </div>
                    </form>
                </li>
            </ul>

              <div class="login-div">
                    <?php 
                    session_start();
                    
                    if(user_logged()){

                        echo '<p><i class="fa-regular fa-user"></i> &nbsp; &nbsp;'.$_SESSION['login'].'</p>';
                        echo '<a class="btn ml-3" aria-current="page" href="logout">Wyloguj </a>';

                    }else {
                        echo '<a class="btn " aria-current="page" href="login">Zaloguj </a>';
                    }?>

              </div>

            <?php  
                if(isset($_SESSION['admin'])){
                    echo '<div class="admin-div">';
                        echo '<a class="btn " aria-current="page" href="admin">Administracja </a>';
                    echo '</div>';
                }
                
                session_write_close(); 
            ?>

          </div>

          

        </div>

    </nav>

    <?php require("$name.view.php") ?>

    <script src="https://kit.fontawesome.com/1e9872fbce.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>            
</body>
</html>