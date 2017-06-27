<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 09.01.2017
 * Time: 9:23
 */
include 'connect.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //кто-то пытается запуситить скрипт напрямую. Русские хакеры?
    echo 'Этот файл не может быть запущен .';
}
else
{
    //проверить, если вошел этот пользователь
    if(!$_SESSION['signed_in'])
    {
        echo 'Вам нужно зарегистироваться, чтобы ответить!.';
    }
    else
    {
        //зарегенный  пользователь может оставлять сообщения
        $sql_query = "INSERT INTO
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by)
                VALUES ('" . mysql_real_escape_string($_POST['reply-content']) . "',
                        NOW(),
                        " . mysql_real_escape_string($_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";

        $result_rows = mysql_query($sql_query);

        if(!$result_rows)
        {
            mysql_error();
            echo 'ваше сообщение не сохранилось.Попробуйте позже.';
        }
        else
        {
            echo 'Ваше сообщение сохранено, проверьте <a href="topic.php?id=' . htmlentities($_GET['id']) . '">тему</a>.';
        }
    }
}

include 'footer.php';