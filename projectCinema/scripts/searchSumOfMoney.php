<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    if (isset($_POST["searchSumOfMoney"])) {
        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id_cinema = substr($line, 0, $pos);
        $startDate = $_POST["fromTime"];
        $endDate = $_POST["afterTime"];

        $query = "select sum(s.price) FROM event
                  LEFT JOIN session s ON event.id_session = s.id_session
                  LEFT JOIN session s2 ON event.id_session = s2.id_session
                  LEFT JOIN hall h ON s.id_hall = h.id_hall
                  LEFT JOIN cinema c ON h.id_cinema = c.id_cinema
                  where c.id_cinema = $id_cinema and event_date >= \"$startDate\" and event_date <= \"$endDate\";";
        $sumOfMoney = 0;
        $object = mysqli_query($mysqli, $query);
        $count = mysqli_fetch_all($object);

        if(!empty($count))
            $sumOfMoney = $count[0][0];

        echo "Общяя сумма выручки: " . $sumOfMoney;
    }
}
?>
<br>
<a href="index.php" id="submit">На главное</a>
