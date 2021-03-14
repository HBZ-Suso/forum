<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (
    !isset($rargs["title"]) || 
    !isset($rargs["text"])
    ) {
        $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Formerror");
    }

if ($data->create_report($filter->purify($_POST["title"], 50), $filter->purify($_POST["text"], 35))) {
    exit("success");
} else {
    exit("error");
}