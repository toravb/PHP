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

//получаем id за 2 месяца
$user_id = $connect ->prepare("SELECT * FROM `user_id` WHERE MONTH(`date`) = :currentMonth OR MONTH(`date`) = :nextMonth");
$user_id->bindValue(':currentMonth', $currentMonth, PDO::PARAM_STR);
$user_id->bindValue(':nextMonth', $nextMonth, PDO::PARAM_STR);
$user_id->execute();
$user_id->setFetchMode(PDO::FETCH_ASSOC);
$user_id = $user_id->fetchAll();

$id = array();

for ($i = 0; $i < count($user_id); $i++){
    $id[] = $user_id[$i]['id'];
}

//получаем список пользователей и их ссылки
$data = $connect->prepare("SELECT `author`, `link` FROM `link` WHERE `id` IN ('". implode("','", $id) ."')");
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
if ($user_id != null) {
    for ($i = 0; $i < count($data); $i++) {
        echo 'Пользователь: ' . $data[$i]['author'] . "<br>" . 'Оставил ссылку: ' . $data[$i]['link'] . "<br>" . $user_id[$i]['date'] . "<hr>";
    }
}else{
    echo 'В течении двух месяцев никто не оставлял ссылки';
}
?>