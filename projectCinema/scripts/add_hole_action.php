<?php
require_once("../includes/db.inc.php");
require_once("../includes/functions.inc.php");
require_once("../includes/twig.inc.php");
$template = $twig->loadTemplate("add_hole_action.twig");

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
    if(isset($_POST["to_add_hole"])) {
        if ($_POST["number_of_hall"] < 1)
            $error[] = "Некорректный номер зала";

        if ($_POST["amount_of_places"] < 1)
            $error[] = "Некорректное количество мест";

        if (empty($error)) {
            $line = $_POST["selectCinema"];
            $pos = strpos($line, ' ');
            $id_cinema = substr($line, 0, $pos);


            $number_of_hall = $_POST["number_of_hall"];
            $amount_of_places = $_POST["amount_of_places"];
            $query = "Select * from `hall` where id_cinema = $id_cinema and number_of_hall = $number_of_hall";
            $object = mysqli_query($mysqli, $query);
            $arr = mysqli_fetch_all($object);

            if (count($arr) != 0)
                $error[] = "зал с таким номером уже существует";
            else {
                $query = "Insert into `hall` VALUES (null, $number_of_hall, $id_cinema, $amount_of_places)";
                mysqli_query($mysqli, $query);
                $message = "Зал успешно добавлен";
            }
        }
    }
}

$error[] = '';
echo $template->render(array(
    'login' => $user[0],
    'cities' => $cities,
    'cinemas' => $cinemas,
    'error' => $error[0],
    'message' => $message
))
?>