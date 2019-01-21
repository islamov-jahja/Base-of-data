<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    if (isset($_POST["PrintPeopleInFilm"])) {
        $line = $_POST["selectFilm"];
        $pos = strpos($line, ' ');
        $id_film = substr($line, 0, $pos);
        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id_cinema = substr($line, 0, $pos);
        $endDate = $_POST["startTime"];

        $query = "select c.name, c.surname, c.phone_number, c.login from event
                  LEFT JOIN session s ON event.id_session = s.id_session
                  LEFT JOIN film f ON s.id_film = f.id_film
                  LEFT JOIN client c ON event.id_client = c.id_client
                  LEFT JOIN hall h ON s.id_hall = h.id_hall
                  LEFT JOIN cinema c2 ON h.id_cinema = c2.id_cinema
                  where c2.id_cinema = $id_cinema and f.id_film = $id_film and s.start_time = \"$endDate\"
                  group by c.name;";

        $object = mysqli_query($mysqli, $query);
        $list = mysqli_fetch_all($object);

        if (!empty($list)) {
            echo "<br/>";
            for ($i = 0; $i < count($list); $i++) {
                for ($j = 0; $j < 4; $j++)
                    echo $list[$i][$j] . ' ';
                echo "<br/>";
            }
        }
        else
            echo "никого";

    }
}
?>
<br>
<a href="index.php" id="submit">На главное</a>
