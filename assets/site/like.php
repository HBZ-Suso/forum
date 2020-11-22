<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_SESSION["userId"])) {
    if (isset($_GET["articleId"])) {
        $data->execute_article_like($_SESSION["userId"], $_GET["articleId"]);
        if (isset($_GET["refer"])) {
            header("LOCATION:" . $_GET["refer"]);
            exit("Refered back to " . $_GET["refer"]);
        }
        header("LOCATION:/forum/?articleId=" . $_GET["articleId"]);
        exit("Refered back to /forum/?articleId=" . $_GET["articleId"]);
    }
    if (isset($_GET["targetUserId"])) {
        $data->execute_user_like($_SESSION["userId"], $_GET["targetUserId"]);
        if (isset($_GET["refer"])) {
            header("LOCATION:" . $_GET["refer"]);
            exit("Refered back to " . $_GET["refer"]);
        }
        header("LOCATION:/forum/?userId=" . $_GET["targetUserId"]);
        exit("Refered back to /forum/?userId=" . $_GET["targetUserId"]);
    }
}

header("LOCATION:/forum/?error=requesterror");
exit("Requesterror");