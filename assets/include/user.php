<?php

if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    if (isset($_GET["userName"]) && intval($data->get_user_id_by_name($_GET["userName"])) !== intval($_GET["userId"])) {
        header("LOCATION:/forum/?error=requesterror");
        die("Requesterror");
    }
} else {
    $userId = intval($data->get_user_id_by_name($_GET["userName"]));
}

$user_data = $data->get_user_by_id($userId);
if ($user_data === false) {
    header("LOCATION:/forum/?error=notexistentuser");
    die($text->get("user-view-not-found"));
}


if ($data->is_logged_in()) {
    $data->create_user_view($_SESSION["userId"], $userId);
    if ($data->check_if_user_liked_by_user($_SESSION["userId"], $userId)) {
        $liked = " liked";
    } else {
        $liked = "";
    }
}

if ($data->is_logged_in()) {
    $settings = '<img class="user-settings" src="https://img.icons8.com/material-rounded/1024/000000/settings.png"/><script>document.querySelector(".user-settings").addEventListener("click", (e) => {if (document.querySelector(".user-settings-menu").style.display === "") {document.querySelector(".user-settings-menu").style.display = "none"} else {document.querySelector(".user-settings-menu").style.display = "";}})</script>';
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
    echo '<link rel="stylesheet" href="/forum/assets/style/mobile.user.css">';
    $l1 = '<div class="like-btn ' . $liked . '">' . $text->get("user-view-like") . '</div>';
    $l2 = '';
} else {
    echo '<link rel="stylesheet" href="/forum/assets/style/pc.user.css">';
    $l1 = '';
    $l2 = '<div class="like-btn ' . $liked . '">' . $text->get("user-view-like") . '</div>';
}


echo '
' . $l1 . '
<div class="user-block theme-main-color-1">
    ' . $l2 . '
    <script src="/forum/assets/script/like.js"></script>
    ' . $settings . '
    ' . $settings_menu . '
    <div disabled class="theme-main-color-1 user-block-entry user-block-title user-type-' . $user_data["userType"] . '">' . $user_data["userName"] .  '</div> ' . $verified . $locked . '
    <div disabled class="theme-main-color-1 user-block-entry user-block-employment">' . $text->get("user-view-employment") . $user_data["userEmployment"] . '</div>
    <div disabled class="theme-main-color-1 user-block-entry user-block-age">' . $text->get("user-view-age") .  $user_data["userAge"] . '</div>
    <div disabled class="theme-main-color-1 user-block-entry user-block-mail">' . $text->get("user-view-mail") . $user_data["userMail"] . '</div>
    <div disabled class="theme-main-color-1 user-block-entry user-block-phone">' . $text->get("user-view-phone") . $user_data["userPhone"] . '</div>


    <textarea disabled class="user-block-description">' . $user_data["userDescription"] . '</textarea>';

$comments = $data->get_user_comments_by_id($userId);

echo '<div class="comment-section theme-main-color-1">';

echo "<h3 id='loading-comments-info'>" . $text->get("comments-loading") . "</h3>";

if ($data->is_logged_in()) {
    echo '<form class="comment-form comment theme-main-color-1">';
    echo '<input class="comment-title theme-main-color-1" name="title" placeholder="' . $text->get("comments-title") . '">';
    echo '<h3 class="comment-author theme-main-color-1">' . $data->get_username_by_id($_SESSION["userId"]) . '</h3>';
    echo '<input class="comment-text theme-main-color-1" name="text" placeholder="' . $text->get("comments-comment") . '"></input>';
    echo '<input type="submit" name="submit" class="comment-form-submit theme-main-color-1" id="submit-comment" value="' . $text->get("comments-submit") . '">';
    echo '</form>
    <script>var cur_Id = "userId=" + "' . $userId . '";</script>
    <script>var cur_username = "' . $_SESSION["user"] . '";</script>
    <script async defer src="/forum/assets/script/comment.js"></script>
    <div id="js_comments"></div>
    ';
} else {
    echo '<script>var cur_Id = "userId=" + "' . $userId . '";</script>
    <script>var cur_username = false;</script>
    <script async defer src="/forum/assets/script/comment.js"></script>
    <div id="js_comments"></div>';
}



echo '
</div></div>
';