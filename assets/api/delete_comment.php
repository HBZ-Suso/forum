<?php
session_start();

$hide_frame = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (isset($rargs["articleId"])) {
    $type = "article";
} else if (isset($rargs["userId"])) {
    $type = "user";
} else {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if ($type === "article") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_article_comment_by_id($rargs["commentId"])["userId"] !== $_SESSION["userId"]) && (intval($data->get_article_by_id($rargs["articleId"])["userId"]) !== intval($_SESSION["userId"]))) {
        $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Permissionerror");
    }
    $data->delete_article_comment_by_id($rargs["commentId"]);
} else if ($type === "user") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_user_comment_by_id($rargs["commentId"])["userId"] !== $_SESSION["userId"])) {
        $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Permissionerror");
    }
    $data->delete_user_comment_by_id($rargs["commentId"]);
}

exit($rargs["commentId"]);