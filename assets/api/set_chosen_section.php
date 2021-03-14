<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

$_SESSION["section"] = $rargs["section"];
exit($_SESSION["section"]);