<?php
session_start();
if (!is_numeric($_GET["highlightPage"])) {
    exit("Formerror");
}
$_SESSION["highlightPage"] = $_GET["highlightPage"];
exit($_SESSION["highlightPage"]);