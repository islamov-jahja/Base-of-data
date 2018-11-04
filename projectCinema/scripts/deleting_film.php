<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("DeleteTheFilm.twig");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];
    $data = $_POST;
    $message = '';
    $error = '';

    if (isset($data["adding_film"])) {
        $nameOfFilm = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["name"]))));
        $dateOfRelease = $data["dateOfRelease"];
        $query = "Select name  from `film` where name = \"$nameOfFilm\" AND release_date = \"$dateOfRelease\";";
        $object = mysqli_query($mysqli, $query);
        $arr = mysqli_fetch_all($object);
        if (count($arr) == 0)
            $message = "Такого фильма не существует";
        else{
            $query = "Delete from `film` where name = \"$nameOfFilm\" AND release_date = \"$dateOfRelease\";";
            if(mysqli_query($mysqli, $query));
                $message = "Фильм успешно удален";
        }

    }

    $error[] = '';
    echo $template->render(array(
        'cities' => $cities,
        'login' => $user[0],
        'error' => $error[0],
        'message' => $message
    ));
}
else
    header("Location: index.php");
?>