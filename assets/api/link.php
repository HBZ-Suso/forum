<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


exit("DEPRECATED");


if (!isset($rargs["username"]) || !isset($rargs["password"]) || !isset($rargs["linkinfo"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}


if ($data->check_login($rargs["username"], $rargs["password"])) {
    if (intval($data->get_user_notification_setting($_SESSION["userId"])) !== 0) {
        $mail->send_mail("linked");
    }
    exit($data->create_link($data->get_user_id_by_name($rargs["username"]), $rargs["linkinfo"]));
} else {
    $data->create_error("Loginerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Loginerror");
}
