<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (isset($rargs["res_x"])) {
    $_SESSION["res_x"] = intval($rargs["res_x"]);
}


if (isset($rargs["res_y"])) {
    $_SESSION["res_y"] = intval($rargs["res_y"]);
}