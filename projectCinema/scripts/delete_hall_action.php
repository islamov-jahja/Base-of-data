<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("delete_hole_action.twig");

if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];

    $id_city = GetIdOfCity($mysqli, $_SESSION["nameOfCity"]);
    $arrInfoAboutCinema = GetInfoAboutAllCinemas($mysqli);

    if (count($arrInfoAboutCinema) != 0) {
        $cinemas = array();
        for ($i = 0; $i < count($arrInfoAboutCinema); $i++) {
            $cinema = new Cinema();
            $cinema->id = $arrInfoAboutCinema[$i][0];
            $cinema->name = $arrInfoAboutCinema[$i][1];
            $cinema->city = GetNameOfCity($mysqli, $arrInfoAboutCinema[$i][3]);
            $cinema->address = $arrInfoAboutCinema[$i][2];
            $cinemas[] = $cinema;
        }
    }

    if(isset($_POST["to_choose_cinema"])){
        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id_cinema = substr($line, 0, $pos);

        $query = "select * from `hall` where id_cinema = $id_cinema";
        $object = mysqli_query($mysqli, $query);
        $arr = mysqli_fetch_all($object);
        if (count($arr) == 0)
            $error[] = "В данном кинотеатре нет залов";
        else {
            $_SESSION["id_cinema"] = $id_cinema;
            header("Location: delete_hall_final.php");
        }
    }

}

$error[] = '';
echo $template->render(array(
    'login' => $user[0],
    'cities' => $cities,
    'cinemas' => $cinemas,
    'error' => $error[0]
));
?>