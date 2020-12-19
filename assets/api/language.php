<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["language"])) {
    if (in_array($rargs["language"], ["english", "deutsch"])) {
        $_SESSION["language"] = $rargs["language"];
        exit ($rargs["language"]);
    } else {
        exit ("Languagenotfounderror");
    } 
} else {
    exit ("Requesterror");
} 