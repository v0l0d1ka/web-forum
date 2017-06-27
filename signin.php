<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.12.2016
 * Time: 18:28
 */
//signin.php

include 'connect.php';
include 'header.php';

echo '<h3 class="sign-in-h3">Войти</h3>';

//сначала проверим вошел ли пользователь, если да то не нужно отображать эту страницу
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Вы уже вошли и можете <a href="signout.php">выйти</a> если хотите.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        /*данные формы еще не отправлены
          отметьте, что action="" обработчик формы на этой же странице */
        echo '<form method="post" action="">
            Имя пользователя: <input type="text" name="user_name" />
            Пароль: <input type="password" name="user_pass">
            <input type="submit" class="btn btn-warning" value="Войти" />
         </form>';
    }
    else
    {
        /* значит, дфнные формы еще не отправлены, сделаем три вещи:
            1.  проверим данные
            2. заполнить не правильно созданные поля
            3.  проверить правильные ли данные, и сообщить пользов-лю
        */
        $errors = array(); /* создать массив для дальнейшего использования */

        if(!isset($_POST['user_name']))
        {
            $errors[] = 'Имя пользователя не должно быть пустым.';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'пароль не должен быть пустым.';
        }

        if(!empty($errors)) /*проверить массив если есть ошибки(отметим ! оператор)*/
        {
            echo 'Не все поля заполнены!';
            echo '<ul>';
            foreach($errors as $key => $value) /* Проверим массив -  не остались ли ошибки */
            {
                echo '<li>' . $value . '</li>'; /* Выведем ошибки в форме списка */
            }
            echo '</ul>';
        }
        else
        {
            //форма сохранена ошибок нет
            //отметим mysql_real_escape сохраняет приложение в безопасности!
            //отметим также что пароль сохраняется в хешированом виде sha1 
            $sql = "SELECT
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";

            $result = mysql_query($sql);
            if(!$result)
            {
                //ошибка
                echo 'ошибка входа. Попробуйте позже.';
                
            }
            else
            {
                //запрос успешно выполнен, есть две возможности
                //1. запрос вернул данные - пол-ль может войти
                //2. запрос вернул не данные - такогопользователя не существует
                if(mysql_num_rows($result) == 0)
                {
                    echo 'вы не правильно ввели логин\пароль. Попробуйте еще раз.';
                }
                else
                {
                    //устаговить переменную $_SESSION['signed_in']  TRUE
                    $_SESSION['signed_in'] = true;

                    //также добавим имя , id в массив  $_SESSION, чтобы использовать на других страницах
                    while($row = mysql_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    echo 'Добро пожаловать, ' . $_SESSION['user_name'] . '. <a href="index.php">Перейдите к обзору форума</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>