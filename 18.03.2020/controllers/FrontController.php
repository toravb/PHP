<?php

if ($_GET['register']){
    require_once './models/register.php';
    if ($verify == true) {
        require_once './views/Success.php';
        die;
    }
    require_once ('views/Register.php');
    die;
}

if ($_GET['login']){

    require_once ('./models/login.php');
    if ($verify == true) {
        require_once './views/Success.php';
        die;
    }
    require_once ('views/Login.php');
    die;
}