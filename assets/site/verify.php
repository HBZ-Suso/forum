<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"]) || !$data->is_admin_by_id($_SESSION["userId"])) {
    header("LOCATION:/forum/?error=permission");
    exit("Permissionerror");
}


if (isset($_GET["userId"])) {
    $data->execute_verify_by_user_id($_GET["userId"]);
    echo "xD";
    if (isset($_GET["refer"])) {
        header("LOCATION: " . $_GET["refer"]);
        exit("Refered back.");
    }
    header("LOCATION: /forum/");
    exit("Put back to main site.");
}

header("LOCATION:/forum/?error=requesterror");
exit("Requesterror");