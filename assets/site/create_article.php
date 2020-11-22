<?php
session_start();

function clean ($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$hide_frame = true;
$require_purifier = true;

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
    header("LOCATION:/forum/assets/site/signup.php?error=permissionerror");
    exit("Permissionerror");
}


if ((abs(time() - $data->get_user_by_id($_SESSION["userId"])["userLastArticle"]) < 60*32) && !($data->is_admin_by_id($_SESSION["userId"]))) {
    header("LOCATION: /forum/?error=timeouterror");
    exit("Timeouterror");
}

if (!isset($_GET["form"])) { 
    echo '
    <link rel="stylesheet" href="/forum/assets/style/form.css">
    <form action="/forum/assets/site/create_article.php?form=true" method="post" class="main-form">
        <input type="text" name="title" placeholder="Title" class="title">
        <textarea name="text" placeholder="Text" class="text" style="height: 45vh;"></textarea>
        <input type="text" name="tags" placeholder="Tags (Seperated by whitespace)" class="tags">
        <input type="submit" name="submit" class="submit">
    </form>

    <div class="home">Home</div>

    <script>
        document.querySelector(".home").addEventListener("click", (e) => {
            window.location = "/forum";
        });
    </script>
    ';
} else {
    if (
        !isset($_POST["submit"]) || 
        !isset($_POST["title"]) || 
        !isset($_POST["tags"]) || 
        !isset($_POST["text"])
        ) {
            header("LOCATION:/forum/assets/site/signup.php?error=formerror");
            exit("Formerror");
        }


    $tags = explode("-", clean($filter->purify($_POST["tags"], 15)));
    
    if ($data->create_article($_SESSION["userId"], $filter->purify($_POST["title"], 50), $filter->purify($_POST["text"], 35), $tags)) {
        header("LOCATION: /forum/");
        exit("Successfully created article...");
    } else {
        header("LOCATION:/forum/assets/site/signup.php?error=creationerror");
        exit("Error whilst trying to create article");
    }


}


