<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 08.01.2017
 * Time: 21:33
 */
include 'connect.php';
include 'header.php';

//вернем основную информацию о теме
$sql = "SELECT
         topic_id,
          topic_subject
        FROM
          topics
        WHERE
          topics.topic_id = " . mysql_real_escape_string($_GET['id']);


$result_rows = mysql_query($sql);

echo '<table border="1">';
if($result_rows)
{
    $row = mysql_fetch_assoc($result_rows);
    echo '<tr>';
    echo '<th colspan="2" style="text-align: center">' . $row['topic_subject'] . '</th>';
    echo '</tr>';
}

//Вернем все сообщения из темы
$sql = "SELECT
    posts.post_topic,
    posts.post_content,
    posts.post_date,
    posts.post_by,
    users.user_id,
    users.user_name
FROM
    posts
LEFT JOIN
    users
ON
    posts.post_by = users.user_id
WHERE
    posts.post_topic = " . mysql_real_escape_string($_GET['id']) .
    " ORDER BY UNIX_TIMESTAMP(posts.post_date) ASC";

$result_rows = mysql_query($sql);
if($result_rows)
{
    while($row = mysql_fetch_assoc($result_rows)){
        echo '<tr>';
        echo '<td style="width: 20%">' . $row["user_name"] .
            '<br>'. date("d-m-Y", strtotime($row['post_date'])) .'</td>';
        echo '<td style="width: 80%">' . htmlentities($row["post_content"]). '</td>';
        echo '</tr>';
    }
}else{
    echo mysql_error();
}


echo '</table>';
echo '<h2>Ответить:</h2>';
echo '<form method="post" action="reply.php?id=' .$_GET["id"] . '">
    <textarea name="reply-content"></textarea>
    <br>
    <input type="submit" value="Отправить ответ" />
</form>';

include 'footer.php';