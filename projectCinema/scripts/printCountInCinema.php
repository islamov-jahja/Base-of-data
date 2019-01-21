<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    if (isset($_POST["printCountInCinema"])) {
        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id_cinema = substr($line, 0, $pos);
        $startDate = $_POST["fromTime"];
        $endDate = $_POST["afterTime"];

        $query = "select count(*), name from event
                  LEFT JOIN session s ON event.id_session = s.id_session
                  LEFT JOIN hall h ON s.id_hall = h.id_hall
                  LEFT JOIN cinema c ON h.id_cinema = c.id_cinema
                  where c.id_cinema = $id_cinema and s.start_time >= \"$startDate\" and s.start_time <= \"$endDate\";";

        $countOfPeple = 0;
        $object = mysqli_query($mysqli, $query);
        $count = mysqli_fetch_all($object);
        if (!empty($count))
            $countOfPeple = $count[0][0];

        $nameOfCinema = $count[0][1];
        echo "Число посетителей посетивших кинотеатр " . $nameOfCinema . " " . "За промежуток времени от: " . $startDate . ' ' . "до:" . $endDate . ": " . $countOfPeple;
    }
}
?>
<br>
<a href="index.php" id="submit">На главное</a>
