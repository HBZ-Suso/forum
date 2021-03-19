<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if ($rargs["public"] == "hidden") {
    $data->set_user_setting("public", $_SESSION["userId"], false);
} else {
    $data->set_user_setting("public", $_SESSION["userId"], true);
}
exit($data->get_user_setting("public", $_SESSION["userId"]));