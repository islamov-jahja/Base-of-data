<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("add_city_genre.twig");

if (isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $cities = getListOfCities($mysqli);
    $data = $_POST;
    $message = '';
    $error = array();

    if(isset($data["add_to_genre"])) {
        if($data["genreName"] == '')
            $error[] = "Введите название жанра";

        $nameOfGenre = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["genreName"]))));

        if (empty($error)){
            $query = "SELECT id_genre FROM `genre` WHERE name = \"$nameOfGenre\";";
            $object = mysqli_query($mysqli, $query);
            $arrInfoAboutGenre = mysqli_fetch_all($object);

            if(count($arrInfoAboutGenre) == 0) {
                $query = "Insert into `genre` values(null, \"$nameOfGenre\");";
                mysqli_query($mysqli, $query);
                $message = "Жанр успешно добавлен";
            }else
                $error[] = "Такой жанр уже существует";
        }
    }

    $error[] = '';
    echo $template->render(array(
        'login' => $_SESSION["logged_user"][0],
        'cities' => $cities,
        'error' => $error[0],
        'message' => $message,
        'script' =>"add_genre.php",
        'block1' => "Добавить жанр",
        'block2' => "Введите название жанра",
        'block3' => "Добавить жанр",
        'nameOfButton' => "add_to_genre",
        'nameInput1' => "genreName"
    ));
} else
    header("Location: index.php");

?>