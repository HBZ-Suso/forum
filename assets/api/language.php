<?php

session_start();

if (isset($_POST["language"])) {
    if (in_array($_POST["language"], ["english", "deutsch"])) {
        $_SESSION["language"] = $_POST["language"];
        exit ($_POST["language"]);
    } else {
        exit ("Languagenotfounderror");
    } 
} else {
    exit ("Requesterror");
} 