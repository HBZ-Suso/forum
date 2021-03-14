<?php
session_start();

$hide_frame = true;
$require_purifier = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (!(isset($rargs["articleId"]) || isset($rargs["userId"])) || !isset($rargs["title"]) || !isset($rargs["text"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if ((abs(time() - $data->get_user_by_id($_SESSION["userId"])["userLastComment"]) < 60) && !($data->is_admin_by_id($_SESSION["userId"])) && !($data->is_moderator_by_id($_SESSION["userId"]))) {
    $data->create_error("Timeouterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Timeouterror");
}

if (strlen($rargs["title"]) > 100 || strlen($rargs["text"]) > 1000) {
    $data->create_error("Textlengtherror",  $_SERVER["SCRIPT_NAME"]);
    exit("Textlengtherror");
}

if (strlen($filter->purify($rargs["title"], 25)) < 1 || strlen($filter->purify($rargs["text"], 20)) < 1) {
    $data->create_error("Textlengtherror",  $_SERVER["SCRIPT_NAME"]);
    exit("Textlengtherror");        
} 

if (strval($data->get_user_lock($_SESSION["userId"])) === "1") {
    $data->create_error("Lockederror",  $_SERVER["SCRIPT_NAME"]);
    exit("Lockederror");
}

if (isset($rargs["articleId"])) {
    $data->create_article_comment($_SESSION["userId"], intval($filter->purify($rargs["articleId"], 25)), $filter->purify($rargs["title"], 25), $filter->purify($rargs["text"], 20));
} else if (isset($rargs["userId"])) {
    $data->create_user_comment($_SESSION["userId"], intval($filter->purify($rargs["userId"], 25)), $filter->purify($rargs["title"], 25), $filter->purify($rargs["text"], 20));
}

$data->set_comment_timeout_by_id($_SESSION["userId"]);

if (isset($rargs["articleId"])) {
    exit($data->get_last_article_comment_id());
} else if (isset($rargs["userId"])) {
    exit($data->get_last_user_comment_id());
}