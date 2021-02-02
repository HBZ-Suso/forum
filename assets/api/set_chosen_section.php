<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

$_SESSION["section"] = $_GET["section"];
exit($_SESSION["section"]);