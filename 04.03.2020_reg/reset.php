<?php
require_once ("includes/data.php");
?>
<form action="" method="post">
    <input type="email" required name="email" placeholder="Введите ваш email">
    <input type="password" required name="new_pass" placeholder="Введите новый пароль">
    <input type="password" required name="newc_pass" placeholder="Подтвердите пароль">
    <hr>
    <input type="submit" name="reset" required value="Сбросить пароль">
</form>

<?php
$new_pass = $_POST['new_pass'];
$newc_pass = $_POST['newc_pass']
?>

<?php
if($_POST['reset']) {
    if (strlen($new_pass) > 16 or strlen($newc_pass) < 5) {
        echo 'Новый пароль должен содержать от 5 до 16 двух символов';
    }
    elseif ($new_pass != $newc_pass) {
        echo 'Пароли не совпадают';
    }
    elseif ($count_email->rowCount() == 0){
        echo 'Указанный email не используется';
    }
    else {
        $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);

        $reset_pass = $connect->query("UPDATE username SET password = '$new_pass' WHERE email = '$email'");

        echo 'Пароль успешно сброшен, используйте новые данные для входа';
        echo "<form action='index_login.php'><input type='submit' value='Перейти ко входу'></form>";
    }
}