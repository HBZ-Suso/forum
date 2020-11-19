<?php 
session_start();
$require_purifier = true;
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




if (isset($_GET["search"]) || (!isset($_GET["show"]) && !isset($_GET["userId"]) && !isset($_GET["userName"]) && !isset($_GET["articleId"]) && !isset($_GET["articleTitle"]))) {
    if ($info->mobile === false) {
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.findings.css">';

        echo '
            <div class="article-block block">
                <h1 class="article-block-heading block-heading">Articles</h1>';
                
        if (isset($_GET["search"])) {
            $phrase = $_GET["search"];
        } else {
            $phrase = "";
        }

        foreach ($data->search_articles($phrase) as $value) {
            echo '
                <div class="article-block-entry block-entry" id="article_' . $value["articleId"] . '">
                    <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . $value["articleTitle"] .'</span><br>
                    <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">Author:</p>' . $data->get_username_by_id($value["userId"]) .'</span>
                    <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Views:</p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span><br>
                </div>

                <script>
                    document.getElementById("article_' . $value["articleId"] . '").addEventListener("click", (e) => {
                        window.location = "/forum/?articleId=' . $value["articleId"] . '&articleTitle=' . $value["articleTitle"] . '";
                    })
                </script>
            ';
        }

        echo '</div>
        ';






        echo '
            <div class="user-block block">
                <h1 class="user-block-heading block-heading">Users</h1>';
                
        if (isset($_GET["search"])) {
            $phrase = $_GET["search"];
        } else {
            $phrase = "";
        }

        foreach ($data->search_users($phrase) as $value) {

            echo '
                <div class="user-block-entry block-entry" user_id="' . $value["userId"] . '" user_name="' . $value["userName"] . '"  id="user_' . $value["userId"] . '">
                    <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . $value["userName"] .'</span><br>
                    <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">Mail:</p>' . $value["userMail"] .'</span>
                    <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Views:</p>' . $data->get_article_views_by_user_id($value["userId"]) .'</span><br>
                </div>

                <script>
                    document.getElementById("user_' . $value["userId"] . '").addEventListener("click", (e) => {
                        window.location = "/forum/?userId=' . $value["userId"] . '&userName=' . $value["userName"] . '";
                    })
                </script>
            ';
        }

        echo '</div>
        ';
    }
} else if (isset($_GET["userId"]) || isset($_GET["userName"])) {
    if (isset($_GET["userId"])) {
        $userId = $_GET["userId"];
        if (isset($_GET["userName"]) && intval($data->get_id_by_username($_GET["userName"])) !== intval($_GET["userId"])) {
            header("LOCATION:/forum/?error=requesterror");
            die("Requesterror");
        }
    } else {
        $userId = intval($data->get_id_by_username($_GET["userName"]));
    }


    if (isset($_SESSION["userId"]) && intval($_SESSION["userId"]) === intval($userId)) {
        header("LOCATION: /forum/?show=account");
        die("Trying to access own account");
    }

    $user_data = $data->get_user_by_id($userId);


    echo '
    <div class="user-block">
        <textarea class="user-block-entry" user-block-title user-type-' . $user_data["userType"] . '">' . $user_data["userName"] . '</span>
        <textarea class="user-block-entry" user-block-title">' . $user_data["userEmployment"] . '</textarea>
        <textarea class="user-block-entry" user-block-title">' . $user_data["userAge"] . '</textarea>
        <textarea class="user-block-entry" user-block-title">' . $user_data["userMail"] . '</textarea>
        <textarea class="user-block-entry" user-block-title">' . $user_data["userPhone"] . '</textarea>
    
    
        <textarea class="user-block-description">
            ' . $user_data["userDescription"] . '
        </textarea>
    </div>
    ';





}