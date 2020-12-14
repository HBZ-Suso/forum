<?php

session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_POST["theme"])) {
    if (in_array($_POST["theme"], $info->get_themes())) {
        $_SESSION["theme"] = $_POST["theme"];
        exit ($_POST["theme"]);
    } else {
        exit ("Themenotfounderror");
    } 
} else {
    exit ("Requesterror");
} 