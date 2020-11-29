<?php
session_start();

$hide_frame = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
    header("LOCATION:/forum/assets/site/signup.php?error=permissionerror");
    exit("Permissionerror");
}

if (!isset($_GET["type"]) || !isset($_GET["commentId"])) {
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


if (isset($_GET["articleId"])) {
    $get = '?articleId=' . $_GET["articleId"] . "&error=permissionerror";
} else if (isset($_GET["userId"])) {
    $get = '?userId=' . $_GET["userId"] . "&error=permissionerror";
} else {
    $get = "?error=permissionerror";
}

if ($_GET["type"] === "article") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_article_comment_by_id($_GET["commentId"])["userId"] !== $_SESSION["userId"])) {
        header("LOCATION:/forum/" . $get);
        exit("Permissionerror");
    }

    $data->delete_article_comment_by_id($_GET["commentId"]);
} else if ($_GET["type"] === "user") {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && ($data->get_user_comment_by_id($_GET["commentId"])["userId"] !== $_SESSION["userId"])) {
        header("LOCATION:/forum/" . $get);
        exit("Permissionerror");
    }
    $data->delete_user_comment_by_id($_GET["commentId"]);
}


if (isset($_GET["articleId"])) {
    $get = '?articleId=' . $_GET["articleId"];
} else if (isset($_GET["userId"])) {
    $get = '?userId=' . $_GET["userId"];
} else {
    $get = "";
}

header("LOCATION:/forum/" . $get);
exit("Successfully removed comment....");