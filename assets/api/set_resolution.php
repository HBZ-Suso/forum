<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (isset($_GET["res_x"])) {
    $_SESSION["res_x"] = intval($_GET["res_x"]);
}


if (isset($_GET["res_y"])) {
    $_SESSION["res_y"] = intval($_GET["res_y"]);
}