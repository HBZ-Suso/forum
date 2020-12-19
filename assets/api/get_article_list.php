<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["search"])) {
    $phrase = $rargs["search"];
} else {
    $phrase = "";
}

if (isset($rargs["max"]) && $rargs["max"] < 1000) {
    $max = $rargs["max"];
} else if (isset($rargs["max"]) && $rargs["max"] >= 1000) {
    exit("Requesterror");
} else {
    $max = 100;
}

$article_data = $data->search_articles($phrase, $max);

foreach($article_data as $index => $element) {
    unset($element["articleText"]);
    if (isset($rargs["includeUserNames"])) {
        $element["userName"] = $data->get_username_by_id($element["userId"]);
    }
    $article_data[$index] = $element;
}

header("Content-Type: application/json");
exit(json_encode($article_data));