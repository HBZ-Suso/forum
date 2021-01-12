<?php 


echo '<div class="article-block block theme-main-color-2">
<h1 class="article-block-heading block-heading">' . $text->get("article-block-heading") . '</h1>';

if (isset($_GET["search"])) {
    $phrase = $_GET["search"];
} else {
    $phrase = "";
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

    $article_list = $data->search_articles($_GET["rsearch"], 100, $mode_list);
} else {
    $article_list = $data->search_articles($phrase);
}

foreach ($article_list as $value) {
    if (isset($_SESSION["userId"]) && ($_SESSION["userId"] === $value["userId"])) {
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
        $like_text = '<img class="like-icon-heart" alt="Likes: " src="https://img.icons8.com/fluent/1000/000000/like.png"/>';
    } else {
        $like_text = $text->get("article-block-like");
    }

    if ($info->mobile === true) {
        $view_text = '<img class="view-icon-eye" alt="Views: " src="https://img.icons8.com/material-sharp/1000/000000/visible.png"/>';
    } else {
        $view_text = $text->get("article-block-views");
    }

    echo '
    <div class="article-block-entry hover-theme-main-4 theme-main-color-3 block-entry' . $self . '" id="article_' . $value["articleId"] . '">
        <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . $value["articleTitle"] .'</span><br>
        <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">' . $text->get("article-block-author") . '</p>' . $data->get_username_by_id($value["userId"]) . $verified .'</span>
        <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
        <span class="article-block-entry-element block-entry-element article-likes"><p class="article-likes-heading article-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
    </div>

    <script>
        document.getElementById("article_' . $value["articleId"] . '").addEventListener("click", (e) => {
            window.location = "/forum/?articleId=' . $value["articleId"] . '&articleTitle=' . $value["articleTitle"] . '";
        })
    </script>
    ';
}

echo '</div>
';