<?php

session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["theme"])) {
    if (in_array($rargs["theme"], $info->get_themes())) {
        $_SESSION["theme"] = $rargs["theme"];
        exit ($rargs["theme"]);
    } else {
        $data->create_error("Themenotfounderror",  $_SERVER["SCRIPT_NAME"]);
        exit("Themenotfounderror");
    } 
} else {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
} 