<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (isset($rargs["userId"])) {
    exit("Deprecatederror");

    if (!($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($rargs["userId"]))) {
        $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Permissionerror");
    }
    if (isset($_SESSION["linkLogged"])) {
        exit("Not allowed");
    }
    $data->delete_user_by_id($rargs["userId"]);;
    exit("Success");
} else if (isset($rargs["articleId"])) {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && !$_SESSION["userId"] === $data->get_article_by_id($rargs["articleId"])["userId"]) {
        $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Permissionerror");
    }

    if ($data->is_logged_in()) {
        $mail->notify($_SESSION["userId"], 14, "", '"' .  $data->get_article_by_id($rargs["articleId"])["articleTitle"] . '" {{articledeleted}}');
    }
    $data->delete_article_by_id($rargs["articleId"]);;
    exit("Success");
}

$data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
exit("Requesterror");