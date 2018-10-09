<?php
function sigNup($form, $data, $mysqli)
{
    if (isset($data[$form])) // do_signup название кнопки
    {
        $error = array();
        if (trim($data["name"] == ''))
            $error[] = "Введите имя";
        if (trim($data["surname"] == ''))
            $error[] = "Введите фамилию";
        if (trim($data["phone_number"] == ''))
            $error[] = "Введите номер телефона";
        if ($data["date_of_born"] == '')
            $error[] = "Введите год рождения";
        if (trim($data["login"]) == '')
            $error[] = "Введите логин";
        if ($data["password1"] = '')
            $error[] = "Введите пароль";
        if($data["password3"] != $data["password2"])
            $error[] = "пароли не совподают";

        $now = new Datetime();
        $now = intval($now->format("Y"));
        $dateOfBirn = new DateTime($data["date_of_born"]);
        $dateOfBirn = intval($dateOfBirn->format("Y"));

        if ($now - $dateOfBirn >= 100 || $now - $dateOfBirn <= 3)
            $error[] = "Введен неправильный год рождения";

        /*if (preg_match("/[a-zA-Z0-9_]/", $data["login"]))
            $error[] = "некорректный логин";*/

        //доделать проверку на русские буквы


        if (empty($error)) {
            $login = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["login"]))));
            $query = "Select name from `client` where login = " . "\"" . $login . "\";";
            $object = mysqli_query($mysqli, $query);
            $arr = mysqli_fetch_all($object);
            if (count($arr) != 0)
                $error[] = "пользователь с таким логином уже существует ";
        }


        if (empty($error)) {
            $login = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["login"]))));
            $password = password_hash($data["password2"], PASSWORD_DEFAULT);
            $name = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["name"]))));
            $surname = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["surname"]))));
            $phoneNumber = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["phone_number"]))));
            $dateOfBirth = $data["date_of_born"];

            if ($form == "sign_up_client")
                $query = "Insert into `client` values (null, true, \"$name\", \"$surname\", \"$phoneNumber\", \"$dateOfBirth\", \"$login\", \"$password\")";
            else
                $query = "Insert into `client` values (null, false, \"$name\", \"$surname\", \"$phoneNumber\", \"$dateOfBirth\", \"$login\", \"$password\")";

            mysqli_query($mysqli, $query);
            header('Location: index.php');
        } else
            return $error;
    }
}

function login($data, $mysqli)
{
    if (isset($data["do_login"])) {
        $user = array();
        $error = array();

        if ($data["login"] == '')
            $error[] = "Введите логин";
        if($data["password2"] == '')
            $error[] = "Введите пароль";

        if(empty($error)) {
            $login = mysqli_real_escape_string($mysqli, htmlspecialchars(stripslashes(trim($data["login"]))));

            $query = "Select password, is_client  from `client` where login = " . "\"" . $login . "\";";
            $object = mysqli_query($mysqli, $query);
            $arr = mysqli_fetch_all($object);
			
            if (count($arr) == 0)
                $error[] = "такого пользователя не существует";
            else if (!password_verify($data["password2"], $arr[0][0]))
                $error[] = "такого пользователя не существует";

            if (count($arr) != 0){
                $user[] = $login;
                $user[] = $arr[0][1];
            }
        }
        else
            return $error;

        if (empty($error)) {
            $_SESSION["logged_user"] = $user;
            header('Location: index.php');
        } else
            return $error;
    }
}

function getListOfCities($mysqli){
    $query = "Select name from `city`";
    $object = mysqli_query($mysqli, $query);
    $cities = mysqli_fetch_all($object);
    $arrWithCities = array();

    for ($i = 0; $i < count($cities); $i++)
        for ($j = 0; $j < 1; $j++)
            $arrWithCities[] = $cities[$i][$j];

    return $arrWithCities;
}

function getListOfGenres($mysqli){
    $query = "Select name from `genre`";
    $object = mysqli_query($mysqli, $query);
    $genres = mysqli_fetch_all($object);
    $arrWithGenres = array();

    for ($i = 0; $i < count($genres); $i++)
        for ($j = 0; $j < 1; $j++)
            $arrWithGenres[] = $genres[$i][$j];

    return $arrWithGenres;
}

class Film{
    public $name;
    public $releaseDate;
    public $linkForImage;
    public $description;
    public $genres = array();
}

function getListOfFilms($mysqli, $minValue, $NumberOfPage, $divider){
    $min = $minValue + (($NumberOfPage-1) * $divider);
    $max = $min + $divider;

    $query = "Select id_film, name, release_date, image, description from `film` where id_film >= $min AND id_film < $max;";
    $object = mysqli_query($mysqli, $query);
    $arr = mysqli_fetch_all($object);
    $films = array();

    for ($i = 0; $i < count($arr); $i++){
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

        for($k = 0; $k < count($arr2); $k++)
            $film->genres[] = $arr2[$k][0];

        $films[] = $film;
    }

    return $films;
}

?>

