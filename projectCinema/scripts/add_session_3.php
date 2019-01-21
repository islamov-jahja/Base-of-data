<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("add_session_3.twig");


if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];
    $arrInfoAboutHalls = GetInfoAboutHalls($mysqli, $_SESSION["id_cinema"]);

    if (count($arrInfoAboutHalls) != 0) {
        $halls = array();
        for ($i = 0; $i < count($arrInfoAboutHalls); $i++) {
            $hall = new Hall();
            $hall->id = $arrInfoAboutHalls[$i][0];
            $hall->countOfPlaces = $arrInfoAboutHalls[$i][2];
            $hall->number = $arrInfoAboutHalls[$i][1];
            $halls[] = $hall;
        }
    }else
        header("Location: delete_hall_action.php");

    if (isset($_POST["to_delete_hall"])) {
        $line = $_POST["selectHall"];
        $pos = strpos($line, ' ');
        $id = substr($line, 0, $pos);
        $id_film = $_SESSION["idOfFilm"];
        $startTime = $_SESSION["dateTime"];
        $ageLimit = $_SESSION["ageLimit"];
        $price = $_SESSION["price"];
        echo $id_film.$startTime.$ageLimit.$id.$price;
        $query = "Insert into project_cinema.session values(null, $id_film,\"$startTime\", $ageLimit, $id, $price);";
        if (mysqli_query($mysqli,$query))
            header("Location: add_session.php");
    }
}

$error[] = '';
echo $template->render(array(
    'login' => $user[0],
    'cities' => $cities,
    'halls' => $halls,
    'error' => $error[0]
));
?>