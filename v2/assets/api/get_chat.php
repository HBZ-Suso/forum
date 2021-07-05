<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

$rargs = array_merge($_GET, $_POST);

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if (!isset($rargs["userId"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

header("Content-Type: application/json");
$return = ["messages" => $data->get_chat_by_user_ids($_SESSION["userId"], $rargs["userId"])];
$return["userName"] = $data->get_username_by_id($rargs["userId"]);
$return["userColor"] = $data->get_user_setting("color", $rargs["userId"]);
exit(json_encode($return));