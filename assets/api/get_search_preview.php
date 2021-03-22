<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["max"]) && intval($rargs["max"]) < 100000) {
    $max = $rargs["max"];
} else {
    $max = 50000;
}

$return = array();

$articles = $data->search_articles("", 0, $max, ["articleTitle"], "articleCreated DESC");
$users = $data->search_users("", 0, $max, ["userName"], "userCreated DESC");


foreach($articles as $value) {
    $href = "/forum/?articleId=" . $value["articleId"];
    $string = $value["articleTitle"];
    array_push($return, array("string" => $string, "href" => $href));
}

foreach($users as $value) {
    $href = "/forum/?userId=" . $value["userId"];
    $string = $value["userName"];
    array_push($return, array("string" => $string, "href" => $href));
}

header("Content-Type: application/json");
exit(json_encode($return));