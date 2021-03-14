<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($rargs["search"])) {
    $phrase = $rargs["search"];
} else {
    $phrase = "";
}

if (isset($rargs["max"]) && $rargs["max"] < 1000) {
    $max = $rargs["max"];
} else if (isset($rargs["max"]) && $rargs["max"] >= 1000) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
} else {
    $max = 100;
}

$user_data = $data->search_users($phrase, $max);

foreach($user_data as $index => $element) {
    unset($element["userIntended"]);
    unset($element["userSettings"]);
    unset($element["userDescription"]);
    unset($element["userPassword"]);
    if (isset($rargs["transformVerified"])) {
        if ($element["userVerified"] == "1") {
            $element["userVerified"] = true;
        } else {
            $element["userVerified"] = false;
        }
    }
    if (isset($rargs["transformNull"])) {
        if ($element["userPhone"] === "") {
            $element["userPhone"] = null;
        }
        if ($element["userMail"] === "") {
            $element["userMail"] = null;
        }
    }
    $user_data[$index] = $element;
}

header("Content-Type: application/json");
exit(json_encode($user_data));