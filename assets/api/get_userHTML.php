<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["userId"])) {
    $userId = $rargs["userId"];
    if (isset($rargs["userName"]) && intval($data->get_user_id_by_name($rargs["userName"])) !== intval($rargs["userId"])) {
        die("Requesterror");
    }
} else {
    $userId = intval($data->get_user_id_by_name($rargs["userName"]));
}


$user_data = $data->get_user_by_id($userId);
if ($user_data === false) {
    die("nonexistentusererror");
}


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/user.php";
exit(get_user_html($userId, $user_data, $data, $text, $info));