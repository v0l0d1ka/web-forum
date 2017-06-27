<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.01.2017
 * Time: 22:39
 */
include 'connect.php';
include 'header.php';
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";

$result = mysql_query($sql);
if (!$result) {
    echo 'категории не могут быть показаны. Попробуйте позже.';
} else {
    if (mysql_num_rows($result) == 0) {
        echo ' Не создано категорий. Обратитесь к администратору. ';
    } else {
        //создать таблицу html
        echo '<table border="1">
              <tr>
                <th>Категория</th>
                <th>Последняя тема</th>
              </tr>';

        while ($row = mysql_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td class="leftpart">';
            echo '<h3><a href="category.php?cat_id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
            echo '</td>';

            $sql1 = "SELECT * FROM
                      topics
                      WHERE
                      topic_cat=" . $row['cat_id'] .
                " ORDER BY topic_id DESC LIMIT 1";

            $res = mysql_query($sql1);
            if ($res) {
                $row1 = mysql_fetch_assoc($res);
                if ($row1) {
                    echo '<td class="rightpart">';
                    echo '<a href="topic.php?id=' . $row1['topic_id'] . '">' . $row1['topic_subject'] .
                        '</a> at <em>' .
                        date('d-m-Y', strtotime($row1['topic_date'])) . '</em>';
                    echo '</td>';
                    echo '</tr>';

                } else {
                    echo '<td class="rightpart">';
                    echo 'Нет новых тем';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo mysql_error();
            }
//            echo '<td class="rightpart">';
//            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
//            echo '</td>';
//            echo '</tr>';
        }
    }
}
echo '</table>';
include 'footer.php';
