<?php

echo '<script src="/forum/assets/script/include/replace_highlights.js" defer></script>';

echo '
<div class="highlights-block block block theme-main-color-2">
    <h1 class="highlights-block-heading block-heading">Highlights</h1>';

if (isset($_GET["search"])) {
    $phrase = $_GET["search"];
} else {
    $phrase = "";
}


if (intval($_SESSION["highlightPage"]) < 0) {
    $_SESSION["highlightPage"] = 0;
}

if (!isset($_SESSION["highlightPage"])) {
    $_SESSION["highlightPage"] = 0;
}



$highlight_data = $data->get_highlights_by_user_id($_SESSION["userId"], intval($_SESSION["highlightPage"]) * $info->page_amount(), $info->page_amount());

echo '<div class="scroll-el" id="highlight-block-scroll">';



foreach (array_reverse($highlight_data) as $value) {
    if ($data->is_logged_in() && ($_SESSION["userId"] === $value["userId"])) {
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


    if ($info->mobile === true) {
        $like_text = '<img class="like-icon-heart" src="https://img.icons8.com/fluent/48/000000/like.png"/>';
    } else {
        $like_text = $text->get("highlight-block-like");
    }

    if ($info->mobile === true) {
        $view_text = '<img class="view-icon-eye" src="https://img.icons8.com/material-sharp/24/000000/visible.png"/>';
    } else {
        $view_text = $text->get("highlight-block-views");
    }



    if (isset($value["articleId"])) {
        echo '
            <div ref="articleId=' . $value["articleId"] . '" class="highlights-block-entry theme-main-color-3 hover-theme-main-4 block-entry' . $self . '" id="highlights_article_' . $value["articleId"] . '">
                <span class="highlight-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["articleTitle"]) . '</span><br>
                <span class="highlight-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">' . $text->get("highlight-block-author") . ' </p>' . htmlspecialchars($data->get_username_by_id($value["userId"])) . $verified . '</span>
                <span class="highlight-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_article_views_by_article_id($value["articleId"]) . '</span>
                <span class="highlight-block-entry-element block-entry-element article-likes"><p class="article-likes-heading article-block-entry-heading block-entry-heading">' . $like_text . ' </p>' . $data->get_article_likes_by_article_id($value["articleId"]) . '</span><br>
            </div>

            <script>
            document.getElementById("highlights_article_' . $value["articleId"] . '").addEventListener("click", (e) => {
                if (typeof pc_findings == "undefined") {
                    window.location = "/forum/?articleId=' . $value["articleId"] . '";
                } else {
                    view("articleId=' . $value["articleId"] . '");
                }
            })
            </script>
        ';
    } else if (isset($value["userName"])) {
        echo '
        <div ref="userId=' . $value["userId"] . '" class="highlights-block-entry theme-main-color-3 hover-theme-main-4 block-entry' . $self . '" id="highlights_user_' . $value["userId"] . '">
            <span class="highlight-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["userName"])  . $verified . '</span><br>
            <span class="highlight-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">' . htmlspecialchars($text->get("highlight-block-mail")) . '</p>' . $value["userMail"] . '</span>
            <span class="highlight-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">' . $view_text . ' </p>' . $data->get_user_views_by_targetUserId($value["userId"]) . '</span>
            <span class="highlight-block-entry-element block-entry-element user-likes"><p class="user-likes-heading user-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_user_likes_by_targetUserId($value["userId"]) . '</span><br>
        </div>

        <script>
        document.getElementById("highlights_user_' . $value["userId"] . '").addEventListener("click", (e) => {
            if (typeof pc_findings == "undefined") {
                window.location = "/forum/?userId=' . $value["userId"] . '";
            } else {
                view("userId=' . $value["userId"] . '");
            }
        })
        </script>
    ';
    }
}


echo '
</div>
<img alt="<-" id="hwr" class="page-arrow page-arrow-right" src="https://img.icons8.com/flat_round/64/000000/arrow--v1.png"/>
<script>document.getElementById("hwr").addEventListener("click", () => {axios.post("/forum/assets/api/set_highlightPage.php?highlightPage=" + (parseInt(document.getElementById("hpc").innerText))).then((result) => {reset_highlights(); document.getElementById("hpc").innerText = parseInt(document.getElementById("hpc").innerText) + 1}).catch((e) => {console.debug(e);})})</script>
<p class="highlightPage" id="hpc">' . (intval($_SESSION["highlightPage"]) + 1) . '</p>
<img alt="<-" id="hwl" class="page-arrow page-arrow-left" style="transform: rotate(180deg); " src="https://img.icons8.com/flat_round/64/000000/arrow--v1.png"/>
<script>document.getElementById("hwl").addEventListener("click", () => {axios.post("/forum/assets/api/set_highlightPage.php?highlightPage=" + (parseInt(document.getElementById("hpc").innerText - 2))).then((result) => {if (parseInt(document.getElementById("hpc").innerText) - 1  > 0) {reset_highlights(); document.getElementById("hpc").innerText = parseInt(document.getElementById("hpc").innerText) - 1}}).catch((e) => {console.debug(e);})})</script>
</div>';
