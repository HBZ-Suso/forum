<?php
session_start();

$hide_frame = true;
$require_purifier = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
    header("LOCATION:/forum/assets/site/signup.php?error=permissionerror");
    exit("Permissionerror");
}


if (!(isset($_POST["articleId"]) || isset($_POST["userId"])) || !isset($_POST["title"]) || !isset($_POST["text"])) {
    exit("Formerror");
}

if ((abs(time() - $data->get_user_by_id($_SESSION["userId"])["userLastComment"]) < 60) && !($data->is_admin_by_id($_SESSION["userId"]))) {
    exit("Timeouterror");
}

if (isset($_POST["articleId"])) {
    $data->create_article_comment($_SESSION["userId"], $_POST["articleId"], $filter->purify($_POST["title"], 25), $filter->purify($_POST["text"], 20));
} else if (isset($_POST["userId"])) {
    $data->create_user_comment($_SESSION["userId"], $_POST["userId"], $filter->purify($_POST["title"], 25), $filter->purify($_POST["text"], 20));
}

$data->set_comment_timeout_by_id($_SESSION["userId"]);

if (isset($_POST["articleId"])) {
    exit($data->get_last_article_comment_id());
} else if (isset($_POST["userId"])) {
    exit($data->get_last_user_comment_id());
}