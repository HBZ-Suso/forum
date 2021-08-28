<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$data->do_match();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!isset($_SESSION["userId"]) || !$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if ((abs(time() - intval($data->get_last_article_by_user_id($_SESSION["userId"]))) < 60*60*24) && !($data->is_admin_by_id($_SESSION["userId"])) && !($data->is_moderator_by_id($_SESSION["userId"]))) {
    $data->create_error("Timeouterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Timeouterror");
}

if (strval($data->get_user_lock($_SESSION["userId"])) === "1") {
    $data->create_error("Lockederror",  $_SERVER["SCRIPT_NAME"]);
    exit("Lockederror");
}

if (!isset($rargs["title"]) || !isset($rargs["text"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

function clean ($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$tags = explode(",", clean($filter->purify($rargs["tags"], 15)));

if (isset($rargs["category"])) {
    if (in_array($rargs["category"], ["Home", "About", "Discussion", "Projects", "Help"])) {
        $category = $rargs["category"];
    } else {
        $category = "Home";
    }
} else {
    $category = "Home";
}

$cmd_output = $data->create_article($_SESSION["userId"], $filter->purify($rargs["title"], 50), $filter->purify($rargs["text"], 35), $tags, $category);

if ($cmd_output !== false) {
    $return_data = array();
    $return_data["articleId"] = $cmd_output;
    $article_data = $data->get_article_by_id($return_data["articleId"]);
    array_merge($return_data, ["articleTitle" => $article_data["articleTitle"], "userId" => $article_data["userId"],"userName" => $data->get_username_by_id($article_data["userId"]), "articleCreated" => $article_data["articleCreated"]] ,["articleViews" => $data->get_article_views_by_article_id($cmd_output), "articleComments" => $data->get_article_comments_by_id($cmd_output), "articleLikes" => $data->get_article_likes_by_article_id($cmd_output)]);
    


    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.mail.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
    // Setting languages before including classes because class.text.php needs language on construct
    if (!isset($_SESSION["language"])) {
        if (isset($_COOKIE["language"])) {
            $_SESSION["language"] = $_COOKIE["language"];
        } else {
            $_SESSION["language"] = "english";
        }
    }
    if ($_SESSION["language"] !== $_COOKIE["language"]) {
        setcookie("language", $_SESSION["language"], time() +24*3600*365, "/");
    }
    $text = new Text($_SESSION["language"]);
    $mail = new Mail($data, $text);
    $mail->notify($_SESSION["userId"], 11, "/forum/v2/#Article?articleId=" . $return_data["articleId"], '{{publishedarticle1}} "' . $return_data["articleTitle"] . '" {{publishedarticle2}}');


    
    header("Content-Type: application/json");
    exit(json_encode($return_data));
} else {
    $data->create_error("Creationerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Creationerror");
}