<?php
session_start();

$hide_frame = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
    exit("Permissionerror");
}


if (isset($_POST["articleId"])) {
    $type = "article";
} else if (isset($_POST["userId"])) {
    $type = "user";
} else {
    return "Formerror";
}

if ($type === "article") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_article_comment_by_id($_POST["commentId"])["userId"] !== $_SESSION["userId"]) && (intval($data->get_article_by_id($_POST["articleId"])["userId"]) !== intval($_SESSION["userId"]))) {
        exit("Permissionerror");
    }
    $data->delete_article_comment_by_id($_POST["commentId"]);
} else if ($type === "user") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_user_comment_by_id($_POST["commentId"])["userId"] !== $_SESSION["userId"])  && (intval($_POST["userId"]) !== intval($_SESSION["userId"]))) {
        exit("Permissionerror");
    }
    $data->delete_user_comment_by_id($_POST["commentId"]);
}

exit($_POST["commentId"]);