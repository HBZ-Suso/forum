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
    die("This user does not exist");
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
    $delete_button = '<div class="delete-user">Delete</div>
    <script>document.querySelector(".delete-user").addEventListener("click", (e) => {window.location = "/forum/assets/site/delete.php?userId=' . $userId . '&refer=/forum/";})</script>';
} else {
    $delete_button = "";
}

if (isset($_SESSION["userId"]) && $data->is_admin_by_id($_SESSION["userId"])) {
    $verify_button = '<div class="verify-user">Verify</div>
    <script>document.querySelector(".verify-user").addEventListener("click", (e) => {window.location = "/forum/assets/site/verify.php?userId=' . $userId . '&refer=/forum/?userId=' . $userId . '";})</script>';
} else {
    $verify_button = "";
}


if ($user_data["userVerified"] == "1") {
    $verified = '<p class="verified">&#10003</p>';
} else {
    $verified = "";
}



echo '
<link rel="stylesheet" href="/forum/assets/style/pc.user.css">

<div class="user-block">
    <div class="like-user ' . $liked . '">Like</div>
    ' . $delete_button . '
    ' . $verify_button . '
    <textarea disabled class="user-block-entry user-block-title user-type-' . $user_data["userType"] . '">' . $user_data["userName"] .  '</textarea> ' . $verified . '
    <textarea disabled class="user-block-entry user-block-employment">Employment: ' . $user_data["userEmployment"] . '</textarea>
    <textarea disabled class="user-block-entry user-block-age">Age: ' . $user_data["userAge"] . '</textarea>
    <textarea disabled class="user-block-entry user-block-mail">Mail: ' . $user_data["userMail"] . '</textarea>
    <textarea disabled class="user-block-entry user-block-phone">Phone: ' . $user_data["userPhone"] . '</textarea>


    <textarea disabled class="user-block-description">' . $user_data["userDescription"] . '</textarea>';

$comments = $data->get_user_comments_by_id($userId);

echo '<div class="comment-section">';

if (isset($_SESSION["userId"])) {
    echo '<form class="comment-form comment" method="post" action="/forum/assets/site/comment.php?userId=' . $userId . '">';
    echo '<input class="comment-title" name="title" placeholder="Title">';
    echo '<h3 class="comment-author">' . $data->get_username_by_id($_SESSION["userId"]) . '</h3>';
    echo '<input class="comment-text" name="text" placeholder="Your comment..."></input>';
    echo '<input type="submit" name="submit" class="comment-form-submit">';
    echo '</form>';
}

foreach($comments as $row) {
    echo '<div class="comment">';
    echo '<h3 class="comment-title">' . $row["commentTitle"] . '</h3>';
    echo '<h3 class="comment-author">' . $data->get_username_by_id($row["userId"]) . '</h3>';
    echo '<textarea class="comment-text" disabled>' . $row["commentText"] . '</textarea>';
    if (isset($_SESSION["userId"]) && ($data->is_admin_by_id($_SESSION["userId"]) || intval($row["userId"]) === intval($_SESSION["userId"]))) {
        echo '<button class="comment-delete" id="comment-element-' . intval($row["commentId"] + 42374682734) . '">Delete</button>';
        echo '
        <script>
        document.getElementById("comment-element-' . intval($row["commentId"] + 42374682734) . '").addEventListener("click", (e) => {
            window.location = "/forum/assets/site/delete_comment.php?type=user&userId=' . $userId . '&commentId=' . $row["commentId"] . '";
        });
        </script>';
    }
    echo '</div>';
}

echo '
</div></div>

<script>document.querySelector(".like-user").addEventListener("click", (e) => {window.location = "/forum/assets/site/like.php?targetUserId=' . $userId . '&refer=/forum/?userId=' . $userId . '";})</script>
';