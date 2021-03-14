<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["username"]) || !isset($rargs["password"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if ($data->check_login($rargs["username"], $rargs["password"])) {
    $_SESSION["user"] = $rargs["username"];
    $_SESSION["userId"] = intval($data->get_user_id_by_name($_SESSION["user"]));
    $_SESSION["userIp"] = $info->get_ip();
    exit("Success");
} else {
    $data->create_error("Loginerrors",  $_SERVER["SCRIPT_NAME"]);
    exit("Loginerror");
}
