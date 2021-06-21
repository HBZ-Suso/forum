<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();

$rargs = array_merge($_GET, $_POST);

if ($data->is_logged_in() && ($data->is_moderator_by_id($_SESSION["userId"]) || $data->is_admin_by_id($_SESSION["userId"]))) {
    if (isset($rargs["articleId"])) {
        $data->toggle_article_pin($rargs["articleId"]);
        echo $data->check_article_pin($rargs["articleId"]);
        exit();
    } else {
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        exit("Requesterror");
    }
} else {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}