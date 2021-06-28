<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (!isset($rargs["articleData"]) || (!isset($rargs["articleId"]))) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if (isset(json_decode($rargs["articleData"], true)["articleText"])) { 
    $data->change_article_column_by_id_and_name($rargs["articleId"], "articleText", $filter->purify(json_decode($rargs["articleData"], true)["articleText"], 25));
}

if (isset(json_decode($rargs["articleData"], true)["articleTitle"])) {
    $data->change_article_column_by_id_and_name($rargs["articleId"], "articleTitle", $filter->purify(json_decode($rargs["articleData"], true)["articleTitle"], 25));
}
