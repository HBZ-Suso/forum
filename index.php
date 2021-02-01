<?php 
session_start();

$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_GET["show"])) {
    switch ($_GET["show"]) {
        case "account":
            if (isset($_SESSION["user"])) {
                header("LOCATION:/forum/assets/site/account.php");
                exit("<script>window.location='/forum/assets/site/account.php';</script>");
            } else {
                header("LOCATION:/forum/assets/site/login.php");
                exit("<script>window.location='/forum/assets/site/login.php';</script>");
            }
            break;
        case "about":
            if ($info->mobile !== true) {
                header("LOCATION:/forum?select=about");
                exit("<script>window.location='/forum?select=about';</script>");
            } else {
                include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/about.php";
            }
            break;
    }
}

if (isset($_GET["search"]) || isset($_GET["rsearch"]) || (!isset($_GET["show"]) && !isset($_GET["userId"]) && !isset($_GET["userName"]) && !isset($_GET["articleId"]) && !isset($_GET["articleTitle"]))) {
    $search = "";
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
    }
    if (isset($_GET["rsearch"])) {
        $search = $_GET["rsearch"];
    }
    if ($_SESSION["last_search"] !== $search)  {
        $_SESSION["articlePage"] = 0;
        $_SESSION["userPage"] = 0;
        $_SESSION["highlightPage"] = 0;
    }
    $_SESSION["last_search"] = $search;
    
    if ($info->mobile !== true) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/refined_search.php";
        if (isset($_GET["rsearch"])) {
            $top = " big-top";
        } else {
            $top = "";
        }
        echo '<script src="/forum/assets/script/findings.js" defer></script>';
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.findings.css">';
        echo '<div class="block-container' . $top . '">';
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/choose.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/overview_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/settings_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/article_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/user_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/about_block.php";
        if ($data->is_logged_in()) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/highlight_block.php";
            include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/create_article_block.php";
        }
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/pop_refined_search.html";
        echo "</div>";
    } else {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/mobile_search.php";
        echo '<link rel="stylesheet" href="/forum/assets/style/mobile.findings.css">';

        echo '<div class="block-container' . $top . '">';
        if ($data->is_logged_in()) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/highlight_block.php";
        }
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/article_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/user_block.php";

        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/about.php";
        echo "</div>";
    }
} else if (isset($_GET["userId"]) || isset($_GET["userName"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/user.php";
} else if (isset($_GET["articleId"]) || isset($_GET["articleTitle"])) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/article.php";
}