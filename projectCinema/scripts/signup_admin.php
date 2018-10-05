<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");

$data = $_POST;
sigNup("sign_up_admin", $data, $mysqli);
?>
