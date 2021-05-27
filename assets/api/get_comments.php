<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["articleId"]) && !isset($rargs["userId"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}


header("Content-Type: application/json");
if ($rargs["articleId"]) {
    $comments = $data->get_article_comments_by_id($rargs["articleId"]);
    if (isset($comments)) {
        for ($iter = 0; $iter < count($comments); $iter++) {
            if (!isset($comments[$iter]["userId"])) {continue;}
            $comments[$iter]["userName"] = $data->get_username_by_id($comments[$iter]["userId"]);
            $comments[$iter]["userColor"] = $data->get_user_setting("color", $comments[$iter]["userId"]);
        }
    }
    exit(json_encode($comments));
}

if ($rargs["userId"]) {
    $comments = $data->get_user_comments_by_id($rargs["userId"]);
    if (isset($comments)) {
        for ($iter = 0; $iter < count($comments); $iter++) {
            if (!isset($comments[$iter]["userId"])) {continue;}
            $comments[$iter]["userName"] = $data->get_username_by_id($comments[$iter]["userId"]);
            $comments[$iter]["userColor"] = $data->get_user_setting("color", $comments[$iter]["userId"]);
        }
    }
    exit(json_encode($comments));
}