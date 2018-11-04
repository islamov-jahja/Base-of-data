<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");
if(isset($_SESSION["logged_user"]) && $_SESSION["logged_user"][1] == 0/*не клиент*/) {
    $query = "Select count(*), min(id_film) from `film`";
    $object = mysqli_query($mysqli, $query);
    $pagesCount = mysqli_fetch_all($object);
    $countOfPages = floor($pagesCount[0][0] / 12);
    $countOfPages++;

    $pages = array();
    for ($i = 0; $i < $countOfPages; $i++)
        $pages[] = $i + 1;
    $films;

    if (isset($_GET["page_search"]))
        $films = getListOfFilms($mysqli, $pagesCount[0][1], $_GET["page"], 12);
    else
        $films = getListOfFilms($mysqli, $pagesCount[0][1], 1, 12);

    $user = $_SESSION["logged_user"];

    $template = $twig->loadTemplate("index_client_admin.twig");
    $arrWithCities = getListOfCities($mysqli);

    echo $template->render(array(
        "login" => $user[0],
        "cities" => $arrWithCities,
        "pages" => $pages,
        "films" => $films,
    ));
}
?>