<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/comment_block.php";

function get_article_html ($articleId, $article_data, $data, $text, $info) {
    $return = "";

    if ($data->is_logged_in()) {
        $data->create_article_view($_SESSION["userId"], $articleId);
        if ($data->check_if_article_liked_by_user($_SESSION["userId"], $articleId)) {
            $liked = " liked";
        } else {
            $liked = "";
        }
    }
    
    if ($data->is_logged_in()) {
        $settings = '<img class="user-settings" src="/forum/assets/img/icon/settings.png"/><script>document.querySelector(".user-settings").addEventListener("click", (e) => {document.querySelector(".main-menu").style.display = "none"; if (document.querySelector(".user-settings-menu").style.display === "") {document.querySelector(".user-settings-menu").style.display = "none"} else {document.querySelector(".user-settings-menu").style.display = "";}})</script>';
        $settings_menu = '<div class="user-settings-menu theme-main-color-2" style="display: none;">';
        if (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($article_data["userId"])) || intval($article_data["userId"]) === intval($_SESSION["userId"])) {
            $settings_menu .= '<div class="edit-btn hover-theme-main-color-1">' . $text->get("user-view-edit") . '</div><script src="/forum/assets/script/edit.js" defer></script>';
        }
        if (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($article_data["userId"])) || ($data->is_moderator_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($article_data["userId"]) && !$data->is_moderator_by_id($article_data["userId"])) || intval($article_data["userId"]) === intval($_SESSION["userId"])) {
            $settings_menu .= '<div class="delete-btn hover-theme-main-color-1">' . $text->get("user-view-delete") . '</div><script src="/forum/assets/script/delete.js"></script>';
        }
        $settings_menu .= '</div>';
    } 
    
    
    if ($data->is_logged_in() && (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($article_data["userId"])) || $_SESSION["userId"] === $article_data["userId"])) {
        $delete_button = '<div class="delete-btn">' . $text->get("article-view-delete") . '</div>
        <script src="/forum/assets/script/delete.js"></script>';
    } else {
        $delete_button = "";
    }
    
    // USE VARIABLE TO REDUCE QUERY AMOUNT
    $try_author_name = $data->get_username_by_id($article_data["userId"]);
    
    if ($try_author_name && $try_author_name !== "") {
        $author = $text->get("article-view-author") . $try_author_name;
    } else {
        $author = $text->get("article-view-author-deleted");
    }
    
    
    if ($data->get_user_by_id($article_data["userId"])["userVerified"] == "1") {
        $verified = '<p class="verified">&#10003</p>';
    } else {
        $verified = "";
    }
    
    if ($info->mobile === true) {
        $return .= '<link rel="stylesheet" href="/forum/assets/style/mobile.article.css">';
        $l1 = '<div class="like-btn ' . $liked . '" onclick="like(event)" el_Id="articleId=' . $article_data["articleId"] . '">' . $text->get("article-view-like") . '</div>';
        $l2 = '';
    } else {
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.main_view_block.css">';
        $return .= '<link rel="stylesheet" href="/forum/assets/style/pc.article.css">';
        $l1 = '';
        $l2 = '<div class="like-btn ' . $liked . '" onclick="like(event)" el_Id="articleId=' . $article_data["articleId"] . '">' . $text->get("article-view-like") . '</div>';
    }

    
    $return .= '
        ' . $l1 . '
        <div class="article-block main-view-block theme-main-color-1 article-background-element">
        ' . $l2 . '
        ' . $settings . '
        ' . $settings_menu . '
        <div class="article-block-entry article-block-title">' . htmlspecialchars($article_data["articleTitle"]) . '</div>' . $verified . '
        <button id="userSubmit" class="theme-main-color-2 submitButton" style="display: none;">Save</button>
        <a class="author-href" u_id="' . $article_data["userId"] . '" id="author-href-' . $article_data["articleId"] . '" href="/forum/?userId=' . $article_data["userId"] . '"><div class="article-block-entry article-block-author">' . htmlspecialchars($author) . '</div></a>
        <div class=" article-block-entry article-block-tags">' . $text->get("article-view-tags") . htmlspecialchars(implode("; ", json_decode($article_data["articleTags"]))) . '</div>
        <div class=" article-block-entry article-block-created">' . $text->get("article-view-created") . $article_data["articleCreated"] . '</div>
    
        <textarea disabled id="article-content" class="article-block-content">' . htmlspecialchars($article_data["articleText"]) . '</textarea>
        <script>document.getElementById("article-content").style.height = (document.getElementById("article-content").scrollHeight + 10) + \'px\';</script>';
    
    
        $return .= get_comment_block($data, $text, "articleId", $articleId);
    
    
    
    $return .= '
    </div>
    ';
    
    return $return;
}
