<?php
session_start();
$_SESSION["articlePage"] = $_GET["articlePage"];
exit($_SESSION["articlePage"]);