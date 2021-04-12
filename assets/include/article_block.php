<?php 

echo '<script src="/forum/assets/script/include/replace_articles.js" defer></script>';

echo '<div class="article-block block theme-main-color-2">
<h1 class="article-block-heading block-heading">' . $text->get("article-block-heading") . '</h1>';

if (isset($_GET["search"])) {
    $phrase = $_GET["search"];
} else {
    $phrase = "";
}

if (intval($_SESSION["articlePage"]) < 0) {
    $_SESSION["articlePage"] = 0;
}

if (!isset($_SESSION["use"])) {
    $_SESSION["articlePage"] = 0;
}

if (isset($_GET["rsearch"])) {
    $mode_list = array();

    if (isset($_GET["title"])) {
        array_push($mode_list, "articleTitle");
    }
    if (isset($_GET["text"])) {
        array_push($mode_list, "articleText");
    }
    if (isset($_GET["author"])) {
        array_push($mode_list, "userId");
    }

    $article_list = $data->search_articles($_GET["rsearch"], intval($_SESSION["articlePage"]) * $info->page_amount(), $info->page_amount(), $mode_list);
} else {
    $article_list = $data->search_articles($phrase, intval($_SESSION["articlePage"]) * $info->page_amount(), $info->page_amount());
}

echo '<div class="scroll-el" id="article-block-scroll">';

foreach ($article_list as $value) {
    if ($data->is_logged_in() && ($_SESSION["userId"] === $value["userId"])) {
        $self = " owned";
    } else {
        $self = "";
    }

    if ($data->get_user_by_id($value["userId"])["userVerified"] == "1") {
        $verified = '<p class="verified">&#10003</p>';
    } else {
        $verified = "";
    }

    if ($info->mobile === true) {
        $like_text = '<img class="like-icon-heart" alt="Likes: " src="/forum/assets/img/icon/like.png"/>';
    } else {
        $like_text = $text->get("article-block-like");
    }

    if ($info->mobile === true) {
        $view_text = '<img class="view-icon-eye" alt="Views: " src="/forum/assets/img/icon/visible.png"/>';
    } else {
        $view_text = $text->get("article-block-views");
    }

    echo '
    <div ref="articleId=' . $value["articleId"] . '" class="article-block-entry hover-theme-main-4 theme-main-color-3 block-entry' . $self . '" id="article_' . $value["articleId"] . '">
        <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["articleTitle"]) .'</span><br>
        <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">' . $text->get("article-block-author") . '</p>' . htmlspecialchars($data->get_username_by_id($value["userId"])) . $verified .'</span>
        <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
        <span class="article-block-entry-element block-entry-element article-likes"><p class="article-likes-heading article-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
    </div>

    <script>
    document.getElementById("article_' . $value["articleId"] . '").addEventListener("click", (e) => {
        if (typeof pc_findings == "undefined") {
            window.location = "/forum/?articleId=' . $value["articleId"] . '";
        } else {
            view("articleId=' . $value["articleId"] . '");
        }
    })
    </script>
    ';
}

echo '
</div>
<script>var current_search="' . $rargs["search"] . '";</script>
<img alt="->" id="awr" class="page-arrow page-arrow-right" src="/forum/assets/img/icon/arrow--v1.png"/>
<script>document.getElementById("awr").addEventListener("click", (ev) => {axios.post("/forum/assets/api/set_articlePage.php?articlePage=" + (parseInt(document.getElementById("apc").innerText))).then((result) => {reset_articles(); document.getElementById("apc").innerText = parseInt(document.getElementById("apc").innerText) + 1}).catch((e) => {console.debug(e);})})</script>
<p class="articlePage" id="apc">' . (intval($_SESSION["articlePage"]) + 1) .'</p>
<img alt="<-" id="awl" class="page-arrow page-arrow-left" style="transform: rotate(180deg); " src="/forum/assets/img/icon/arrow--v1.png"/>
<script>document.getElementById("awl").addEventListener("click", () => {axios.post("/forum/assets/api/set_articlePage.php?articlePage=" + (parseInt(document.getElementById("apc").innerText - 2))).then((result) => {if (parseInt(document.getElementById("apc").innerText) - 1  > 0) {reset_articles(); document.getElementById("apc").innerText = parseInt(document.getElementById("apc").innerText) - 1}}).catch((e) => {console.debug(e);})})</script>
</div>
';