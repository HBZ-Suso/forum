<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$data->do_match();
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
        $data->add_log("logs", $rargs["value"]);
        break;
    case "details":
        if (!isset($_SESSION["detailsSent"])) {
            $_SESSION["detailsSent"] = true;
            $data->add_log("details", $rargs["value"]);
        }
        break;
    default:
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        exit("Requesterror");
        break;
}


var_dump($data->matchId);
exit("Success");
