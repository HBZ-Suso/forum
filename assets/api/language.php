<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["language"])) {
    if (in_array($rargs["language"], $info->get_languages())) {
        if ($_SESSION["language"] !== $rargs["language"]) {
            $_SESSION["language"] = $rargs["language"];
            exit($rargs["language"]);
        } else {
            $data->create_error("Alreadyselectederror",  $_SERVER["SCRIPT_NAME"]);
            exit("alreadyselectederror");
        }
    } else {
        $data->create_error("Languagenotfounderror",  $_SERVER["SCRIPT_NAME"]);
        exit("Languagenotfounderror");
    } 
} else {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
} 