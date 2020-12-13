<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";





if (isset($_POST["code"])) {
    $value = $text->get($_POST["code"]);
    if ($value === "") {
        exit("CODENOTFOUND");
    } else {
        exit($value);
    }
} else {
    header("Content-Type: application/json");
    exit(json_encode($text->get_all()));
}