<?php

echo '
<div class="highlights-block block">
    <h1 class="highlights-block-heading block-heading">Highlights</h1>';
    
if (isset($_GET["search"])) {
    $phrase = $_GET["search"];
} else {
    $phrase = "";
}

$highlight_data = $data->get_highlights_by_user_id($_SESSION["userId"]);

//echo json_encode($highlight_data);

foreach ($highlight_data as $value) {
    if (isset($_SESSION["userId"]) && ($_SESSION["userId"] === $value["userId"])) {
        $self = " owned";
    } else {
        $self = "";
    }

    if (isset($value["userName"])) {
        if ($value["userVerified"] == "1") {
            $verified = '<p class="verified">&#10003</p>';
        } else {
            $verified = "";
        }
    } else {
        if ($data->get_user_by_id($value["userId"])["userVerified"] == "1") {
            $verified = '<p class="verified">&#10003</p>';
        } else {
            $verified = "";
        }
    }



    if (isset($value["articleId"])) {
        echo '
            <div class="article-block-entry block-entry' . $self . '" id="highlights_' . $value["articleId"] . '">
                <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . $value["articleTitle"] .'</span><br>
                <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">Author: </p>' . $data->get_username_by_id($value["userId"]) . $verified . '</span>
                <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Views: </p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
                <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
            </div>

            <script>
                document.getElementById("highlights_' . $value["articleId"] . '").addEventListener("click", (e) => {
                    window.location = "/forum/?articleId=' . $value["articleId"] . '&articleTitle=' . $value["articleTitle"] . '";
                })
            </script>
        ';
    } else if (isset($value["userName"])) {
        echo '
        <div class="highlights-block-entry block-entry' . $self . '" id="highlights_' . $value["userId"] . '">
            <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . $value["userName"]  . $verified .'</span><br>
            <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">Mail: </p>' . $value["userMail"] .'</span>
            <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Views: </p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
            <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
        </div>

        <script>
            document.getElementById("highlights_' . $value["userId"] . '").addEventListener("click", (e) => {
                window.location = "/forum/?userId=' . $value["userId"] . '&userName=' . $value["userName"] . '";
            })
        </script>
    ';
    }


}

echo '</div>
';