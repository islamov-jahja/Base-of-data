<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

$data = $_POST;

if(isset($data["do_search"]))
    echo $data["city"].' '.$data["nameOfFilm"];
?>