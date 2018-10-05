<?php
$mysqli = mysqli_connect('127.0.0.1', 'root', '', 'project_cinema');
mysqli_set_charset($mysqli, "utf8");


if ($mysqli->connect_error) {
    header("HTTP/1.1 500 Internal server error");
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}

session_start();
?>