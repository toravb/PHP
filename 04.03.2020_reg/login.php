<?php
setcookie("user", 'Пользователь', time() + 10*60);
require_once ('includes/data.php');
?>

<?php //проверка email в бд, проверка пароля на валидность
if($count_email->rowCount() == 0) {
    exit('Пользователь с таким email не зарегистрирован');
}
elseif ($count_email->rowCount() == 1 and password_verify($password, $c_email["password"]) == false){
    echo'Вы ввели неверный пароль, чтобы сбросить его, нажмите кнопку ниже';
    echo "<form method='get' action='reset.php'><input type='submit' name='forgot_pass' value='Сбросить пароль'></form>";
}
else {
    echo "$c_data[name], приветствуем тебя!";
}
?>
