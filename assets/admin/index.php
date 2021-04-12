<?php 
session_start();
$hide_frame = true;
$show_essentials = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if (!$data->is_admin_by_id($_SESSION["userId"])) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}
?>

<link rel="stylesheet" href="/forum/assets/admin/style/index.css">
<link rel="stylesheet" href="/forum/assets/admin/style/table.css">

<div class="admin-main-block">
    <a href="/forum/" class="admin-main-block-heading">Administration HBZ Forum</a>

    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/admin/include/report_block.php"; ?>
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/admin/include/visit_block.php"; ?>
    <?php include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/admin/include/user_block.php"; ?>

    <img alt="<-" id="ar" class="page-arrow page-arrow-right" src="/forum/assets/img/icon/arrow--v1.png"/>
    <img alt="<-" id="al" class="page-arrow page-arrow-left" style="transform: rotate(180deg); " src="/forum/assets/img/icon/arrow--v1.png"/>
</div>

<script src="/forum/assets/admin/script/index.js" async defer></script>
