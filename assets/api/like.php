<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_SESSION["userId"])) {
    if (isset($_POST["articleId"])) {
        $data->execute_article_like($_SESSION["userId"], $_POST["articleId"]);
        exit("Success");
    }
    if (isset($_POST["targetUserId"])) {
        $data->execute_user_like($_SESSION["userId"], $_POST["targetUserId"]);
        exit("Success");
    }
} else {
    exit("Permissionerror");
}

exit("Requesterror");