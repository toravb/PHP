<?php
require_once ('includes/db.php');
?>

<DOCTYPE html>
    <html>
    <head>
        <title>Сокращатель ссылок</title>
    </head>
    <body>
    <form action="" method="post">
        <input type="url" required placeholder="Введите ссылку..." autocomplete="off" name="url">
        <input type="submit" name="submit" value="Сократить">
    </form>

    <?php //набор символов из которых создается короткая ссылка, приведение ссылки к стандартному виду
    $h = "QqWwEeRrTtYyUuIiOoPpAaSsDdFfGgHhJjKkLlZzXxCcVvBbNnMm1234567890";
    $rand = substr(str_shuffle($h), 0, 6);
    $site = "http://test.ru/";
    $url_valid = $_POST['url'];
    $short_url = "$site$rand";
    $url = filter_var($url_valid, FILTER_VALIDATE_URL,  FILTER_FLAG_PATH_REQUIRED);

    if ($url == false) {
        $url = $url_valid . '/';
    }

    ?>

    <?php //поиск введенной ссылки в бд
    $count_url = $connect->prepare("SELECT COUNT(*) FROM `url_shortener` WHERE `long_url` = :url");
    $count_url->bindValue(':url', $url, PDO::PARAM_STR);
    $count_url->execute();
    $count = $count_url->fetch();

    $find_url = $connect->prepare("SELECT * FROM `url_shortener` WHERE `long_url` = :url");
    $find_url->bindValue(':url', $url, PDO::PARAM_STR);
    $find_url->execute();
    $find = $find_url->fetch();
    ?>

    <?php //проверка, является ли ссылка короткой; создание ссылки или вывод, если она уже есть в бд
    if(stristr($url_valid, $site)){
        echo 'Введена короткая ссылка';
    }
    else {

        if ($_POST['submit']) {

            if ($count[0] != 0) {
                echo "Сокращенная ссылка: <a href='$find[short_url]' target='_blank'>$find[short_url]</a>";
            }
            else {
                $insert_url = $connect->prepare("INSERT INTO `url_shortener`(`long_url`, `short_url`) VALUES (:url, :short_url)");
                $insert_url->bindValue(':url', $url, PDO::PARAM_STR);
                $insert_url->bindValue(':short_url', $short_url, PDO::PARAM_STR);
                $insert_url->execute();
                echo "Сокращенная ссылка: <a href='$short_url' target='_blank'>$short_url</a>";
            }
        }
    }
    ?>


    </body>
    </html>
