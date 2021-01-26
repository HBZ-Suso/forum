<?php
session_start();
$_SESSION["userPage"] = $_GET["userPage"];
exit($_SESSION["userPage"]);