<?php 
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);

if (!isset($rargs["title"]) || !isset($rargs["text"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

$data->create_report($filter->purify($rargs["title"], 50), $filter->purify($rargs["text"], 35));