<?php

session_start();

if (isset($_POST["theme"])) {
    if (in_array($_POST["theme"], ["dark", "melancholic", "retro", "yellow"])) {
        $_SESSION["theme"] = $_POST["theme"];
        exit ($_POST["theme"]);
    } else {
        exit ("Themenotfounderror");
    } 
} else {
    exit ("Requesterror");
} 