<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");

$template = $twig->loadTemplate("add_city_genre.twig");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);

    $data = $_POST;
    $message = '';
    $error = array();

    if(isset($data["delete_city"])) {
        if($data["cityName"] == '')
            $error[] = "Введите название города";

        $nameOfCity = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["cityName"]))));

        if (empty($error)){
            $query = "SELECT id_city FROM `city` WHERE name = \"$nameOfCity\";";
            $object = mysqli_query($mysqli, $query);
            $arrInfoAboutCity = mysqli_fetch_all($object);

            if(count($arrInfoAboutCity) != 0) {
                $query = "Delete from city where name = \"$nameOfCity\";";
                if(mysqli_query($mysqli, $query))
                    header("Location: delete_city.php");
                else
                    $error[] = "Этот город нельзя удалить. Он связан с кинотеатрами";
            }else
                $error[] = "Такой город не существует";
        }
    }

    $error[] = '';
    echo $template->render(array(
        'login' => $_SESSION["logged_user"][0],
        'cities' => $cities,
        'error' => $error[0],
        'message' => $message,
        'script' =>"delete_city.php",
        'block1' => "Удалить город",
        'block2' => "Введите название города",
        'block3' => "Удалить город",
        'nameOfButton' => "delete_city",
        'nameInput1' => "cityName"
    ));
} else
    header("Location: index.php");

?>