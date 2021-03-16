<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/comment_block.php";

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
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.main_view_block.css">';
        $return .= '<link rel="stylesheet" href="/forum/assets/style/pc.user.css">';
        $l1 = '';
        $l2 = '<div class="like-btn ' . $liked . '" onclick="like(event)" el_Id="userId=' . $user_data["userId"] . '">' . $text->get("user-view-like") . '</div>';
    }
    
    
    
    $return .= '
    ' . $l1 . '
    <div class="user-block main-view-block theme-main-color-1 user-background-element">
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
    
    $return .= get_comment_block($data, $text, "userId", $userId);
    
    
    
    $return .= '
    </div>
    ';

    return $return;
}