<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("login.twig");
$data = $_POST;

$error = login($data, $mysqli);

echo $template->render(array(
        'error' => $error[0]
));

?>