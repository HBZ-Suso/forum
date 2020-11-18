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

