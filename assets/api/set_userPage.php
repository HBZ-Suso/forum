<?php
session_start();
if (!is_numeric($_GET["userPage"])) {
    exit("Formerror");
}
$_SESSION["userPage"] = $_GET["userPage"];
exit($_SESSION["userPage"]);