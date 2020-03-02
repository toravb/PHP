<?php
require_once('includes/db.php');
//узнаем текущую страницу
$page = $_GET['page'];
//вытягиваетм количество записей из бд
$result = $connect->query("SELECT COUNT(*) FROM `articles`");
$posts = $result->fetch();
$total = $posts[0];
//если $page слишком велико - перейти на последнюю страницу, если меньше 1 то на первую
if (empty($page) or $page < 0) {
    $page = 1;
}
if ($page > $total) {
    $page = $total;
}
//определяем какую запись вывести, заполняем массив
$start = $page - 1;
$result = $connect->query("SELECT * FROM `articles` LIMIT $start, 1");
while ($postrow[] = $result->fetch());
?>
<?php
//вывод статьи в соответствии с страницой
echo "<table>";
for($i = 0; $i < 1; $i++){
    echo "<tr>
         <td>".$postrow[$i]['title']."</td>
         <td>".$postrow[$i]['pubdate']."</td></tr>
       <tr><td colspan=\"2\">".$postrow[$i]['text']."</td></tr>";
}
echo "</table>";
?>
<?php
//если находимся на первой странице, то не выводить стрелки назад, если на последней то вперед
if ($page != 1) {
    $pervpage = '<a href= ./index.php?page=1><<</a> <a href= ./index.php?page='. ($page - 1) .'><</a> ';
}
if ($page != $total) {
    $nextpage = ' <a href= ./index.php?page=' . ($page + 1) . '>></a><a href= ./index.php?page=' . $total . '>>></a>';
}
//находим 2 страницы вперед и назад, если они существеют
if($page - 2 > 0) {
    $page2left = ' <a href= ./index.php?page=' . ($page - 2) . '>' . ($page - 2) . '</a> | ';
}
if($page - 1 > 0) {
    $page1left = '<a href= ./index.php?page=' . ($page - 1) . '>' . ($page - 1) . '</a> | ';
}
if($page + 2 <= $total) {
    $page2right = ' | <a href= ./index.php?page=' . ($page + 2) . '>' . ($page + 2) . '</a>';
}
if($page + 1 <= $total) {
    $page1right = ' | <a href= ./index.php?page=' . ($page + 1) . '>' . ($page + 1) . '</a>';
}
//вывод навигации
echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;
?>
<?php //быстрый переход по страницам
echo "<form action='index.php' method='get'>";
echo "<input type='text' placeholder='Введите № страницы' name='page'>";
echo "<input type='submit' value='Перейти'>";
echo "</form>"
?>
<?php
exit();
?>
