<?php
session_start();
$_SESSION["highlight"] = $_GET["highlight"];
exit($_SESSION["highlight"]);