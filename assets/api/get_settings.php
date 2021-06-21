<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    $settings_data = array();

    $settings_data["language"] = $_SESSION["language"];
    $settings_data["theme"] = $_SESSION["theme"];

    header("Content-Type: application/json");
    exit(json_encode($settings_data));
}

$user_data = $data->get_user_by_id($_SESSION["userId"]);

$settings_data = json_decode($user_data["userSettings"], true);
$settings_data["language"] = $_SESSION["language"];
$settings_data["theme"] = $_SESSION["theme"];


header("Content-Type: application/json");
exit(json_encode($settings_data));