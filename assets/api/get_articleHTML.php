<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["articleId"])) {
    $articleId = $rargs["articleId"];
    if (isset($rargs["articleTitle"]) && intval($data->get_article_id_by_title($rargs["articleTitle"])) !== intval($rargs["articleId"])) {
        die("Requesterror");
    }
} else {
    $articleId = intval($data->get_article_id_by_title($rargs["articleTitle"]));
}

$article_data = $data->get_article_by_id($articleId);
if ($article_data === false) {
    die("nonexistentarticleerror");
}


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/article.php";
exit(get_article_html($articleId, $article_data, $data, $text, $info));