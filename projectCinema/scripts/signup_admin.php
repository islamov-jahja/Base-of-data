<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("admin_registration.twig");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $data = $_POST;
    sigNup("sign_up_admin", $data, $mysqli);

    $error[] = '';
    echo $template->render(array(
        'cities' => $cities,
        'login' => $_SESSION["logged_user"][0],
        'error' => $error[0]
    ));
} else
    header("Location: index.php")

?>
