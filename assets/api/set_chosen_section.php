<?php
session_start();
$_SESSION["section"] = $_GET["section"];
exit($_SESSION["section"]);