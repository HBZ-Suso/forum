<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["linkauth"])) {
    $data->create_error("Formerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Formerror");
}

if ($data->check_linkauth($rargs["linkauth"])) {
    exit("Valid");
} else {
    exit("Invalid");
}
