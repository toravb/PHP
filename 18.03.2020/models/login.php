<?php
$verify = false;
if (isset($_POST['login'])) {

    $count = $connect->prepare("SELECT * FROM username WHERE email=:email");
    $count->bindValue(':email', $email, PDO::PARAM_STR);
    $count->execute();
    $data = $count->fetch();

    if($count->rowCount() == 0) {
        echo'Пользователь с таким email не зарегистрирован';

    }elseif ($count->rowCount() == 1 and password_verify($pass, $data['password']) == false) {
        echo 'Вы ввели неверный пароль';

    }
    else {
        $verify = true;
    }
}
