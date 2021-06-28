<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in() || !$data->is_admin_by_id($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (isset($rargs["userId"])) {
    $mail->notify($rargs["userId"], 8, "/forum/v2/#Profile?userId=" . $rargs["userId"], '{{verified}}');
    $data->execute_verify_by_user_id($rargs["userId"]);
    exit("Success");
}

$data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
exit("Requesterror");