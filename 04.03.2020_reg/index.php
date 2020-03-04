<?php
if ($_COOKIE['user'] != ""){
    exit ("$_COOKIE[user], Вы все еще на сайте!");
}
?>
<DOCTYPE html>
    <html>
    <head>
        <title>пароль</title>
    </head>
    <body>
    <form action="index_reg.php" method="">
        <button>Я новый пользователь</button>
    </form>
    <form action="index_login.php" method="">
        <button>Я уже зарегистрирован</button>
    </form>
    </body>
    </html>