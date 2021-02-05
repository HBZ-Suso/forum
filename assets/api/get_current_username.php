<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (isset($_SESSION["userId"])) {
    exit($data->get_user_by_id($_SESSION["userId"])["userName"]);
} else {
    exit("false");
}