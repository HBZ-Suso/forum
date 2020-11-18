<?php 
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_GET["show"])) {
    switch ($_GET["show"]) {
        case "account":
            if (isset($_SESSION["user"])) {
                header("LOCATION:/forum/assets/site/account.php");
            } else {
                header("LOCATION:/forum/assets/site/login.php");
            }
            break;
        case "about":
            exit("Not coded yet ;-)");
            break;
    }
}




if (isset($_GET["search"]) || !isset($_GET["show"])) {
    echo '
        <div class="article-block">
            <h1 class="article-block-heading">Articles</h1>';
            
    if (isset($_GET["search"])) {
        $phrase = $_GET["search"];
    } else {
        $phrase = "";
    }

    foreach ($data->search_articles($phrase) as $value) {
        echo '
            <div class="article-block-entry">
                <span class="article-block-entry-title">Title:' . $value["articleTitle"] .'</span>
                <span class="article-block-entry-title">Author:' . $data->get_username_by_id($value["userId"]) .'</span>
                <span class="article-block-entry-title">Views:' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
            </div>
        ';
    }

    echo '</div>
    ';






    echo '
        <div class="user-block">
            <h1 class="user-block-heading">Users</h1>';
            
    if (isset($_GET["search"])) {
        $phrase = $_GET["search"];
    } else {
        $phrase = "";
    }

    foreach ($data->search_users($phrase) as $value) {
        echo '
            <div class="user-block-entry">
                <span class="user-block-entry-title">Name:' . $value["userName"] .'</span>
                <span class="user-block-entry-title">Mail:' . $value["userMail"] .'</span>
                <span class="user-block-entry-title">Views:' . $data->get_article_views_by_user_id($value["userId"]) .'</span>
            </div>
        ';
    }

    echo '</div>
    ';
}