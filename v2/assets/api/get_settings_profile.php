<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


$rargs = array_merge($_GET, $_POST);
$user_data = $data->get_user_by_id($_SESSION["userId"]);

$settings_data = [];
$settings_data["userMail"] = $user_data["userMail"];
$settings_data["userPhone"] = $user_data["userPhone"];
$settings_data["userEmployment"] = $user_data["userEmployment"];
$settings_data["userAge"] = $user_data["userAge"];
$settings_data["userDescription"] = $user_data["userDescription"];

header("Content-Type: application/json");
exit(json_encode($settings_data));