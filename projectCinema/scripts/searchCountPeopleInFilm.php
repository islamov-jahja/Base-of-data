<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    if (isset($_POST["searchCountPeopleInFilm"])) {
        $line = $_POST["selectFilm"];
        $pos = strpos($line, ' ');
        $id_film = substr($line, 0, $pos);
        $startDate = $_POST["fromTime"];
        $endDate = $_POST["afterTime"];

        $query = "select count(*) from event
                  LEFT JOIN session s ON event.id_session = s.id_session
                  LEFT JOIN film f ON s.id_film = f.id_film
                  WHERE f.id_film = $id_film AND s.start_time >= \"$startDate\" AND s.start_time <= \"$endDate\";";

        $countOfPeople = 0;
        $object = mysqli_query($mysqli, $query);
        $count = mysqli_fetch_all($object);
        if (!empty($count))
            $countOfPeople = $count[0][0];

        echo "Число посетителей посетивших фильм: " . $countOfPeople;
    }
}
?>
<br>
<a href="index.php" id="submit">На главное</a>
