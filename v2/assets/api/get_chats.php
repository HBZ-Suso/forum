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


$return = [];
foreach ($data->get_chats_by_user_id($_SESSION["userId"]) as $value) {
    array_push($return, [
        "userName" => $data->get_username_by_id($value),
        "lastMessage" => $data->get_last_message_by_user_id($_SESSION["userId"], $value),
        "userId" => $value
    ]);
}

header("Content-Type: application/json");
exit(json_encode($return));