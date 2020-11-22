<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    header("LOCATION:/forum/?error=permission");
    exit("Permissionerror");
}


if (isset($_GET["userId"])) {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && !$_SESSION["userId"] === $_GET["userId"]) {
        header("LOCATION:/forum/?error=permission");
        exit("Permissionerror");
    }

    if (!isset($_GET["sure"])) {
        echo '<a href="/forum/assets/site/delete.php?sure=true&userId=' . $_GET["userId"] . '">Sure!</a>';
        echo '<a href="/forum/">No!</a>';
        exit();
    }

    if (!$data->is_admin_by_id($_GET["userId"])) {
        $data->delete_user_by_id($_GET["userId"]);;
        header("LOCATION:/forum/");
        exit("Successfully deleted user...");
    }
} else if (isset($_GET["articleId"])) {
    if (!$data->is_admin_by_id($_SESSION["userId"]) && !$_SESSION["userId"] === $data->get_article_by_id($_GET["articleId"])["userId"]) {
        header("LOCATION:/forum/?error=permission");
        exit("Permissionerror");
    }

    if (!isset($_GET["sure"])) {
        echo '<a href="/forum/assets/site/delete.php?sure=true&articleId=' . $_GET["articleId"] . '">Sure!</a>';
        echo '<a href="/forum/">No!</a>';
        exit();
    }

    $data->delete_article_by_id($_GET["articleId"]);;
    header("LOCATION:/forum/");
    exit("Successfully deleted article...");
}

header("LOCATION:/forum/?error=requesterror");
exit("Requesterror");