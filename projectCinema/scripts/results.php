<?php
require_once("../includes/functions.inc.php");
require_once("../includes/db.inc.php");
require_once("../includes/twig.inc.php");

$template = $twig->loadTemplate("sessions.twig");
$message = '';
$cities = getListOfCities($mysqli);
$sessions = array();
$id = $_GET["id"];

$now = new DateTime();
$now = $now ->format("Y-m-d H:i:s");

$query = "SELECT
  id_session,
  start_time,
  `f`.name,
  `f`.image,
  `c`.name,
  `c`.adress,
  `c2`.name,
  age_limit,
  price
FROM session LEFT JOIN film f ON session.id_film = f.id_film
LEFT JOIN hall h ON session.id_hall = h.id_hall
LEFT JOIN cinema c ON h.id_cinema = c.id_cinema
LEFT JOIN city c2 ON c.id_city = c2.id_city
where f.id_film = $id and start_time > \"$now\";";
$obj = mysqli_query($mysqli, $query);
$arr = mysqli_fetch_all($obj);

if(count($arr) == 0)
    $message = "ничего не найдено";
else{
    for($i = 0; $i < count($arr); $i++){
        $session = new Session();
        $session->id = $arr[$i][0];
        $session->startTime = $arr[$i][1];
        $session->filmName = $arr[$i][2];
        $session->linkImage = $arr[$i][3];
        $session->nameCinema = $arr[$i][4];
        $session->addressCinema = $arr[$i][5];
        $session->city = $arr[$i][6];
        $session->ageLimit = $arr[$i][7];
        $session->price = $arr[$i][8];
        $sessions[] = $session;
    }
}

if (isset($_SESSION["logged_user"])) {
    echo $template->render(array(
        'cities' => $cities,
        'message' => $message,
        'isLogin' => true,
        'sessions' => $sessions,
        'login' => $_SESSION["logged_user"][0]
    ));
} else {
    echo $template->render(array(
        'cities' => $cities,
        'message' => $message,
        'isLogin' => false,
        'sessions' => $sessions
    ));
}
?>