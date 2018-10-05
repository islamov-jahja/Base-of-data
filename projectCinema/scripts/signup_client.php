<?php
require_once ("../includes/db.inc.php");
require_once ("../includes/functions.inc.php");
require_once ("../includes/twig.inc.php");
$template = $twig->loadTemplate("registration.twig");

$data = $_POST;
$error = sigNup("sign_up_client", $data, $mysqli);
echo $template->render(array(
        'error' => $error[0]
));

?>
