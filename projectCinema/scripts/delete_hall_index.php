<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("delete_hole_choose.twig");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];

    if(isset($_POST["to_choose_cinema"]))
        $error = SelectCinemasWithName($mysqli, $_POST["nameOfCinema"], $_POST["selectCity"], "delete_hall_action.php");

    $error[] = '';
    echo $template->render(array(
        'login' => $user[0],
        'cities' => $cities,
        'error' => $error[0],
    ));
}

?>