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

    if(isset($data["delete_genre"])) {
        if($data["genreName"] == '')
            $error[] = "Введите название жанра";

        $nameOfGenre = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["genreName"]))));

        if (empty($error)){
            $query = "SELECT id_genre FROM `genre` WHERE name = \"$nameOfGenre\";";
            $object = mysqli_query($mysqli, $query);
            $arrInfoAboutGenre = mysqli_fetch_all($object);

            if(count($arrInfoAboutGenre) != 0) {
                $query = "Delete from genre where name = \"$nameOfGenre\"";
                if(mysqli_query($mysqli, $query))
                    $message = "Жанр успешно удален";
                else
                    $error[] = "Этот жанр нельзя удалить. Он связан с фильмами";
            }else
                $error[] = "Такой жанр не существует";
        }
    }

    $error[] = '';
    echo $template->render(array(
        'login' => $_SESSION["logged_user"][0],
        'cities' => $cities,
        'error' => $error[0],
        'message' => $message,
        'script' =>"delete_genre.php",
        'block1' => "Удалить жанр",
        'block2' => "Введите название жанра",
        'block3' => "Удалить жанр",
        'nameOfButton' => "delete_genre",
        'nameInput1' => "genreName"
    ));
} else
    header("Location: index.php");

?>