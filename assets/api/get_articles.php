<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["search"])) {
    $phrase = $rargs["search"];
} else {
    $phrase = "";
}

if (intval($_SESSION["articlePage"]) < 0) {
    $_SESSION["articlePage"] = 0;
}

if (!isset($_SESSION["articlePage"])) {
    $_SESSION["articlePage"] = 0;
}

if (isset($rargs["page"])) {
    $page = intval($rargs["page"]);
} else {
    $page = intval($_SESSION["articlePage"]);
}

if (isset($rargs["rsearch"])) {
    $mode_list = array();

    if (isset($rargs["title"])) {
        array_push($mode_list, "articleTitle");
    }
    if (isset($rargs["text"])) {
        array_push($mode_list, "articleText");
    }
    if (isset($rargs["author"])) {
        array_push($mode_list, "userId");
    }

    $article_list = $data->search_articles($rargs["rsearch"], $page * $info->page_amount(), $info->page_amount(), $mode_list);
} else {
    $article_list = $data->search_articles($phrase, $page * $info->page_amount(), $info->page_amount());
}

$return = "";
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

    $return .= '
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



echo $return;