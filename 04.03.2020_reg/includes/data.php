<?php
require_once ('db.php');
?>

<?php
$login = $_POST['login'];
$password = $_POST['password'];
$c_password = $_POST['confirm_password'];
$u_name = $_POST['name'];
$s_name = $_POST['s_name'];
$age = $_POST['age'];
$email = $_POST['email'];
?>

<?php //запросы в бд на присутствие логина и email
$count_email = $connect ->prepare("SELECT * FROM username WHERE email = :email");
$count_email->bindValue(':email', $email, PDO::PARAM_STR);
$count_email->execute();
$c_email= $count_email->fetch();

$count_data = $connect ->prepare("SELECT * FROM users WHERE login = :login OR email = :email");
$count_data->bindValue(':login', $login, PDO::PARAM_STR);
$count_data->bindValue(':email', $email, PDO::PARAM_STR);
$count_data->execute();
$c_data = $count_data->fetch();
?>
