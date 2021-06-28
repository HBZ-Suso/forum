<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if ($data->is_logged_in()) {
    if (isset($rargs["articleId"])) {
        if (intval($data->get_article_likes_by_article_id($rargs["articleId"])) < 4) {
            $mail->notify($data->get_article_by_id($rargs["articleId"]), 0, "/forum/v2/#Article?articleId=" . $rargs["articleId"], '<span class="notification-userLink" onclick="/forum/v2/#Profile?userId=' . $_SESSION["userId"] . '">"' . $data->get_user_by_id($_SESSION["userId"])["userName"] . '"</span>{{liked}}"' . $data->get_article_by_id($rargs["articleId"])["articleTitle"] . '"');
        }
        $data->execute_article_like($_SESSION["userId"], $rargs["articleId"]);
        exit("Success");
    }
    if (isset($rargs["targetUserId"])) {
        if (intval($data->get_user_likes_by_targetUserId($rargs["userId"])) < 4) {
            $mail->notify($rargs["targetUserId"], 1, "/forum/v2/#Profile?userId=" . $rargs["targetUserId"], '<span class="notification-userLink" onclick="/forum/v2/#Profile?userId=' . $_SESSION["userId"] . '">"' . $data->get_user_by_id($_SESSION["userId"])["userName"] . '"</span>{{liked}}"' . $data->get_user_by_id($rargs["targetUserId"])["userName"] . '"');
        }
        $data->execute_user_like($_SESSION["userId"], $rargs["targetUserId"]);
        exit("Success");
    }
} else {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

$data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
exit("Requesterror");