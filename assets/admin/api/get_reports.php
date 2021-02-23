<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    exit("Permissionerror");
}

if (!$data->is_admin_by_id($_SESSION["userId"])) {
    exit("Permissionerror");
}

if (isset($rargs["field"]) && isset($rargs["to"]) && $rargs["field"] !== "" && $rargs["to"] !== "") {
    if (!in_array($rargs["field"], array("reportId", "reportTitle", "reportDate", "reportIp", "userId"))) {
        exit ("Requesterror");
    }
    exit(json_encode($data->get_reports($rargs["min"], $rargs["max"], $rargs["field"], $rargs["to"])));
} else {
    exit(json_encode($data->get_reports($rargs["min"], $rargs["max"], false, false)));
}

