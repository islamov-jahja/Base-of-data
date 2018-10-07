<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

$query = "Select count(*), min(id_film) from `film`";
$object = mysqli_query($mysqli, $query);
$pagesCount= mysqli_fetch_all($object);
$countOfPages = floor($pagesCount[0][0]/12);
$countOfPages++;

$pages = array();
for($i = 0; $i < $countOfPages; $i++)
    $pages[] = $i+1;
$films;

if (isset($_GET["page_search"]))
    $films = getListOfFilms($mysqli, $pagesCount[0][1], $_GET["page"], 12);
else
    $films = getListOfFilms($mysqli, $pagesCount[0][1], 1, 12);

if(isset($_SESSION["logged_user"]))
{
    $user = $_SESSION["logged_user"];
    if($user[1] == 1) { //is_client == 1
        $template = $twig->loadTemplate("index_client.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities,
            "pages" => $pages,
            "films" => $films,
        ));
    }
    else {
        $template = $twig->loadTemplate("index_admin.twig");
        $arrWithCities = getListOfCities($mysqli);
        echo $template->render(array(
            "login" => $user[0],
            "cities" => $arrWithCities
        ));
    }
}
else {
    $template = $twig->loadTemplate("index.twig");
    $arrWithCities = getListOfCities($mysqli);
    echo $template->render(array(
        "cities" => $arrWithCities,
        "pages" => $pages,
        "films" => $films,
    ));
}

?>