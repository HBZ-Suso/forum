<?php

function get_user_html ($userId, $user_data, $data, $text, $info) {
    $return = "";

    if ($data->is_logged_in()) {
        $data->create_user_view($_SESSION["userId"], $userId);
        if ($data->check_if_user_liked_by_user($_SESSION["userId"], $userId)) {
            $liked = " liked";
        } else {
            $liked = "";
        }
    }
    
    
    if ($data->is_logged_in()) {
        $settings = '<img class="user-settings" src="https://img.icons8.com/material-rounded/1024/000000/settings.png"/><script>document.querySelector(".user-settings").addEventListener("click", (e) => {document.querySelector(".main-menu").style.display = "none"; if (document.querySelector(".user-settings-menu").style.display === "") {document.querySelector(".user-settings-menu").style.display = "none"} else {document.querySelector(".user-settings-menu").style.display = "";}})</script>';
        $settings_menu = '<div class="user-settings-menu theme-main-color-2" style="display: none;">';
        if ((($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId)) || intval($userId) === intval($_SESSION["userId"]))) {
            $settings_menu .= '<div class="delete-btn hover-theme-main-color-1">' . $text->get("user-view-delete") . '</div><script src="/forum/assets/script/delete.js"></script>';
        }
        if ($data->is_admin_by_id($_SESSION["userId"])) {
            $settings_menu .= '<div class="verify-user hover-theme-main-color-1">' . $text->get("user-view-verify") . '</div><script src="/forum/assets/script/verify.js"></script>';
        }
        if (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId)) || ($data->is_moderator_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId) && !$data->is_moderator_by_id($userId)) || intval($userId) === intval($_SESSION["userId"])) {
            $settings_menu .= '<div class="lock-user hover-theme-main-color-1">' . $text->get("user-view-lock") . '</div><script src="/forum/assets/script/lock.js"></script>';
        }
        $settings_menu .= '</div>';
    } 
    
    
    if (strval($user_data["userVerified"]) == "1") {
        $verified = '<p class="verified">&#10003</p>';
    } else {
        $verified = '<p class="verified" style="display: none;">&#10003</p>';
    }
    
    if (strval($user_data["userLocked"]) == "1") {
        $locked = '<p id="locked" class="locked">✘</p>';
    } else {
        $locked = '<p id="locked" class="locked" style="display: none;">✘</p>';
    }
    
    if ($info->mobile === true) {
        $return .= '<link rel="stylesheet" href="/forum/assets/style/mobile.user.css">';
        $l1 = '<div class="like-btn ' . $liked . '" onclick="like(event)" el_Id="userId=' . $user_data["userId"] . '">' . $text->get("user-view-like") . '</div>';
        $l2 = '';
    } else {
        $return .= '<link rel="stylesheet" href="/forum/assets/style/pc.user.css">';
        $l1 = '';
        $l2 = '<div class="like-btn ' . $liked . '" onclick="like(event)" el_Id="userId=' . $user_data["userId"] . '">' . $text->get("user-view-like") . '</div>';
    }
    
    
    
    $return .= '
    ' . $l1 . '
    <div class="user-block theme-main-color-1 user-background-element">
        ' . $l2 . '
        <script src="/forum/assets/script/like.js"></script>
        ' . $settings . '
        ' . $settings_menu . '
        <div disabled class="user-block-entry user-block-title user-type-' . $user_data["userType"] . '">' . htmlspecialchars($user_data["userName"]) .  '</div> ' . $verified . $locked . '
        <div disabled class="user-block-entry user-block-employment">' . $text->get("user-view-employment") . htmlspecialchars($user_data["userEmployment"]) . '</div>
        <div disabled class="user-block-entry user-block-age">' . $text->get("user-view-age") .  htmlspecialchars($user_data["userAge"]) . '</div>
        <div disabled class="user-block-entry user-block-mail">' . $text->get("user-view-mail") . htmlspecialchars($user_data["userMail"]) . '</div>
        <div disabled class="user-block-entry user-block-phone">' . $text->get("user-view-phone") . htmlspecialchars($user_data["userPhone"]) . '</div>
    
    
        <textarea disabled class="user-block-description">' . htmlspecialchars($user_data["userDescription"]) . '</textarea>';
    
    $comments = $data->get_user_comments_by_id($userId);
    
    $return .= '<div class="comment-section theme-main-color-1" id="comment_section_userId=' . $user_data["userId"] . '">';
    
    $return .= "<h3 id='loading-comments-info'>" . $text->get("comments-loading") . "</h3>";
    
    if ($data->is_logged_in()) {
        $return .= '<form class="comment-form comment theme-main-color-1">';
        $return .= '<input class="comment-title theme-main-color-1" name="title" placeholder="' . $text->get("comments-title") . '">';
        $return .= '<h3 class="comment-author theme-main-color-1">' . $data->get_username_by_id($_SESSION["userId"]) . '</h3>';
        $return .= '<input class="comment-text theme-main-color-1" name="text" placeholder="' . $text->get("comments-comment") . '"></input>';
        $return .= '<input type="submit" name="submit" class="comment-form-submit theme-main-color-1" id="submit-comment" value="' . $text->get("comments-submit") . '">';
        $return .= '</form>
        <script>var cur_Id = "userId=" + "' . $userId . '";</script>
        <script>var cur_username = "' . $_SESSION["user"] . '";</script>
        <script async defer src="/forum/assets/script/comment.js"></script>
        <div id="js_comments"></div>
        ';
    } else {
        $return .= '<script>var cur_Id = "userId=" + "' . $userId . '";</script>
        <script>var cur_username = false;</script>
        <script async defer src="/forum/assets/script/comment.js"></script>
        <div id="js_comments"></div>';
    }
    
    
    
    $return .= '
    </div></div>
    ';

    return $return;
}