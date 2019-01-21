<?php
require_once("../includes/functions.inc.php");
require_once("../includes/db.inc.php");
require_once("../includes/twig.inc.php");
$template = $twig->loadTemplate("reports.twig");
$cities = getListOfCities($mysqli);
$error = array();
$error[] = '';
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

echo $template->render(array(
    'cities' => $cities,
    'login' => $_SESSION["logged_user"][0],
    'error' => $error[0],
    'films' => $films,
    'cinemas' => $cinemas
));