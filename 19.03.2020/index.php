<?php
require_once 'components/db.php';
?>

<?php
function Month($month){
    /*получаем:
     *название текущего, следующего и предыдущего месяцев
     * количество дней в месяце
     * с какого дня недели начинается месяц
     * текущий день
     */
    $currentMonth = date('F');
    $currentDay = date('j');
    $countDays = date('t', strtotime($month));
    $firstDay = date("N", strtotime("first day of $month"));

    $nextMonth = date("F", strtotime("next month"));
    $prevMonth = date("F", strtotime("previous month"));
    $color = '';

    $nameDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

    //если первый день месяца начинается не с понедельника, сдвигаем дни недели
    for ($i = 0; $i < $firstDay - 1; $i++){
        $temp = array_shift($nameDays);
        $nameDays[] = $temp;
    }
    ?>
    <!--выводим календарь, нажимая на кнопки, можно переключаться между месяцами-->
    <form method="get" action="">
    <table border="2">
        <tr>
            <?php
            echo "<th><input type='submit' name='month' value='$prevMonth'></th>";
            echo "<th><input type='submit' name='month' value='$currentMonth'></th>";
            echo "<th><input type='submit' name='month' value='$nextMonth'></th>";
            ?>
        </tr>
        <tr>
            <?php
            for($i = 0; $i <= 6; $i++) {
            if ($nameDays[$i] == 'Saturday' or $nameDays[$i] == 'Sunday'){
                $color = 'f2aaaa';
            }else{
                $color = '#fff';
            }
            echo "<th bgcolor='$color'>$nameDays[$i]</th>";
        }
        ?>
        </tr>
        <tr>
            <?php
            for($i = 1; $i <= $countDays; $i++){
                if ($_GET['month'] != $currentMonth){
                    $color = '#fff';
                }
                elseif ($i == $currentDay){
                $color = '#979797';
                }else{
                    $color = '#fff';
                }
                echo "<td bgcolor='$color'>$i</td>";
                if ($i % 7 == 0){
                    echo '</tr><tr>';
                }


            }
            ?>
        </tr>
    </table>
        <hr>
</form>
    <?php
}
function getMessage($month){
    global $connect;
    $num = '';
    //получаем порядковый номер месяца
    $currentMonth = date('m', strtotime("$month"));

    //ищем в бд все сообщения с номером месяца, который нам нужен
    $date = $connect->query("SELECT * FROM `days` WHERE  MONTH(`date`) = $currentMonth");
    $date->setFetchMode(PDO::FETCH_ASSOC);
    $count = $date->fetchAll();

    //если есть сообщения, выводим их, в обратном случае выведем сообщение об их отсутствии
    if ($count != null) {
        for ($i = 0; $i < count($count); $i++) {
            echo " Пользователь с ником: ";
            $user = print_r($count[$i]['user']);
            echo "<br>" . 'Написал: ';
            $text = print_r($count[$i]['text']);
            echo "<br>";
            $date = print_r($count[$i]['date']);
            echo "<hr>";
        }
    }else{
        echo 'В этом месяце никто ничего не писал';
    }

}


$month = $_GET['month'];

Month($month);
getMessage($month);