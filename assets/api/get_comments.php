<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_POST["articleId"]) && !isset($_POST["userId"])) {
    exit("Formerror");
}


header("Content-Type: application/json");
if ($_POST["articleId"]) {
    $comments = $data->get_article_comments_by_id($_POST["articleId"]);
    if (isset($comments)) {
        for ($iter = 0; $iter < count($comments); $iter++) {
            if (!isset($comments[$iter]["userId"])) {continue;}
            $comments[$iter]["username"] = $data->get_username_by_id($comments[$iter]["userId"]);
        }
    }
    exit(json_encode($comments));
}

if ($_POST["userId"]) {
    $comments = $data->get_user_comments_by_id($_POST["userId"]);
    if (isset($comments)) {
        for ($iter = 0; $iter < count($comments); $iter++) {
            if (!isset($comments[$iter]["userId"])) {continue;}
            $comments[$iter]["username"] = $data->get_username_by_id($comments[$iter]["userId"]);
        }
    }
    exit(json_encode($comments));
}