<?php
session_start();

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.main.php";



if (isset($_GET["site"]) && $_GET["site"] == "profile") {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/profile_page.php";
} else {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/main_page.php";
}

