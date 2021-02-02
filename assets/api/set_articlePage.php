<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!is_numeric($_GET["articlePage"])) {
    exit("Formerror");
}
$_SESSION["articlePage"] = $_GET["articlePage"];
exit($_SESSION["articlePage"]);