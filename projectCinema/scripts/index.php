<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]))
{
    $user = $_SESSION["logged_user"];
    if($user[1] == 1) { //is_client == 1
        $template = $twig->loadTemplate("index_client.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities
        ));
    }
    else {
        $template = $twig->loadTemplate("index_admin.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities
        ));
    }
}
else {
    $template = $twig->loadTemplate("index.twig");
    $arrWithCities = getListOfCities($mysqli);
    echo $template->render(array(
        "cities" => $arrWithCities
    ));
}

?>