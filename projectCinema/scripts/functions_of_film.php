<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"])) {
    $user = $_SESSION["logged_user"];
    if ($user[1] == 0) {
        $template = $twig->loadTemplate("functions_film.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities
        ));
    }
}
?>