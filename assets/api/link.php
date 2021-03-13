<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["username"]) || !isset($rargs["password"]) || !isset($rargs["linkinfo"]) || !isset($rargs["linkgrade"])) {
    exit("Formerror");
}

if (intval($ragrs["linkgrade"]) === null) {
    exit("Requesterror");
} else if (intval($ragrs["linkgrade"]) > 1 || intval($ragrs["linkgrade"]) < 0) {
    exit("Requesterror");
}

if ($data->check_login($rargs["username"], $rargs["password"])) {
    exit($data->create_link($data->get_user_id_by_name($rargs["username"]), $rargs["linkinfo"], $rargs["linkgrade"]));
} else {
    exit("Loginerror");
}
