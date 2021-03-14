<?php

if (isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    if (isset($_GET["userName"]) && intval($data->get_user_id_by_name($_GET["userName"])) !== intval($_GET["userId"])) {
        header("LOCATION:/forum/?error=requesterror&errorId=" . $data->create_error("Requesterror", $_SERVER["SCRIPT_NAME"]));
        die("Requesterror");
    }
} else {
    $userId = intval($data->get_user_id_by_name($_GET["userName"]));
}


$user_data = $data->get_user_by_id(intval($userId));
if ($user_data === false) {
    header("LOCATION:/forum/?error=notexistentuser&errorId=" . $data->create_error("Nonexistentusererror", $_SERVER["SCRIPT_NAME"]));
    die($text->get("user-view-not-found"));
}


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/include/user.php";
exit(get_user_html($userId, $user_data, $data, $text, $info));