<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["userId"])) {
    $userId = $rargs["userId"];
    if (isset($rargs["userName"]) && intval($data->get_user_id_by_name($rargs["userName"])) !== intval($rargs["userId"])) {
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        die("Requesterror");
    }
} else {
    $userId = intval($data->get_user_id_by_name($rargs["userName"]));
}


$user_data = $data->get_user_by_id($userId);
if ($user_data === false) {
    $data->create_error("Nonexistentusererror",  $_SERVER["SCRIPT_NAME"]);
    die("Nonexistentusererror");
}

if ($data->get_user_setting("public", $user_data["userId"]) === false && !($data->is_logged_in() && (($_SESSION["userId"] === $user_data["userId"]) || $data->is_admin_by_id($_SESSION["userId"]) || $data->is_moderator_by_id($_SESSION["userId"])))) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    die("Permissionerror");
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/user.php";
exit(get_user_html($userId, $user_data, $data, $text, $info));