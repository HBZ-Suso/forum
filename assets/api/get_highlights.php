<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    $data->create_error("Requesterror", $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (isset($rargs["search"])) {
    $phrase = $rargs["search"];
} else {
    $phrase = "";
}

if (intval($_SESSION["highlightPage"]) < 0) {
    $_SESSION["highlightPage"] = 0;
}

if (!isset($_SESSION["highlightPage"])) {
    $_SESSION["highlightPage"] = 0;
}

if (isset($rargs["page"])) {
    $page = intval($rargs["page"]);
} else {
    $page = intval($_SESSION["highlightPage"]);
}

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

$highlight_data = $data->get_highlights_by_user_id($_SESSION["userId"], $page * $info->page_amount(), $info->page_amount());



$return = "";
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
        $like_text = '<img class="like-icon-heart" src="/forum/assets/img/icon/like.png"/>';
    } else {
        $like_text = $text->get("highlight-block-like");
    }

    if ($info->mobile === true) {
        $view_text = '<img class="view-icon-eye" src="/forum/assets/img/icon/visible.png"/>';
    } else {
        $view_text = $text->get("highlight-block-views");
    }



    if (isset($value["articleId"])) {
        $return .= '
            <div ref="articleId=' . $value["articleId"] . '" class="highlights-block-entry theme-main-color-3 hover-theme-main-4 block-entry' . $self . '" id="highlights_article_' . $value["articleId"] . '">
                <span class="highlight-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["articleTitle"]) .'</span><br>
                <span class="highlight-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">' . $text->get("highlight-block-author") . ' </p>' . htmlspecialchars($data->get_username_by_id($value["userId"])) . $verified . '</span>
                <span class="highlight-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
                <span class="highlight-block-entry-element block-entry-element article-likes"><p class="article-likes-heading article-block-entry-heading block-entry-heading">' . $like_text . ' </p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
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
        $return .= '
        <div ref="userId=' . $value["userId"] . '" class="highlights-block-entry theme-main-color-3 hover-theme-main-4 block-entry' . $self . '" id="highlights_user_' . $value["userId"] . '">
            <span class="highlight-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["userName"])  . $verified .'</span><br>
            <span class="highlight-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">' . htmlspecialchars($text->get("highlight-block-mail")) . '</p>' . $value["userMail"] .'</span>
            <span class="highlight-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">' . $view_text . ' </p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
            <span class="highlight-block-entry-element block-entry-element user-likes"><p class="user-likes-heading user-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
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



echo $return;