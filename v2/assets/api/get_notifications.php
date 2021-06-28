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

$notifications = $data->get_notifications_by_userId($_SESSION["userId"]);
header("Content-Type: application/json");
exit(json_encode($notifications));