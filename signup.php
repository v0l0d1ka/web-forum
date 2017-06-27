<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.12.2016
 * Time: 17:53
 */
//signup.php
include 'connect.php';
include 'header.php';

echo '<h3>Регистрация</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*данные формы еще не отправлены
           отметьте, что action="" обработчик формы на этой же странице */
    echo '<form method="post" action="">
        Имя пользователя: <input type="text" name="user_name" /><br>
        Пароль: <input type="password" name="user_pass"><br>
        Повторить пароль: <input type="password" name="user_pass_check"><br>
        E-mail: <input type="email" name="user_email"><br>
        <input type="submit" value="Создать аккаунт" />
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

    if(isset($_POST['user_name']))
    {
        //имя пользователя сущ-ет в бд
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'Имя пользователя может содержать цифры и буквы.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'Имя превышает лимит в 30 символов.';
        }
    }
    else
    {
        $errors[] = 'Поле имя пустое!.';
    }


    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'Веден не правильный пароль.';
        }
    }
    else
    {
        $errors[] = 'Поле пароля пустое.';
    }

    if(!empty($errors)) /*проверить массив если есть ошибки(отметим ! оператор)*/
    {
        echo 'Не все поля заполнены!..';
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
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . mysql_real_escape_string($_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysql_real_escape_string($_POST['user_email']) . "',
                        NOW(),
                        0)";

        $result = mysql_query($sql);
        if(!$result)
        {
            //ошибка
            echo 'Во время регистрации произошла ошибка . Попробуйте позже.';

        }
        else
        {
            echo 'Вы успешно зарегистрировались <a href="signin.php">Войдите</a> чтобы отправлять сообщения! :-)';
        }
    }
}

include 'footer.php';
?>