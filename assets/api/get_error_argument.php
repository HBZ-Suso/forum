<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["error_argument"])) {
    exit("Requesterror");
}

$error_data = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/forum/assets/data/errors.json"), true);


if (array_key_exists(strtoupper($rargs["error_argument"]), $error_data)) {
    exit(json_encode($error_data[strtoupper($rargs["error_argument"])]));
} else {
    exit("Unknown error");
}

