<?php 
session_start();

if (isset($_GET["show"])) {
    switch ($_GET["show"]) {
        case "account":
            if (isset($_SESSION["user"])) {
                header("LOCATION:/forum/assets/site/account.php");
                exit();
            } else {
                header("LOCATION:/forum/assets/site/login.php");
                exit();
            }
            break;
    }
}

$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_GET["show"])) {
    switch ($_GET["show"]) {
        case "about":
            include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/about.php";
            break;
    }
}




if (isset($_GET["search"]) || (!isset($_GET["show"]) && !isset($_GET["userId"]) && !isset($_GET["userName"]) && !isset($_GET["articleId"]) && !isset($_GET["articleTitle"]))) {
    if ($info->mobile !== true) {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/refined_search.php";
        if (isset($_GET["search"]) || isset($_GET["rsearch"])) {
            $top = " big-top";
        } else {
            $top = "";
        }
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.findings.css">';
        echo '<div class="block-container' . $top . '">';
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/article_block.php";
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/user_block.php";
        if (isset($_SESSION["userId"])) {
            include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/highlight_block.php";
        }
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/pop_refined_search.html";

        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/about.php";
        echo "</div>";
    } else {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/mobile_search.php";
        echo '<link rel="stylesheet" href="/forum/assets/style/mobile.findings.css">';

        echo '<div class="block-container' . $top . '">';
        if (isset($_SESSION["userId"])) {
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