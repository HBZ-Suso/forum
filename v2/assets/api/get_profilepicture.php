<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

$rargs = array_merge($_GET, $_POST);

if (!isset($rargs["userId"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if ($data->get_user_by_id(intval($rargs["userId"])) === false) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}


$uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/data/profilePictures/";
$name = $rargs["userId"]; // Assuming the file name is in the URL for this example


header("Content-Type: image/png");
if (readfile($uploaddir.$name.$data->get_user_setting("pPE", $rargs["userId"]))) {
} else {
    readfile($_SERVER["DOCUMENT_ROOT"] . "/forum/assets/img/icon/user.png");
}

exit();