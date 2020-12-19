<?php

session_start();

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