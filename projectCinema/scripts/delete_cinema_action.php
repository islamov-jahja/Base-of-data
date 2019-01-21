<?php
require_once("../includes/db.inc.php");
require_once("../includes/functions.inc.php");
require_once("../includes/twig.inc.php");
$template = $twig->loadTemplate("delete_cinema_action.twig");


if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];
    $message = '';

    $id_city = GetIdOfCity($mysqli, $_SESSION["nameOfCity"]);
    $arrInfoAboutCinema = GetInfoAboutAllCinemas($mysqli);

    if (count($arrInfoAboutCinema) != 0) {
        $cinemas = array();
        for ($i = 0; $i < count($arrInfoAboutCinema); $i++) {
            $cinema = new Cinema();
            $cinema->id = $arrInfoAboutCinema[$i][0];
            $cinema->name = $_SESSION["nameOfCinema"];
            $cinema->city = $_SESSION["nameOfCity"];
            $cinema->address = $arrInfoAboutCinema[$i][2];
            $cinemas[] = $cinema;
        }
    }

    if (isset($_POST["to_delete_cinema"])) {
        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id = substr($line, 0, $pos);
        $query = "Delete from `cinema` WHERE `cinema`.id_cinema = $id";
        if (mysqli_query($mysqli,$query))
            header("Location: delete_cinema.php");
        else
            $message = "Этот кинотеатр нельзя удалить!";
    }

    $error[] = '';
    echo $template->render(array(
        'login' => $user[0],
        'cities' => $cities,
        'cinemas' => $cinemas,
        'error' => $error[0],
        'message' => $message
    ));
}

?>