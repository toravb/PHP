<?php
require_once './components/db.php';
require_once './config/data.php';
require_once 'controllers/FrontController.php';
?>
<form method="get">
    <input type="submit" name="register" value="Я новый пользователь">
    <input type="submit" name="login" value="Я уже зарегистрирован">
</form>