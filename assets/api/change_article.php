<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    exit("Formerror");
}


if (!isset($rargs["articleData"]) || (!isset($rargs["articleId"]))) {
    exit("Formerror");
}

if (isset(json_decode($rargs["articleData"], true)["articleText"])) { 
    $data->change_article_column_by_id_and_name($rargs["articleId"], "articleText", $filter->purify(json_decode($rargs["articleData"], true)["articleText"], 25));
}

if (isset(json_decode($rargs["articleData"], true)["articleTitle"])) {
    $data->change_article_column_by_id_and_name($rargs["articleId"], "articleTitle", $filter->purify(json_decode($rargs["articleData"], true)["articleTitle"], 25));
}
