<?php
require_once 'components/db.php';
?>

<?php
//получаем дату, если в дате ничего не указано, будет выбрана текущая
$date = $_GET['date'];
if ($date != null){
    $date = $_GET['date'];
}else{
    $date = date('Y-m-d');
}
$currentMonth = date('m', strtotime($date));
$nextMonth = $currentMonth + 1;

//получаем дату, имя пользователя и ссылку по id из первой таблицы
$data = $connect->prepare("SELECT user_id.date, link.author, link.link FROM user_id  LEFT JOIN link ON  user_id.id = link.id WHERE MONTH(`date`) = :currentMonth OR MONTH(`date`) = :nextMonth");
$data->bindValue(':currentMonth', $currentMonth, PDO::PARAM_STR);
$data->bindValue(':nextMonth', $nextMonth, PDO::PARAM_STR);
$data->execute();
$data->setFetchMode(PDO::FETCH_ASSOC);
$data = $data->fetchAll();
?>

<form method="get">
    <input type="date" name="date">
    <input type="submit" value="Отправить">
</form>

<?php
//выводим данные
if ($data != null) {
    for ($i = 0; $i < count($data); $i++) {
        echo 'Пользователь: ' . $data[$i]['author'] . "<br>" . 'Оставил ссылку: ' . $data[$i]['link'] . "<br>" . $data[$i]['date'] . "<hr>";
    }
}else{
    echo 'В течении двух месяцев никто не оставлял ссылки';
}
?>

