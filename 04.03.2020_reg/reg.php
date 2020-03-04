<?php
require_once ('includes/data.php');
?>

<?php //проверка логина и пароля на корректность
$verify_login = preg_match("/^[a-zA-Z0-9]+$/",$login);
$len_login = strlen($login);
$len_pass = strlen($password);
?>

<?php //если email и логин отсутствует в бд - регистрация прошла успешно
if (!$verify_login){
    exit('Логин может состоять только из букв английского алфавита и цифр');
}
elseif($len_login < 3 or $len_login > 16){
    exit('Логин должен быть не меньше 3-х символов и не больше 16');
}
elseif($len_pass > 16 or $len_pass < 5){
    exit('Пароль должен содержать от 5 до 16 двух символов');
}
elseif ($password != $c_password){
    exit('Пароли не совпадают');
}
elseif ($count_email->rowCount() == 1){
    exit('Указанный email кем-то используется');
}
elseif($count_data->rowCount() == 1){
    exit('Указаный логин кем-то используется');
}
else{
    $password = password_hash($password, PASSWORD_DEFAULT);

    $reg = $connect->prepare("INSERT INTO users (`name`, `s_name`, `age`, `email`, `login`) VALUES (:u_name, :s_name, :age, :email, :login); INSERT INTO `username`(`email`, `password`) VALUES (:email, :password)");
    $reg->bindValue(':u_name', $u_name, PDO::PARAM_STR);
    $reg->bindValue(':s_name', $s_name, PDO::PARAM_STR);
    $reg->bindValue(':age', $age, PDO::PARAM_STR);
    $reg->bindValue(':email', $email, PDO::PARAM_STR);
    $reg->bindValue(':login', $login, PDO::PARAM_STR);
    $reg->bindValue(':password', $password, PDO::PARAM_STR);
    $reg->execute();
    echo 'Поздравляем с регистрацией, используйте свои данные для входа';
    echo "<form action='index_login.php'><input type='submit' value='Перейти ко входу'></form>";
}
?>
