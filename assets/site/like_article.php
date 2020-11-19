<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_SESSION["userId"]) && isset($_GET["articleId"])) {
    $data->execute_like($_SESSION["userId"], $_GET["articleId"]);
    if (isset($_GET["refer"])) {
        header("LOCATION:" . $_GET["refer"]);
        exit("Refered back to " . $_GET["refer"]);
    }
    header("LOCATION:/forum/?articleId=" . $_GET["articleId"]);
    exit("Refered back to /forum/?articleId=" . $_GET["articleId"]);
}

header("LOCATION:/forum/?error=likerequesterror");
exit("Likerequesterror");