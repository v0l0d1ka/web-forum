<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 04.12.2016
 * Time: 17:38
 */
include 'connect.php';
include 'header.php';
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //Вывести на экран форму создания категории
    echo '<form method="post" action="">
        Название категории: <input type="text" name="cat_name" />
        Описание категории: <textarea name="cat_description" /></textarea>
        <input type="submit" value="Создать категорию" />
     </form>';
}
else
{
    //данные формы отправлены методом post
    $sql = "INSERT INTO categories(cat_name, cat_description)
       VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
             '" . mysql_real_escape_string($_POST['cat_description']) . "');";
    $result = mysql_query($sql);
    if(!$result)
    {
        //ошибка баз данных, показать сообщение об ошибке
        echo 'Ошибка ' . mysql_error();
    }
    else
    {

        echo 'добавлена новоя категория.';
    }
}
?>
<!--    <table>-->
<!--        <tr>-->
<!--            <td class="leftpart">-->
<!--                <h3><a href="category.php?id=">Category name</a></h3> Category description goes here-->
<!--            </td>-->
<!--            <td class="rightpart">-->
<!--                <a href="topic.php?id=">Topic subject</a> at 10-10-->
<!--            </td>-->
<!--        </tr>-->
<!--    </table>-->
<?php
include 'footer.php';
?>