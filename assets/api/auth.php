<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!isset($rargs["fp"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (strlen($rargs["fp"]) > 40) {
    $data->create_error("Authenticityerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Authenticityerror");
}


$data->set_fingerprint($rargs["fp"]);

exit("Success");