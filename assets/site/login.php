<?php
session_start();
$hide_frame = true;
$show_essentials = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_GET["logout"])) {
    unset($_SESSION["user"]);
    unset($_SESSION["userId"]);
    unset($_SESSION["userIp"]);
    unset($_SESSION["linkLogged"]);
    header("LOCATION: /forum/");
    exit($text->get("login-logged-out"));
}

if (!isset($_GET["form"])) {
    if (isset($_GET["refer"])) {
        $_SESSION["login-refer"] = $_GET["refer"];
    }

    if ($info->mobile !== true) {
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.login.css">';
    } else {
        echo '<link rel="stylesheet" href="/forum/assets/style/mobile.login.css">';
    }

    echo '
    <div class="login-background">
        <form action="/forum/assets/site/login.php?form=true" method="post" class="main-form">
            <a class="signup" href="/forum/assets/site/signup.php">' . $text->get("login-signup") . '</a><br>
            <input type="text" name="username" placeholder="' . $text->get("login-username") . '" class="username">
            <input type="password" name="password" placeholder="' . $text->get("login-pwd") . '" class="password">
            <input type="submit" name="submit" value="submit" class="submit">
        </form>
        
        <div class="home">' . $text->get("create-article-home") . '</div>

    </div>
    <script>
        document.querySelector(".home").addEventListener("click", (e) => {
            window.location = "/forum";
        });
    </script>
    ';
} else {
    if (!isset($_POST["submit"])) {
        header("LOCATION:/forum/assets/site/login.php?error=formerror&errorId=" . $data->create_error("Formerror", $_SERVER["SCRIPT_NAME"]));
        exit("Formerror, please do not change the request data...");
    }
    if (!isset($_POST["username"]) || !isset($_POST["password"])) {
        header("LOCATION:/forum/assets/site/login.php");
        exit();
    }

    if ($data->check_login($_POST["username"], $_POST["password"])) {
        $_SESSION["user"] = $_POST["username"];
        $_SESSION["userId"] = intval($data->get_user_id_by_name($_SESSION["user"]));
        $_SESSION["userIp"] = $info->get_ip();
        header("LOCATION: /forum/");
        exit("Successfully logged in...");
    } else {
        header("LOCATION: /forum/assets/site/login.php?error=loginerror&errorId=" . $data->create_error("Loginerror", $_SERVER["SCRIPT_NAME"]));
        exit("Error whilst login...");
    }


}


