<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"]) || !$data->is_admin_by_id($_SESSION["userId"])) {
    exit("Permissionerror");
}


if (isset($rargs["userId"])) {
    $data->execute_verify_by_user_id($rargs["userId"]);
    exit("Success");
}


exit("Requesterror");