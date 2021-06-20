<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["userId"]) && !isset($rargs["userName"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if (isset($rargs["userName"]) && !isset($rargs["userId"])) {
    $id = $data->get_user_id_by_name();
} else {
    $id = $rargs["userId"];
}

if ($data->get_user_setting("public", $id) === false && !($data->is_logged_in() && (($_SESSION["userId"] === $user_data["userId"]) || $data->is_admin_by_id($_SESSION["userId"]) || $data->is_moderator_by_id($_SESSION["userId"])))) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    die("Permissionerror");
}

$user_data = $data->get_user_by_id($id);


$user_data["userLikes"] = $data->get_user_likes_by_targetUserId($id);
$user_data["articleLikes"] = $data->get_article_likes_by_user_Id($id);
$user_data["userComments"] = $data->get_user_comments_by_targetUserId($id);
$user_data["articleComments"] = count($data->get_article_comments_by_user_id($id));
$user_data["userViews"] = $data->get_user_views_by_targetUserId($id);
$user_data["articleViews"] = $data->get_article_views_by_user_id($id);
$user_data["articles"] = count($data->get_articles_by_user_id($id));
$user_data["color"] = $data->get_user_setting("color", $id);
if (isset($_SESSION["userId"])) {
    $user_data["liked"] = $data->check_if_user_liked_by_user($_SESSION["userId"], $id);
} else {
    $user_data["liked"] = false;
}


unset($user_data["userPassword"]);
unset($user_data["userIntended"]);
unset($user_data["userSettings"]);

if (isset($rargs["transformVerified"]) || isset($rargs["transformBoolean"])) {
    if ($user_data["userVerified"] == "1") {
        $user_data["userVerified"] = true;
    } else {
        $user_data["userVerified"] = false;
    }
}
if (isset($rargs["transformBoolean"])) {
    if ($user_data["userLocked"] == "1") {
        $user_data["userLocked"] = true;
    } else {
        $user_data["userLocked"] = false;
    }
}
if (isset($_GET["transformNull"])) {
    if ($user_data["userPhone"] == "") {
        $user_data["userPhone"] = null;
    }
    if ($user_data["userMail"] == "") {
        $user_data["userMail"] = null;
    }
}



header("Content-Type: application/json");
exit(json_encode($user_data));