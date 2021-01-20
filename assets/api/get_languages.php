<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

header("Content-Type: application/json");
exit(json_encode($info->get_languages()));