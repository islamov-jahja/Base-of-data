<?php
require_once ("../includes/functions.inc.php");
require_once ("../includes/db.inc.php");
require_once ("../includes/twig.inc.php");

unset($_SESSION["logged_user"]);
header('Location: index.php');
?>