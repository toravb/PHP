<?php
require_once('includes/db.php');
//вытягиваю количество записей из бд
$id_a = $connect->query("SELECT COUNT(*) FROM `articles`");
$id_count = $id_a->fetch();
//нужна на случай ошибки, или первого запуска
$num = 1;
//сверка введенной страницы с числом записей
if (($_GET['number']) > $id_count[0] or ($_GET['number']) < 1)
{
    echo 'Указаной страницы не существует, была открыта первая страница';
}
//присвоение
else {
    $num = $_GET['number'];
}
//название записи и текст в соответствии с номером
$title = $connect->prepare("SELECT `title`, `text` FROM `articles` WHERE `id`= :num");
$title->bindValue(':num', $num, PDO::PARAM_STR);
$title->execute();
$title_count = $title->fetch();

?>
    <!--вывод-->
    <form action=index.php method="get">
    <h2><?php echo $title_count["title"]; ?></h2>
    <p><?php echo $title_count["text"] ?></p>
    <input type="number" placeholder="№ страницы" name="number">
        <input type="submit" value="Перейти">
    </form>

<?php
exit();
?>
