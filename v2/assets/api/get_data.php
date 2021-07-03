<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

header("Content-Type: application/json");
exit(json_encode($data->get_personal_data()));