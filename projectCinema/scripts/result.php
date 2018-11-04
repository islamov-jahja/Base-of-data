<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

$films = array();

if(isset($_POST["do_search"]))
{
    $nameOfFilm = $_POST["nameOfFilm"];
    $query = "Select id_film, name, release_date, image, description from `film` where name like \"%$nameOfFilm%\";";
    $object = mysqli_query($mysqli, $query);
    $arr = mysqli_fetch_all($object);

    for ($i = 0; $i < count($arr); $i++) {
        $film = new Film();
        $film->name = $arr[$i][1];
        $film->releaseDate = $arr[$i][2];
        $film->description = $arr[$i][4];
        if ($arr[$i][3] != '')
            $film->linkForImage = $arr[$i][3];
        else
            $film->linkForImage = "../templates/image/bg.jpg";
        $id_film = $arr[$i][0];
        $query = "Select genre.name from `genre` Left Join `genre_in_film` ON genre.id_genre = genre_in_film.id_genre Left JOIN `film` ON genre_in_film.id_film = film.id_film WHERE film.id_film = $id_film;";
        $object = mysqli_query($mysqli, $query);
        $arr2 = mysqli_fetch_all($object);

        for ($k = 0; $k < count($arr2); $k++)
            $film->genres[] = $arr2[$k][0];

        $films[] = $film;
    }
}

$message = '';
if(count($films) == 0){
    $message = "по вашему запросу ничего не найдено";
}

if(isset($_SESSION["logged_user"]))
{
    $user = $_SESSION["logged_user"];
    if($user[1] == 1) { //is_client == 1
        $template = $twig->loadTemplate("index_client.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities,
            "films" => $films,
            "isResult" => true,
            "message" => $message
        ));
    }
    else {
        $template = $twig->loadTemplate("index_client_admin.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities,
            "films" => $films,
            "isResult" => true,
            "message" => $message
        ));
    }
}
else {
    $template = $twig->loadTemplate("index.twig");
    $arrWithCities = getListOfCities($mysqli);
    echo $template->render(array(
        "cities" => $arrWithCities,
        "films" => $films,
        "isResult" => true,
        "message" => $message
    ));
}
?>