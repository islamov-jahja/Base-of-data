<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("add_session.twig");

$cities = getListOfCities($mysqli);
$user = $_SESSION["logged_user"];
$message = '';

$arrInfoAboutFilms = GetAllFilms($mysqli);

if (count($arrInfoAboutFilms) != 0) {
    $films = array();
    for ($i = 0; $i < count($arrInfoAboutFilms); $i++) {
        $film = new Film();
        $film->id = $arrInfoAboutFilms[$i][0];
        $film->releaseDate = $arrInfoAboutFilms[$i][1];
        $film->name = $arrInfoAboutFilms[$i][2];
        $films[] = $film;
    }
}

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

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    if (isset($_POST["to_add_session1"])) {

        $line = $_POST["selectFilm"];
        $pos = strpos($line, ' ');
        $id_film = substr($line, 0, $pos);

        $line = $_POST["selectCinema"];
        $pos = strpos($line, ' ');
        $id_cinema= substr($line, 0, $pos);

        $message = '';
        $error = array();

        if ($_POST["dateTime"] == '')
            $error[] = "Введите время начала сеанса";

        if ($_POST["ageLimit"] == '')
            $error[] = "Введите возрастное ограничение";

        if ($_POST["price"] == '')
            $error[] = "Введите цену";

        if (count($error) == 0) {
            $startTime = $_POST["dateTime"];
            $price = $_POST["price"];
            $ageLimit = $_POST["ageLimit"];
            $query = "Insert into project_cinema.session 
                      values(null, $id_film,\"$startTime\", $ageLimit, $id_cinema, $price);";
            if (mysqli_query($mysqli,$query))
                $message = "Сессия добавлена";
            else
                $message = "ошибка";
        }
    }

    $error[] = '';


    echo $template->render(array(
        'login' => $user[0],
        'cities' => $cities,
        'error' => $error[0],
        'message' => $message,
        'films' => $films,
        'cinemas' => $cinemas
    ));
}
else
    header("Location: index.php");