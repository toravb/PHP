<?php
if ($_COOKIE['test_cookie'] != ""){
    echo 'Привет, '. $_COOKIE['test_cookie'] . '!';
    exit();
}
?>

<form method="post" action="/reg.php">
    <input type="text" placeholder="Ваше имя" name="name" required>
    <input type="text" placeholder="Ваша фамилия" name="s_name" required>
    <input type="number" placeholder="Ваш возраст" name="age" required>
    <hr>
    <input type="email" placeholder="Ваша почта" name="email" required>
    <hr>
    <input type="text" placeholder="Ваш логин" name="login" required>
    <input type="password" placeholder="Ваш пароль" name="password" required>
    <input type="password" placeholder="Подтвердите пароль" name="confirm_password" required>
    <hr>
    <input type="submit" value="Зарегистрироваться">
</form>
<form action="/login_index.php">
    <button>Я уже зарегистрирован</button>
</form>
