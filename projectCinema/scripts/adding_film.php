<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("AddingTheFilm.twig");

$genresList = getListOfGenres($mysqli);
$user = $_SESSION["logged_user"];
$data = $_POST;

if (isset($data["adding_film"])) {
    $nameOfFilm = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["name"]))));
    $dateOfRelease = $data["dateOfRelease"];
    $description = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["description"]))));
    $tmp_dir_file = $_FILES["image"]["tmp_name"];

    $query = "Select name  from `film` where name = \"$nameOfFilm\";";
    $object = mysqli_query($mysqli, $query);
    $arr = mysqli_fetch_all($object);
    $isGoodFilm = true;

    if(is_uploaded_file($tmp_dir_file) && count($arr) == 0) {
        $new_dir_file = "../templates/image/".$_FILES["image"]["name"];
        move_uploaded_file($tmp_dir_file,$new_dir_file);
        if($description != '')
            $query = "INSERT INTO `film` VALUES (null, \"$dateOfRelease\", \"$nameOfFilm\", \"$description\", \"$new_dir_file\");";
        else
            $query = "INSERT INTO `film` VALUES (null, \"$dateOfRelease\", \"$nameOfFilm\", null, \"$new_dir_file\");";
        mysqli_query($mysqli, $query);
        echo "Фильм успешно добавлен";
    }
    else if(!is_uploaded_file($tmp_dir_file) && count($arr) == 0) {
        if ($description != '')
            $query = "INSERT INTO `film` VALUES (null, \"$dateOfRelease\", \"$nameOfFilm\", \"$description\", null);";
        else
            $query = "INSERT INTO `film` VALUES (null, \"$dateOfRelease\", \"$nameOfFilm\", null, null);";
        mysqli_query($mysqli, $query);
        echo "Фильм успешно добавлен";
    }
    else{
        echo "фильм c таким именем уже существует";
        $isGoodFilm = false;
    }

    $query = "Select id_film  from `film` where name = \"$nameOfFilm\";";
    $object = mysqli_query($mysqli, $query);
    $arr = mysqli_fetch_all($object);
    $id_film = $arr[0][0];

    if ($isGoodFilm)
    {
        $genres = array();
        for($i = 1; $i < 5; $i++)
            if($_POST["genre$i"] != '') {
                $originalGenre = true;
                for ($j = 0; $j < count($genres); $j++)
                    if ($_POST["genre$i"] == $genres[$j])
                        $originalGenre = false;

                if($originalGenre)
                    $genres[] = $_POST["genre$i"];
            }
    }

    for($i = 0; $i < count($genres); $i++) {
        $query = "Select id_genre  from `genre` where name = \"$genres[$i]\";";
        $object = mysqli_query($mysqli, $query);
        $arr = mysqli_fetch_all($object);
        $id_genre = $arr[0][0];

        $query = "INSERT INTO `genre_in_film` VALUES (null, $id_genre, $id_film);";
        mysqli_query($mysqli, $query);
    }
}


echo $template->render(array(
    'genres' => $genresList,
    'login' => $user[0]
))
?>