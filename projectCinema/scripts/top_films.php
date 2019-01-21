<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $now = new Datetime();
    $now = $now->format("Y-m-d");
    $from = new DateTime();
    $from->modify('-1 month');
    $from = $from->format("Y-m-d");

    $query = "SELECT id_film, COUNT(id_film) AS countOfPeopleInFilm FROM event
              LEFT JOIN session s ON event.id_session = s.id_session
              WHERE s.start_time >= \"$from\" AND s.start_time <= \"$now\"
              GROUP BY id_film
              ORDER BY countOfPeopleInFilm DESC;";
    $object = mysqli_query($mysqli, $query);
    $arrFilms = mysqli_fetch_all($object);
    $films = array();
    $count = 3;
    if (count($arrFilms) < $count)
        $count = count($arrFilms);

    for($i = 0; $i < $count; $i++)
    {
        $id = $arrFilms[$i][0];
        $query = "Select id_film, name, release_date, image, description from `film` where id_film = $id";
        $object = mysqli_query($mysqli, $query);
        $arr = mysqli_fetch_all($object);
        $film = new Film();
        $film->id = $arr[0][0];
        $film->name = $arr[0][1];
        $film->releaseDate = $arr[0][2];
        $film->description = $arr[0][4];

        if ($arr[0][3] != '')
            $film->linkForImage = $arr[0][3];
        else
            $film->linkForImage = "../templates/image/bg.jpg";

        $query = "Select genre.name from `genre` Left Join `genre_in_film` ON genre.id_genre = genre_in_film.id_genre Left JOIN `film` ON genre_in_film.id_film = film.id_film WHERE film.id_film = $id;";

        $object = mysqli_query($mysqli, $query);
        $arr2 = mysqli_fetch_all($object);

        for ($k = 0; $k < count($arr2); $k++)
            $film->genres[] = $arr2[$k][0];

        $films[] = $film;
    }


    $user = $_SESSION["logged_user"];

    $template = $twig->loadTemplate("index_client_admin.twig");
    $arrWithCities = getListOfCities($mysqli);

    echo $template->render(array(
        "login" => $user[0],
        "cities" => $arrWithCities,
        "films" => $films,
    ));
}
?>