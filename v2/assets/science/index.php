<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);



if (!isset($rargs["type"]) || !isset($rargs["value"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (!isset($_SESSION["userId"])) {
    $userId = "false";
} else {
    $userId = $_SESSION["userId"];
}

switch ($rargs["type"]) {
    case "logs":
        
        $data->add_log("logs", $rargs["value"], $_SERVER["REMOTE_ADDR"], $_SERVER['HTTP_USER_AGENT'], $userId);
        break;
    default:
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        exit("Requesterror");
        break;
}


