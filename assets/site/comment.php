<?php
session_start();

$hide_frame = true;
$require_purifier = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
    header("LOCATION:/forum/assets/site/signup.php?error=permissionerror");
    exit("Permissionerror");
}


if (!(isset($_GET["articleId"]) || isset($_GET["userId"])) || !isset($_POST["title"]) || !isset($_POST["text"])) {
    if (isset($_GET["articleId"])) {
        $get = '?articleId=' . $_GET["articleId"] . "&error=formerror";
    } else if (isset($_GET["userId"])) {
        $get = '?userId=' . $_GET["userId"] . "&error=formerror";
    } else {
        $get = "?error=formerror";
    }
    header("LOCATION:/forum/" . $get);
    exit("Formerror");
}

if ((abs(time() - $data->get_user_by_id($_SESSION["userId"])["userLastComment"]) < 60) && !($data->is_admin_by_id($_SESSION["userId"]))) {
    if (isset($_GET["articleId"])) {
        $get = '?articleId=' . $_GET["articleId"] . "&error=timeouterror";
    } else if (isset($_GET["userId"])) {
        $get = '?userId=' . $_GET["userId"] . "&error=timeouterror";
    } else {
        $get = "?error=timeouterror";
    }
    header("LOCATION: /forum/" . $get);
    exit("Timeouterror");
}

if (isset($_GET["articleId"])) {
    $data->create_article_comment($_SESSION["userId"], $_GET["articleId"], $filter->purify($_POST["title"], 25), $filter->purify($_POST["text"], 20));
} else if (isset($_GET["userId"])) {
    $data->create_user_comment($_SESSION["userId"], $_GET["userId"], $filter->purify($_POST["title"], 25), $filter->purify($_POST["text"], 20));
}

$data->set_comment_timeout_by_id($_SESSION["userId"]);


if (isset($_GET["articleId"])) {
    $get = '?articleId=' . $_GET["articleId"];
} else if (isset($_GET["userId"])) {
    $get = '?userId=' . $_GET["userId"];
} else {
    $get = "";
}

header("LOCATION:/forum/" . $get);
exit("Successfully added comment....");