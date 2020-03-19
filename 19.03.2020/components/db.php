<?php
$host = '127.0.0.1';
$dbName = 'calendar';
$user = 'root';
$password = '';

try
{
    $connect = new PDO("mysql:host={$host};dbname={$dbName}", $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo 'ERROR: ' . $e->getMessage();
    exit();
}