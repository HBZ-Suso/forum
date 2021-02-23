<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

$data->delete_report_by_id($rargs["reportId"]);

header("LOCATION: /forum/assets/admin/");