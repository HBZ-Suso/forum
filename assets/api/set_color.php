<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!isset($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}
if (in_array($rargs["color"], ["red", "purple", "pink", "green", "yellow", "black", "blue", "turquoise"])) {
    $data->set_user_setting("color", $_SESSION["userId"], $rargs["color"]);
}
exit($data->get_user_setting("color", $_SESSION["userId"]));