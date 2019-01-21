<?php
require_once("../includes/functions.inc.php");
require_once("../includes/db.inc.php");
require_once("../includes/twig.inc.php");

$template = $twig->loadTemplate("reservation.twig");
$message = '';
$cities = getListOfCities($mysqli);

if (isset($_GET["to_buy"])) {
    $id_session = $_GET["to_buy"];
    $now = new Datetime();
    $now = intval($now->format("Y"));
    $dateOfBirn = new DateTime($_SESSION["logged_user"][3]);
    $dateOfBirn = intval($dateOfBirn->format("Y"));

    $session = $_SESSION["session"];
    if ($now - $dateOfBirn < $session->ageLimit)
        $error[] = "Доступ запрещен";
    $query = "select id_event from `event` where id_session = $id_session;";
    $obj = mysqli_query($mysqli, $query);
    $arr = mysqli_fetch_all($obj);
    if(count($arr) >= $session->amountOfPlaces)
        $error[] = "Билеты закончились";

    if(empty($error)) {
        $user = $_SESSION["logged_user"][2];
        $now = new DateTime();
        $now = $now -> format("Y-m-d H:i:s");
        $query = "Insert into `event` values(null, $id_session, $user, \"$now\");";
        mysqli_query($mysqli, $query);
        $message = "билет куплен";
    }

    header("Location: index.php");
}

$id_session = $_GET["id"];


$query = "SELECT
  id_session,
  start_time,
  `f`.name,
  `f`.image,
  `c`.name,
  `c`.adress,
  `c2`.name,
  age_limit,
  price,
  `f`.description,
  h.amount_of_place
FROM session LEFT JOIN film f ON session.id_film = f.id_film
LEFT JOIN hall h ON session.id_hall = h.id_hall
LEFT JOIN cinema c ON h.id_cinema = c.id_cinema
LEFT JOIN city c2 ON c.id_city = c2.id_city
where session.id_session = $id_session;";
$obj = mysqli_query($mysqli, $query);
$arr = mysqli_fetch_all($obj);


$session = new Session();
$session->id = $arr[0][0];
$session->startTime = $arr[0][1];
$session->filmName = $arr[0][2];
$session->linkImage = $arr[0][3];
$session->nameCinema = $arr[0][4];
$session->addressCinema = $arr[0][5];
$session->city = $arr[0][6];
$session->ageLimit = $arr[0][7];
$session->price = $arr[0][8];
$session->description = $arr[0][9];
$session->amountOfPlaces = $arr[0][10];


$query = "Select genre.name from `genre` 
Left Join `genre_in_film` ON genre.id_genre = genre_in_film.id_genre 
Left JOIN `film` ON genre_in_film.id_film = film.id_film WHERE film.name = \"$session->filmName\";";
$object = mysqli_query($mysqli, $query);
$genres = mysqli_fetch_all($object);

for($i = 0; $i < count($genres); $i++)
    $session->genresOfFilm[] = $genres[$i][0];

$_SESSION["session"] = $session;

if (isset($_SESSION["logged_user"])) {
    echo $template->render(array(
        'cities' => $cities,
        'message' => $message,
        'isLogin' => true,
        'session' => $session,
        'login' => $_SESSION["logged_user"][0]
    ));
} else {
    echo $template->render(array(
        'cities' => $cities,
        'message' => $message,
        'isLogin' => false,
        'session' => $session
    ));
}
?>