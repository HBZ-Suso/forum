<?php
session_start();

$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (!isset($_GET["form"])) {
    echo '
    <link rel="stylesheet" href="/forum/assets/style/signup.css">

    <div class="login-background">

        <form action="/forum/assets/site/signup.php?form=true" method="post" class="main-form">
            <a class="login" href="/forum/assets/site/login.php">To Login</a><br>
            <input type="text" name="username" placeholder="Your username" class="username">
            <input type="password" name="password" placeholder="Your Password" class="password">
            <input type="password" name="password_2" placeholder="Again, to be sure" class="password password_2">
            <input type="number" min=1 max=114 name="age" placeholder="Your Age" class="age">
            <input type="text" name="employment" placeholder="Your Employment" class="employment">
            <textarea name="description" placeholder="Your Description" class="description"></textarea>
            <input type="text" name="mail" placeholder="Your Mail" class="mail">
            <input type="text" name="phone" placeholder="Your Phone Number" class="phone">
            <input type="text" name="code" placeholder="Your Code" class="code">
            <input type="submit" name="submit" value="submit" class="submit">
        </form>

        <div class="home">Home</div>

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
        !isset($_POST["age"]) ||
        !isset($_POST["employment"]) ||
        !isset($_POST["description"]) ||
        !isset($_POST["mail"]) ||
        !isset($_POST["phone"]) ||
        !isset($_POST["code"])
        ) {
            header("LOCATION:/forum/assets/site/signup.php?error=formerror");
            exit("Formerror");
        }

    $code_query = $data->use_code($_POST["code"]);

    if ($code_query === false) {
        header("LOCATION:/forum/assets/site/signup.php?error=codeerror");
        exit("Codeerror");
    }

    if ($_POST["password"] !== $_POST["password_2"]) {
        header("LOCATION:/forum/assets/site/signup.php?error=passworderror");
        exit("Passworderror");
    }

    if ($data->create_user($filter->purify($_POST["username"], 25), $_POST["password"], $filter->purify($_POST["age"], 12), $filter->purify($_POST["employment"], 25), $filter->purify($_POST["description"], 50), $filter->purify($_POST["mail"], 25), $filter->purify($_POST["phone"], 15), array("public" => true), $code_query["type"], $code_query["intended"])) {
        header("LOCATION:/forum/");
        exit("Successfully created account...");
    } else {
        header("LOCATION:/forum/assets/site/signup.php?error=creationerror");
        exit("Error whilst trying to create account");
    }


}


