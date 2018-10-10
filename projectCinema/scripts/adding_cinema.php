<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("add_cinema.twig");


if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $message = '';
    $error = array();

    $cities = getListOfCities($mysqli);
    $user = $_SESSION["logged_user"];

    if(isset($_POST["to_add_cinema"])) {
        $data = $_POST;

        if ($_POST["nameOfCinema"] == '')
            $error[] = "введите название кинотеатра";
        if($_POST["selectCity"] == '')
            $error[] = "Выберите город";
        if($_POST["address"] == '')
            $error[] = "Введите адрес";

        if(empty($error)){
            $nameOfCinema = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["nameOfCinema"]))));
            $city = $data["selectCity"];
            $addressOfCinema = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["address"]))));

            $query = "SELECT id_city FROM `city` WHERE name = \"$city\";";
            $object = mysqli_query($mysqli, $query);
            $arrInfoAboutCity = mysqli_fetch_all($object);
            $id_city = $arrInfoAboutCity[0][0];

            $query = "SELECT * FROM `cinema` WHERE name = \"$nameOfCinema\" AND id_city = $id_city;";
            $object = mysqli_query($mysqli, $query);
            $arrInfoAboutCity = mysqli_fetch_all($object);

            if(count($arrInfoAboutCity) == 0) {
                $query = "INSERT INTO  `cinema` VALUES (null, \"$nameOfCinema\", \"$addressOfCinema\", $id_city);";
                mysqli_query($mysqli, $query);
                $message = "Кинотеатр успешно добавлен";
            }else
                $error[] = "Такой кинотеатр уже существует";
        }
    }

    $error[] = '';
    echo $template->render(array(
        'login' => $user[0],
        'cities' => $cities,
        'error' => $error[0],
        'message' => $message
    ));
}
    else
        header("Location: index.php");

?>