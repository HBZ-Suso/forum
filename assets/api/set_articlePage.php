<?php
session_start();
if (!is_numeric($_GET["articlePage"])) {
    exit("Formerror");
}
$_SESSION["articlePage"] = $_GET["articlePage"];
exit($_SESSION["articlePage"]);