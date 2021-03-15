<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (!isset($rargs["change_data"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}



$change = json_decode($rargs["change_data"], true);

if (isset($change["userPassword"])) {
    if (isset($_SESSION["linkLogged"])) {
        exit("Not allowed");
    }
    if (intval($data->get_user_notification_setting($_SESSION["userId"])) !== 0) {
        $mail->notify("passwordchanged");
    } else {
        exit($data->get_user_notification_setting($_SESSION["userId"]));
    }
    $data->add_password_change($_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPassword", password_hash($change["userPassword"], PASSWORD_DEFAULT));
}
if (isset($change["userDescription"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userDescription", $filter->purify($change["userDescription"], 25));
}
if (isset($change["userAge"])) {
    if (!is_numeric($change["userAge"])) {
        $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Formerror");
    }
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userAge", $filter->purify($change["userAge"], 25));
}
if (isset($change["userEmployment"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userEmployment", $filter->purify($change["userEmployment"], 25));
}
if (isset($change["userMail"])) {
    if (isset($_SESSION["linkLogged"])) {
        exit("Not allowed");
    }
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userMail", $filter->purify($change["userMail"], 25));
}
if (isset($change["userPhone"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPhone", $filter->purify($change["userPhone"], 25));
}

exit();