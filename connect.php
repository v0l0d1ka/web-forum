<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.12.2016
 * Time: 17:33
 */
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'forum';

if(!mysql_connect($server, $username,  $password))
{
    exit("Error: could not establish database connection");
}
if(!mysql_select_db($database))
{
    exit("Error: could not select the database");
}

error_reporting(0);
?>