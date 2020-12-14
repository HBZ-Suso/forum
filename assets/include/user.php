<?php

if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    if (isset($_GET["userName"]) && intval($data->get_id_by_username($_GET["userName"])) !== intval($_GET["userId"])) {
        header("LOCATION:/forum/?error=requesterror");
        die("Requesterror");
    }
} else {
    $userId = intval($data->get_id_by_username($_GET["userName"]));
}

$user_data = $data->get_user_by_id($userId);
if ($user_data === false) {
    header("LOCATION:/forum/?error=notexistentuser");
    die($text->get("user-view-not-found"));
}


if (isset($_SESSION["userId"])) {
    $data->create_user_view($_SESSION["userId"], $userId);
    if ($data->check_if_user_liked_by_user($_SESSION["userId"], $userId)) {
        $liked = " liked";
    } else {
        $liked = "";
    }
}



if (isset($_SESSION["userId"]) && (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($userId)) || intval($userId) === intval($_SESSION["userId"]))) {
    $delete_button = '<div class="delete-btn">' . $text->get("user-view-delete") . '</div>
    <script src="/forum/assets/script/delete.js"></script>';
} else {
    $delete_button = "";
}

if (isset($_SESSION["userId"]) && $data->is_admin_by_id($_SESSION["userId"])) {
    $verify_button = '<div class="verify-user">' . $text->get("user-view-verify") . '</div>
    <script src="/forum/assets/script/verify.js"></script>';
} else {
    $verify_button = "";
}


if ($user_data["userVerified"] == "1") {
    $verified = '<p class="verified">&#10003</p>';
} else {
    $verified = '<p class="verified" style="display: none;">&#10003</p>';
}



echo '
<link rel="stylesheet" href="/forum/assets/style/pc.user.css">

<div class="user-block theme-main-color-1">
    <div class="like-btn ' . $liked . '">' . $text->get("user-view-like") . '</div>
    <script src="/forum/assets/script/like.js"></script>
    ' . $delete_button . '
    ' . $verify_button . '
    <textarea disabled class="theme-main-color-1 user-block-entry user-block-title user-type-' . $user_data["userType"] . '">' . $user_data["userName"] .  '</textarea> ' . $verified . '
    <textarea disabled class="theme-main-color-1 user-block-entry user-block-employment">' . $text->get("user-view-employment") . $user_data["userEmployment"] . '</textarea>
    <textarea disabled class="theme-main-color-1 user-block-entry user-block-age">' . $text->get("user-view-age") .  $user_data["userAge"] . '</textarea>
    <textarea disabled class="theme-main-color-1 user-block-entry user-block-mail">' . $text->get("user-view-mail") . $user_data["userMail"] . '</textarea>
    <textarea disabled class="theme-main-color-1 user-block-entry user-block-phone">' . $text->get("user-view-phone") . $user_data["userPhone"] . '</textarea>


    <textarea disabled class="user-block-description">' . $user_data["userDescription"] . '</textarea>';

$comments = $data->get_user_comments_by_id($userId);

echo '<div class="comment-section theme-main-color-1">';

echo "<h3 id='loading-comments-info'>" . $text->get("comments-loading") . "</h3>";

if (isset($_SESSION["userId"])) {
    echo '<form class="comment-form comment theme-main-color-1">';
    echo '<input class="comment-title theme-main-color-1" name="title" placeholder="' . $text->get("comments-title") . '">';
    echo '<h3 class="comment-author theme-main-color-1">' . $data->get_username_by_id($_SESSION["userId"]) . '</h3>';
    echo '<input class="comment-text theme-main-color-1" name="text" placeholder="' . $text->get("comments-comment") . '"></input>';
    echo '<input type="submit" name="submit" class="comment-form-submit theme-main-color-1" id="submit-comment">';
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