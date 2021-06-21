<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);

if (!isset($_SESSION["userId"]) || !$data->is_logged_in()) {
    exit("Permissionerror");
}

if (isset($rargs["articleId"])) {
    if ($data->create_article_view($_SESSION["userId"], $rargs["articleId"])) {
        exit();
    } else {
        exit("Creationerror");
    }
} else if (isset($rargs["userId"])) {
    if ($data->create_user_view($_SESSION["userId"], $rargs["userId"])) {
        exit();
    } else {
        exit("Creationerror");
    }
} else {
    exit("Requesterror");
}