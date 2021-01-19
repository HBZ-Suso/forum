<?php 

session_start();

if (isset($_GET["res_x"])) {
    $_SESSION["res_x"] = intval($_GET["res_x"]);
}


if (isset($_GET["res_y"])) {
    $_SESSION["res_y"] = intval($_GET["res_y"]);
}