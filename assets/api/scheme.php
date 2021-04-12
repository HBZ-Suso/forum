<?php

session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["scheme"])) {
    if (in_array($rargs["scheme"], ["dark", "light"])) {
        $_SESSION["colorscheme"] = $rargs["scheme"];
        exit($rargs["scheme"]);
    } else {
        $data->create_error("Schemenotfounderror",  $_SERVER["SCRIPT_NAME"]);
        exit("Schemenotfounderror");
    } 
} else {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
} 