<?php
require_once('includes/db.php');
$test = "name";
setcookie("test_cookie", $test, time() + 60*5);
?>
<?php
//вытягиваетм логин из бд, если он там есть. Вытягиваем пароль в соответствии с логином для проверки
$login = $_POST['login'];
$password = $_POST['password'];

$count_data = $connect ->prepare("SELECT * FROM username WHERE login = :login");
$count_data->bindValue(':login', $login, PDO::PARAM_STR);
$count_data->execute();

$count = $connect ->prepare("SELECT `password` FROM `username` WHERE `login` = :login");
$count->bindValue(':login', $login, PDO::PARAM_STR);
$count->execute();
$count_pass = $count->fetch();

//вывод ошибок, если логин содержит спец. символы. Ограничение по длине логина и пароля, если логин есть в бд, но пароль введен неверно - выведется соответствующая ошибка
if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
{
    echo 'Логин может состоять только из букв английского алфавита и цифр<br/>';
    exit();
}
elseif(strlen($login) < 3 or strlen($login) > 16)
{
    echo 'Логин должен быть не меньше 3-х символов и не больше 16<br/>';
    exit();
}
if($count_data->rowCount() == 0) {
    echo 'Пользователь с таким логином не найден<br/>';
    exit();
}
elseif ($count_data->rowCount() == 1 and $count_pass["password"] != $password){
    echo 'Вы ввели неверный пароль<br/>';
    exit();
}//если логин и пароль совпадают с бд, система поприветствует пользователя в соответствии с именем, которое он указал при регистрации
else{
    $count_name = $connect->prepare("SELECT `name`, `s_name` FROM `users` WHERE `login` = :login");
    $count_name->bindValue(':login', $login, PDO::PARAM_STR);
    $count_name->execute();

    while ($name = $count_name->fetch()){
        echo "$name[name] $name[s_name], приветствуем тебя!<br/>";
    }
}
?>
