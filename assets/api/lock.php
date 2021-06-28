<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";


if ($data->is_logged_in() && isset($rargs["userId"])) {
    $userId = $rargs["userId"];
    if (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId)) || ($data->is_moderator_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId) && !$data->is_moderator_by_id($userId)) || intval($userId) === intval($_SESSION["userId"])) {
        if ($data->get_user_lock($userId) == "0") {
            $data->toggle_user_lock($userId, "1");
            $mail->notify($rargs["userId"], 9, "", '{{locked}}');
        } else {
            $mail->notify($rargs["userId"], 12, "", '{{unlocked}}');
            $data->toggle_user_lock($userId, "0");
        }
        exit("success");
    } else {
        $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Permissionerror");
    }
} else {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}
$data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
exit("Requesterror");