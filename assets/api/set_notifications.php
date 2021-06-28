<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}



$mail->notify($_SESSION["userId"], 0, "/forum/v2/#Settings", '{{notification}}{{settingschanged}}');



if ($rargs["level"] == "low") {
    $data->set_user_setting("privacy", $_SESSION["userId"], 0);
} else if ($rargs["level"] == "medium") {
    $data->set_user_setting("privacy", $_SESSION["userId"], 1);
} else {
    $data->set_user_setting("privacy", $_SESSION["userId"], 2);
}
exit($data->get_user_setting("privacy", $_SESSION["userId"]));