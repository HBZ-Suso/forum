<?php 
session_start();
$hide_frame = true;
$show_essentials = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
    exit("Permissionerror");
}

if (!$data->is_admin_by_id($_SESSION["userId"])) {
    exit("Permissionerror");
}

if (!isset($rargs["reportId"])) {
    exit();
}

$report_data = $data->get_report_by_id($rargs["reportId"]);
?>

<link rel="stylesheet" href="/forum/assets/admin/style/report_view.css">

<div class="admin-main-block">
    <a href="/forum/" class="admin-main-block-heading">Administration HBZ Forum</a>

    <div class="report-entry report-entry-title"><?php echo $report_data["reportTitle"]; ?></div>
    <div class="report-entry report-entry-id"><?php echo $rargs["reportId"]; ?></div>
    <div class="report-entry report-entry-text"><?php echo $report_data["reportText"]; ?></div>
    <a href="/forum/assets/admin/api/delete_report.php?reportId=<?php echo $rargs["reportId"]; ?>" class="report-delete">Delete</a>
</div>

<script src="/forum/assets/admin/script/index.js" async defer></script>
