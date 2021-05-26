<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["articleId"]) && !isset($rargs["articleTitle"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (isset($rargs["articleTitle"]) && !isset($rargs["articleId"])) {
    $id = $data->get_article_id_by_title($rargs["articleTitle"]);
} else {
    $id = $rargs["articleId"];
}

$article_data = $data->get_article_by_id($id);

if ($article_data != false) {
    $article_data["userName"] = $data->get_user_by_id($article_data["userId"])["userName"];
}

header("Content-Type: application/json");
exit(json_encode($article_data));