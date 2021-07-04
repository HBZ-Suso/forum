<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

$rargs = array_merge($_GET, $_POST);

if (!isset($rargs["category"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

$articlIds = $data->get_articleIds_by_category($rargs["category"]);
foreach ($articleIds as $value) {
    $value["userName"] = $data->get_user_by_id($value["userId"]);
}
header("Content-Type: application/json");
exit(json_encode($articlIds));