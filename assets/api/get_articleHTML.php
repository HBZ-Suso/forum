<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["articleId"])) {
    $articleId = $rargs["articleId"];
    if (isset($rargs["articleTitle"]) && intval($data->get_article_id_by_title($rargs["articleTitle"])) !== intval($rargs["articleId"])) {
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        die("Requesterror");
    }
} else {
    $articleId = intval($data->get_article_id_by_title($rargs["articleTitle"]));
}

$article_data = $data->get_article_by_id($articleId);
if ($article_data === false) {
    $data->create_error("Nonexistentarticleerror",  $_SERVER["SCRIPT_NAME"]);
    die("Nonexistentarticleerror");
}


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/article.php";
exit(get_article_html($articleId, $article_data, $data, $text, $info));