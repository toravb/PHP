<?php
setcookie("user", 'Пользователь', time() + 10*60);
require_once ('includes/data.php');
?>

<?php //проверка email в бд, проверка пароля на валидность
if($count_email->rowCount() == 0) {
    exit('Пользователь с таким email не зарегистрирован');
}
elseif ($count_email->rowCount() == 1 and password_verify($password, $c_email["password"]) == false){
    exit('Вы ввели неверный пароль');
}
else {
    echo "$c_data[name], приветствуем тебя!";
}
?>
