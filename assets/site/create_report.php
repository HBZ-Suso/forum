<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (
    !isset($_POST["title"]) || 
    !isset($_POST["text"])
    ) {
        header("LOCATION:/forum/assets/site/signup.php?error=formerror&errorId=" . $data->create_error("Formerror", $_SERVER["SCRIPT_NAME"]));
        exit("Formerror");
    }

if ($data->create_report($filter->purify($_POST["title"], 50), $filter->purify($_POST["text"], 35))) {
    header("LOCATION:/forum/");
    exit("success");
} else {
    header("LOCATION:/forum/?eror=errorwhilstcreatingreport");
    exit("error");
}