

<?php session_start();
//$_SESSION['signed_in']=false;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="description" content="A lite forum." />
    <meta name="keywords" content="forum, computers, garden, hobby" />
    <title>PHP-MySQL forum</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Lite forum</h1>
    </div>
</div>

<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
        <li><a  href="/forum/index.php">Главная</a></li>
        <li><a  href="/forum/create_topic.php">Новая тема</a></li>
        <li><a  href="/forum/create_cat.php">Новая категория</a></li>


            <div class="pull-right">
                <?php
                if(isset($_SESSION['signed_in']))
                {
                echo 'Привет ' .
                      $_SESSION['user_name'] .
                      '. Не вы? <a class="btn btn-danger navbar-btn" href="signout.php">Выйти</a>';
                }
                else
                {
                echo '<a href="signin.php" class="btn btn-danger navbar-btn">Войти</a>
                      или <a href="signup.php" class="btn btn-danger navbar-btn">Регистрация</a>';
                }
                ?>
            </div>
            </ul>
        </div>
    </nav>
        <div id="content">
