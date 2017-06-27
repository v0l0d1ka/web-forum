<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.01.2017
 * Time: 21:28
 */
session_start();
session_destroy();
//перенаправление на страницу входа
header('location:signin.php');
?>