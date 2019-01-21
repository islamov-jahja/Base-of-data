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

    if (isset($data["deleting_film"])) {
        $line = $_POST["selectFilm"];
        $pos = strpos($line, ' ');
        $id_film = substr($line, 0, $pos);

        $query = "Select name  from `film` where id_film = $id_film;";
        $object = mysqli_query($mysqli, $query);
        $arr = mysqli_fetch_all($object);
        if (count($arr) == 0)
            $message = "Такого фильма не существует";
        else{
            $query = "Delete from `film` where project_cinema.film.id_film = $id_film;";
            if(mysqli_query($mysqli, $query));
                $message = "Фильм успешно удален";
        }

    }

    $error[] = '';
    echo $template->render(array(
        'cities' => $cities,
        'login' => $user[0],
        'error' => $error[0],
        'message' => $message,
        'films' => $films
    ));
}
else
    header("Location: index.php");
?>