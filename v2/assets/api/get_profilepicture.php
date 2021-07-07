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
$name = $ragrs["userId"]; // Assuming the file name is in the URL for this example
if (file_exists($uploaddir.$name.".png")) {
    readfile($uploaddir.$name.".png");
    header("Content-Type: image/png");
    exit();
} else if (file_exists($uploaddir.$name.".jpg")) {
    readfile($uploaddir.$name.".jpg");
    header("Content-Type: image/jpg");
    exit();
} else if (file_exists($uploaddir.$name.".jpeg")) {
    readfile($uploaddir.$name.".jpeg");
    header("Content-Type: image/jpeg");
    exit();
} else {
    exit("");
}

