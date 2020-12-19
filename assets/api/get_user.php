<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($rargs["userId"]) && !isset($rargs["userName"])) {
    exit("Requesterror");
}

if (isset($rargs["userName"]) && !isset($rargs["userId"])) {
    $id = $data->get_user_id_by_name();
} else {
    $id = $rargs["userId"];
}

$user_data = $data->get_user_by_id($id);

unset($user_data["userPassword"]);
unset($user_data["userIntended"]);
unset($user_data["userSettings"]);

if (isset($rargs["transformVerified"])) {
    if ($user_data["userVerified"] == "1") {
        $user_data["userVerified"] = true;
    } else {
        $user_data["userVerified"] = false;
    }
}
if (isset($_GET["transformNull"])) {
    if ($user_data["userPhone"] == "") {
        $user_data["userPhone"] = null;
    }
    if ($user_data["userMail"] == "") {
        $user_data["userMail"] = null;
    }
}

header("Content-Type: application/json");
exit(json_encode($user_data));