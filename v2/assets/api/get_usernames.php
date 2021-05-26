<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();

$rargs = array_merge($_GET, $_POST);

$users = $data->get_usernames();
header("Content-Type: application/json");
exit(json_encode($users));