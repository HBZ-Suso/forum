<?php
session_start();

$hide_frame = true;
$require_purifier = true;
$show_essentials = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (!isset($_GET["form"])) {
    if ($info->mobile !== true) {
        echo '<link rel="stylesheet" href="/forum/assets/style/pc.signup.css">';
    } else {
        echo '<link rel="stylesheet" href="/forum/assets/style/mobile.signup.css">';
    }

    echo '

    <div class="login-background">

        <form action="/forum/assets/site/signup.php?form=true" method="post" class="main-form">
            <a class="login" href="/forum/assets/site/login.php">' . $text->get("signup-login") . '</a><br>
            <input type="text" name="username" placeholder="' . $text->get("signup-username") . '" class="username">
            <input type="password" name="password" placeholder="' . $text->get("signup-pwd") . '" class="password">
            <input type="password" name="password_2" placeholder="' . $text->get("signup-pwd-again") . '" class="password password_2">
            <input type="number" min=1 max=114 name="age" placeholder="' . $text->get("signup-age") . '" class="age">
            <input type="text" name="employment" placeholder="' . $text->get("signup-employment") . '" class="employment">
            <textarea name="description" placeholder="' . $text->get("signup-description") . '" class="description"></textarea>
            <input type="text" name="mail" placeholder="' . $text->get("signup-mail") . '" class="mail">
            <input type="text" name="phone" placeholder="' . $text->get("signup-phone") . '" class="phone">
            <input type="text" name="code" placeholder="' . $text->get("signup-code") . '" class="code">
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
    if (
        !isset($_POST["submit"]) || 
        !isset($_POST["username"]) || 
        !isset($_POST["password"]) || 
        !isset($_POST["password_2"]) ||
        !isset($_POST["code"])
        ) {
            header("LOCATION:/forum/assets/site/signup.php?error=formerror&errorId=" . $data->create_error("Formerror", $_SERVER["SCRIPT_NAME"]));
            exit("Formerror");
        }

    $code_query = $data->use_code($_POST["code"]);

    if ($code_query === false) {
        header("LOCATION:/forum/assets/site/signup.php?error=codeerror&errorId=" . $data->create_error("Codeerror", $_SERVER["SCRIPT_NAME"]));
        exit("Codeerror");
    }

    if ($_POST["password"] !== $_POST["password_2"]) {
        header("LOCATION:/forum/assets/site/signup.php?error=passworderror&errorId=" . $data->create_error("Passworderror", $_SERVER["SCRIPT_NAME"]));
        exit("Passworderror");
    }

    if ($data->create_user($filter->purify($_POST["username"], 25), $_POST["password"], $filter->purify($_POST["age"], 12), $filter->purify($_POST["employment"], 25), $filter->purify($_POST["description"], 50), $filter->purify($_POST["mail"], 25), $filter->purify($_POST["phone"], 15), array("public" => true), $code_query["type"], $code_query["intended"])) {
        $mail->notify("createdaccount", $data->get_user_id_by_name($filter->purify($_POST["username"], 25)));
        header("LOCATION:/forum/?success=true");
        exit("Successfully created account...");
    } else {
        header("LOCATION:/forum/assets/site/signup.php?error=creationerror&errorId=" . $data->create_error("Creationerror", $_SERVER["SCRIPT_NAME"]));
        exit("Error whilst trying to create account");
    }


}


