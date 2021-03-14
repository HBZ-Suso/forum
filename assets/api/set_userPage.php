<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!is_numeric($_GET["userPage"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}
$_SESSION["userPage"] = $_GET["userPage"];
exit($_SESSION["userPage"]);