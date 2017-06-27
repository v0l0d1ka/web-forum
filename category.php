<?php

include 'connect.php';
include 'header.php';
//во-первых выберем категорию из перемен-й $_GET['cat_id']
$sql_query = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . mysql_real_escape_string($_GET['cat_id']);

$result_rows = mysql_query($sql_query);

if(!$result_rows)
{
//    echo 'The category could not be displayed, please try again later.' . mysql_error();
    echo 'Категория не может быть отображена, попробуйте позже.' . mysql_error();
}
else
{
    if(mysql_num_rows($result_rows) == 0)
    {
       // echo 'This category does not exist.';
        echo 'Этой категории не существует.';
    }
    else
    {
        //Вывести данные категории
        while($row = mysql_fetch_assoc($result_rows))
        {
            echo '<h2>Темы в  "' . $row['cat_name'] . '" категории</h2>';
        }
        //выполнить запрос чтобы вернул новые темы
        $sql_query = "SELECT
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysql_real_escape_string($_GET['cat_id']);

        $result_rows = mysql_query($sql_query);

        if(!$result_rows)
        {
           // echo 'The topics could not be displayed, please try again later.';
            echo 'Темы не могут быть показаны, попробуйте позже.';
        }
        else
        {
            if(mysql_num_rows($result_rows) == 0)
            {
                //echo 'There are no topics in this category yet.';
                echo 'В этой категории нет новых тем';
            }
            else
            {
                //создадим таблицу
                echo '<table border="1">
                      <tr>
                        <th>Тема</th>
                        <th>Дата создания</th>
                      </tr>';
                while($row = mysql_fetch_assoc($result_rows))
                {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($row['topic_date']));
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
    }
}
include 'footer.php';

