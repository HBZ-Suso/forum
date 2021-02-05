<?php

if (isset($_GET["articleId"])) {
    $articleId = $_GET["articleId"];
    if (isset($_GET["articleTitle"]) && intval($data->get_article_id_by_title($_GET["articleTitle"])) !== intval($_GET["articleId"])) {
        header("LOCATION:/forum/?error=requesterror");
        die("<script>window.location='/forum/?error=requesterror';</script>");
    }
} else {
    $articleId = intval($data->get_article_id_by_title($_GET["articleTitle"]));
}

$article_data = $data->get_article_by_id($articleId);
if ($article_data === false) {
    header("LOCATION:/forum/?error=notexistentarticle");
    die("<script>window.location='/forum/?error=notexistentarticle';</script>");
}


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/article.php";
exit(get_article_html($articleId, $article_data, $data, $text, $info));