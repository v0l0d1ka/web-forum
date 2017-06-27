<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 05.01.2017
 * Time: 16:17
 */
//create_cat.php
include 'connect.php';
include 'header.php';

echo '<h2>Новая тема</h2>';
if($_SESSION['signed_in'] == false)
{
    //пользователь не вошел
    echo 'Извините, вам нужно <a href="signin.php">зарегистрироваться</a> чтобы создать новую тему.';
}
else
{
    //пользователь вошел
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        //выведем форму для создания новой темы
        //получить список всех категории для выпадющего списка формы
        $sql_query = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";

        $result_rows = mysql_query($sql_query);

        if(!$result_rows)
        {
            //ошибка БД :-(
            echo 'Error while selecting from database. Please try again later.';
            echo 'Ошибка выборки из базы данных';
        }
        else
        {
            if(mysql_num_rows($result_rows) == 0)
            {

                if($_SESSION['user_level'] == 1)
                {
                    echo 'Вы пока не создали ни одной категории.';
                }
                else
                {
                    echo 'У вас нет прав создавать новые категории.';
                }
            }
            else
            {

                echo '<form method="post" class="new-theme-form" action="">
                    Заголовок: <input type="text" name="topic_subject" />
                    Категория:';

                echo '<select name="topic_cat">';
                while($row = mysql_fetch_assoc($result_rows))
                {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select>';

                echo 'Сообщение: <textarea name="post_content" /></textarea>
                    <input type="submit" class="btn btn-warning new-theme" value="Создать тему" />
                 </form>';
            }
        }
    }
    else
    {
        //начать транзакцию
        $query  = "BEGIN WORK;";
        $result_rows = mysql_query($query);

        if(!$result_rows)
        {
            //ошибка запроса к базе даных
            echo 'Произошла ошибка. Новая тема не может быть создана. Поробуйте позже';
        }
        else
        {

            //форма былаотправлена обработать данные
            //добаввим созданную тему в базу данных, заголоовк  сообщенеи в таблицу topics
            $sql_query = "INSERT INTO
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysql_real_escape_string($_POST['topic_subject']) . "',
                               NOW(),
                               " . mysql_real_escape_string($_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";

            $result_rows = mysql_query($sql_query);
            if(!$result_rows)
            {
                //произошла ошибка откат роллбэк
                echo 'Произошла ошибка новая тема небыла создана.' . mysql_error();
                $sql_query = "ROLLBACK;";
                $result_rows = mysql_query($sql_query);
            }
            else
            {
                //создадим второй запрос к бд
                //вернуть id последней созданной темы для создания запроса
                $topic_id = mysql_insert_id();

                $sql_query = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysql_real_escape_string($_POST['post_content']) . "',
                                  NOW(),
                                  " . $topic_id . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result_rows = mysql_query($sql_query);

                if(!$result_rows)
                {
                    //произошла ошибка - откат роллбэк

                    echo 'Произошла ошибка при добавлении нового сообщениея. Попробуйте позже.' . mysql_error();
                    $sql_query = "ROLLBACK;";
                    $result_rows = mysql_query($sql_query);
                }
                else
                {
                    $sql_query = "COMMIT;";
                    $result_rows = mysql_query($sql_query);

                    //все данные успешно добавили в бд!
                    echo 'Вы успешно создали <a href="topic.php?id='. $topic_id . '">новую тему</a>.';
                }
            }
        }
    }
}

include 'footer.php';