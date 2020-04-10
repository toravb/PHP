<?php
require_once 'db.php';


class User
{
    public $email;
    public $pass;
    public $connect;

    public function __construct()
    {
        $this->email;
        $this->pass;
        $this->connect;
    }

    public static function register ($email, $pass, $connect){
        $data = $connect->prepare("SELECT * FROM users WHERE email = :email");
        $data->bindValue(':email', $email, PDO::PARAM_STR);
        $data->execute();
        $data = $data->fetch();

        if ($data != null){
            echo "Пользователь зарегистрирован";
        } else {
            $register = $connect->prepare("INSERT INTO users(email, password) VALUES (:email, :pass)");
            $register->bindValue(':email', $email, PDO::PARAM_STR);
            $register->bindValue(':pass', $pass, PDO::PARAM_STR);
            $register->execute();

            echo "Вы успешно зарегестрировались";
        }
    }

    public static function login ($email, $pass, $connect){
        $data = $connect->prepare("SELECT * FROM users WHERE email = :email");
        $data->bindValue(':email', $email, PDO::PARAM_STR);
        $data->execute();
        $data = $data->fetch();

        if ($data == null){
            echo "Пользователь не найдет";
        }elseif ($data['password'] != $pass){
            echo "Введен неверный пароль";
        }else{
            echo "Вы успешно вошли";
        }
    }
}
$user = new User($_POST['email'], $_POST['password'], $connect);

if (isset($_POST['login'])){
    User::login($_POST['email'], $_POST['password'], $connect);
}
if (isset($_POST['register'])){
    User::register($_POST['email'], $_POST['password'], $connect);
}
?>




<form method="POST" action="">
    <input type="email" placeholder="Ваш email" name="email" required>
    <input type="password" placeholder="Ваш пароль" name="password" required>
    <hr>
    <input type="submit" value="Войти" name="login">
    <input type="submit" value="Зарегистрироваться" name="register">
</form>
