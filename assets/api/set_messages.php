<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!isset($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if ($rargs["messages"] === "on") {
    $data->set_user_setting("messages", $_SESSION["userId"], "on");
} else if ($rargs["messages"] === "followed") {
    $data->set_user_setting("messages", $_SESSION["userId"], "followed");
} else if ($rargs["messages"] === "contacted") {
    $data->set_user_setting("messages", $_SESSION["userId"], "contacted");
} else {
    $data->set_user_setting("messages", $_SESSION["userId"], "off");
}

exit($data->get_user_setting("messages", $_SESSION["userId"]));