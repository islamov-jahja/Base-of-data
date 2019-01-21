<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("update.twig");

if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $genresList = getListOfGenres($mysqli);
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

    if (isset($data["update_film"])) {
        $nameOfFilm = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["name"]))));
        $dateOfRelease = $data["dateOfRelease"];
        $description = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["description"]))));
        $tmp_dir_file = $_FILES["image"]["tmp_name"];

        $line = $_POST["selectFilm"];
        $pos = strpos($line, ' ');
        $id_film = substr($line, 0, $pos);


        $isGoodFilm = true;
        if ($isGoodFilm) {
            if ($tmp_dir_file != '') {
                $new_dir_file = "../templates/image/" . $_FILES["image"]["name"];
                move_uploaded_file($tmp_dir_file, $new_dir_file);
                $query = "update `film` set project_cinema.film.image = \"$new_dir_file\" where project_cinema.film.id_film = $id_film;";
                mysqli_query($mysqli, $query);
            }

            if ($description != '') {
                $query = "update `film` set project_cinema.film.description = \"$description\" where project_cinema.film.id_film = $id_film;";
                mysqli_query($mysqli, $query);
            }

            if ($dateOfRelease != ''){
                $query = "update `film` set project_cinema.film.release_date = \"$dateOfRelease\" where project_cinema.film.id_film = $id_film;";
                mysqli_query($mysqli, $query);
            }

            if ($nameOfFilm != ''){
                $query = "update `film` set project_cinema.film.name = \"$nameOfFilm\" where project_cinema.film.id_film = $id_film;";
                mysqli_query($mysqli, $query);
            }

            $message = "Фильм успешно обнавлен";
        } else {
            $error = "фильм c таким именем не существует";
            $isGoodFilm = false;
        }

        $genres = array();
        if ($isGoodFilm) {
            for ($i = 1; $i < 5; $i++)
                if ($_POST["genre$i"] != '') {
                    $originalGenre = true;
                    for ($j = 0; $j < count($genres); $j++)
                        if ($_POST["genre$i"] == $genres[$j])
                            $originalGenre = false;

                    if ($originalGenre)
                        $genres[] = $_POST["genre$i"];
                }
        }

        if(count($genres) != 0)
        {
            $query = "delete from `genre_in_film` where project_cinema.genre_in_film.id_film = $id_film;";
            mysqli_query($mysqli, $query);
        }

        for ($i = 0; $i < count($genres); $i++) {
            $query = "Select id_genre  from `genre` where name = \"$genres[$i]\";";
            $object = mysqli_query($mysqli, $query);
            $arr = mysqli_fetch_all($object);
            $id_genre = $arr[0][0];

            $query = "INSERT INTO `genre_in_film` VALUES (null, $id_genre, $id_film);";
            mysqli_query($mysqli, $query);
        }
    }

    echo $template->render(array(
        'cities' => $cities,
        'genres' => $genresList,
        'login' => $user[0],
        'error' => $error,
        'message' => $message,
        'films' => $films
    ));
}
else
    header("Location: index.php");
?>