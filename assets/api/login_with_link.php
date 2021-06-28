<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


exit("DEPRECATED");


if (!isset($rargs["linkauth"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if ($data->check_linkauth($rargs["linkauth"])) {
    $user_data = $data->get_user_by_linkauth($rargs["linkauth"]);
    $_SESSION["user"] = $user_data["userName"];
    $_SESSION["userId"] = intval($user_data["userId"]);
    $_SESSION["userIp"] = $info->get_ip();
    $_SESSION["linkLogged"] = true;
    exit("Success");
} else {
    $data->create_error("Loginerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Loginerror");
}
