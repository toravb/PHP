<?php
$verify = false;
if (isset($_POST['register'])) {

    $verify_login = preg_match("/^[a-zA-Z0-9]+$/", $login);
    $len_login = strlen($login);
    $len_pass = strlen($pass);

    $count = $connect->prepare("SELECT * FROM users WHERE email = :email OR login = :login");
    $count->bindValue(':login', $login, PDO::PARAM_STR);
    $count->bindValue(':email', $email, PDO::PARAM_STR);
    $count->execute();
    $data = $count->fetch();

    if (!$verify_login) {
        echo 'Логин может состоять только из букв английского алфавита и цифр';
    } elseif ($len_login < 3 or $len_login > 16) {
        echo 'Логин должен быть не меньше 3-х символов и не больше 16';
    } elseif ($len_pass > 16 or $len_pass < 5) {
        echo 'Пароль должен содержать от 5 до 16 двух символов';
    } elseif ($pass != $c_pass) {
        echo 'Пароли не совпадают';
    } elseif ($data['email'] == $email) {
        echo 'Указанный email кем-то используется';
    } elseif ($data['login'] == $login) {
        echo 'Указаный логин кем-то используется';
    } else {
        $pass = password_hash($password, PASSWORD_DEFAULT);

        $reg = $connect->prepare("INSERT INTO users (`name`, `s_name`, `age`, `email`, `login`) VALUES (:u_name, :s_name, :age, :email, :login); INSERT INTO `username`(`email`, `password`) VALUES (:email, :pass)");
        $reg->bindValue(':u_name', $u_name, PDO::PARAM_STR);
        $reg->bindValue(':s_name', $s_name, PDO::PARAM_STR);
        $reg->bindValue(':age', $age, PDO::PARAM_STR);
        $reg->bindValue(':email', $email, PDO::PARAM_STR);
        $reg->bindValue(':login', $login, PDO::PARAM_STR);
        $reg->bindValue(':pass', $pass, PDO::PARAM_STR);
        $reg->execute();

        $verify = true;
    }
}