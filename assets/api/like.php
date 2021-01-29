<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if ($data->is_logged_in()) {
    if (isset($rargs["articleId"])) {
        $data->execute_article_like($_SESSION["userId"], $rargs["articleId"]);
        exit("Success");
    }
    if (isset($rargs["targetUserId"])) {
        $data->execute_user_like($_SESSION["userId"], $rargs["targetUserId"]);
        exit("Success");
    }
} else {
    exit("Permissionerror");
}

exit("Requesterror");