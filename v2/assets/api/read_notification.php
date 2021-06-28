<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();

$rargs = array_merge($_GET, $_POST);

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if (!isset($rargs["notificationId"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (!$data->notification_is_owned_by_user_id($rargs["notificationId"], $_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

$data->read_notification_by_id($rargs["notificationId"]);
exit("Success");