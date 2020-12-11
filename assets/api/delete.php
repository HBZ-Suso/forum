<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    exit("Permissionerror");
}


if (isset($_POST["userId"])) {
    if (!($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($_POST["userId"])) && !$_SESSION["userId"] === $_POST["userId"]) {
        exit("Permissionerror");
    }

    $data->delete_user_by_id($_POST["userId"]);;
    exit("Success");
} else if (isset($_POST["articleId"])) {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && !$_SESSION["userId"] === $data->get_article_by_id($_POST["articleId"])["userId"]) {
        exit("Permissionerror");
    }

    $data->delete_article_by_id($_POST["articleId"]);;
    exit("Success");
}


exit("Requesterror");