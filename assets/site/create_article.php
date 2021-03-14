<?php
session_start();

function clean ($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$hide_frame = true;
$require_purifier = true;
$show_essentials = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !$data->is_logged_in()) {
    header("LOCATION:/forum/assets/site/signup.php?error=permissionerror&errorId=" . $data->create_error("Permissionerror", $_SERVER["SCRIPT_NAME"]));
    exit("Permissionerror");
}


if ((abs(time() - $data->get_user_by_id($_SESSION["userId"])["userLastArticle"]) < 60*60*24) && !($data->is_admin_by_id($_SESSION["userId"])) && !($data->is_moderator_by_id($_SESSION["userId"]))) {
    header("LOCATION: /forum/?error=timeouterror&errorId=" . $data->create_error("Timeouterror", $_SERVER["SCRIPT_NAME"]));
    exit("Timeouterror");
}

if (strval($data->get_user_lock($_SESSION["userId"])) === "1") {
    header("LOCATION: /forum/?error=lockederror&errorId=" . $data->create_error("Lockederror", $_SERVER["SCRIPT_NAME"]));
    exit("Lockederror");
}



if (!isset($_POST["form"]) && !isset($_POST["submit"])) { 
    if ($info->mobile !== true) {
        header("LOCATION: /forum/?select=create_article");
        exit("<script>window.location='/forum/?show=create_article';</script>");
    } else {
        echo '<link rel="stylesheet" href="/forum/assets/style/mobile.create_article.css">';
    }

    echo '

    <div class="background">
        <form action="/forum/assets/site/create_article.php?form=true" method="post" class="main-form">
            <input type="text" name="title" placeholder="' . $text->get("create-article-title") . '" class="title">
            <textarea name="text" placeholder="' . $text->get("create-article-text") . '" class="text"></textarea>
            <input type="text" name="tags" placeholder="' . $text->get("create-article-tags") . '" class="tags">
            <input type="submit" name="submit" class="submit" id="submit-article">
        </form>

        <div class="home">' . $text->get("create-article-home") . '</div>
    </div>

    <script>
        document.querySelector(".home").addEventListener("click", (e) => {
            window.location = "/forum";
        });
    </script>
    <script src="/forum/assets/script/create_article.js"></script>
    ';
} else {
    if (
        !isset($_POST["title"]) || 
        !isset($_POST["text"])
        ) {
            header("LOCATION:/forum/assets/site/signup.php?error=formerror&errorId=" . $data->create_error("Formerror", $_SERVER["SCRIPT_NAME"]));
            exit("Formerror");
        }


    $tags = explode("-", clean($filter->purify($_POST["tags"], 15)));
    
    if ($data->create_article($_SESSION["userId"], $filter->purify($_POST["title"], 50), $filter->purify($_POST["text"], 35), $tags)) {
        header("LOCATION: /forum/?articleTitle=" . $filter->purify($_POST["title"], 50));
        exit("<script>window.location='/forum/?articleTitle=" . $filter->purify($_POST["title"], 50) . "'</script>");
    } else {
        exit("error");
    }

}


