<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

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
        $mail->notify($_SESSION["userId"], 6, "/forum/v2/#Settings", '{{passwordchanged}}');
    } else {
        exit($data->get_user_notification_setting($_SESSION["userId"]));
    }
    $data->add_settings_change("userPassword", "", "", $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPassword", password_hash($change["userPassword"], PASSWORD_DEFAULT));
}
if (isset($change["userDescription"]) && $change["userDescription"] !== $data->get_user_by_id($_SESSION["userId"])["userDescription"]) {
    $data->add_settings_change("userDescription", $data->get_user_by_id($_SESSION["userId"])["userDescription"], $filter->purify($change["userDescription"], 25), $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userDescription", $filter->purify($change["userDescription"], 25));
}
if (isset($change["userAge"]) && intval($change["userAge"]) !== intval($data->get_user_by_id($_SESSION["userId"])["userAge"])) {
    if (!is_numeric($change["userAge"])) {
        $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Formerror");
    }
    $data->add_settings_change("userAge", $data->get_user_by_id($_SESSION["userId"])["userAge"], $filter->purify($change["userAge"], 25), $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userAge", $filter->purify($change["userAge"], 25));
}
if (isset($change["userEmployment"]) && $change["userEmployment"] !== $data->get_user_by_id($_SESSION["userId"])["userEmployment"]) {
    $data->add_settings_change("userEmployment", $data->get_user_by_id($_SESSION["userId"])["userEmployment"], $filter->purify($change["userEmployment"], 25), $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userEmployment", $filter->purify($change["userEmployment"], 25));
}
if (isset($change["userMail"]) && $change["userMail"] !== $data->get_user_by_id($_SESSION["userId"])["userMail"]) {
    if (isset($_SESSION["linkLogged"])) {
        exit("Not allowed");
    }
    $data->add_settings_change("userMail", $data->get_user_by_id($_SESSION["userId"])["userMail"], $filter->purify($change["userMail"], 25), $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userMail", $filter->purify($change["userMail"], 25));
}
if (isset($change["userPhone"]) && $change["userPhone"] !== $data->get_user_by_id($_SESSION["userId"])["userPhone"]) {
    $data->add_settings_change("userPhone", $data->get_user_by_id($_SESSION["userId"])["userPhone"], $filter->purify($change["userPhone"], 25), $_SESSION["userId"], $_SERVER['REMOTE_ADDR']);
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPhone", $filter->purify($change["userPhone"], 25));
}

exit("Success");