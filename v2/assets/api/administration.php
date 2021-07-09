<?php 
/*
Default class and init stuff
*/
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$data->do_match();
$filter = new Filter();
$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";


if (!($data->is_logged_in() && ($data->is_admin_by_id($_SESSION["userId"])))) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}

if (!isset($rargs["epnt"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

switch ($rargs["epnt"]) {
    case "visitGraph":
        exit(json_encode(get_visits($data)));
        break;
    case "errorGraph":
        exit(json_encode(get_errors($data)));
        break;
    case "reportGraph":
        exit(json_encode(get_reports($data)));
        break;
    case "visitCleanGraph":
        exit(json_encode(get_visits_clean($data)));
        break;
    case "newVisitorsGraph":
        exit(json_encode(get_visits_new($data)));
        break;
    case "createCode":
        exit(json_encode(create_code($data)));
        break;
    case "getCodes":
        exit(json_encode(get_codes($data)));
        break;
    case "deleteCode":
        if (!isset($rargs["codeId"])) {exit();}
        exit(delete_code($data, $rargs["codeId"]));
        break;
    default:
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        exit("Requesterror");
        break;
}





function get_visits ($data)
{
    $visits = $data->get_visit_dates(0, 1000000);
    $visits_per_week = array();
    foreach ($visits as $value) {
        $week_r = date("j. M Y", $value["visitDate"]);
        if (isset($visits_per_week[$week_r])) {
            $visits_per_week[$week_r] += 1;
        } else {
            $visits_per_week[$week_r] = 1;
        }
    }
    header("Content-Type: application/json");
    exit(json_encode($visits_per_week));
}


function get_errors ($data)
{
    $errors = $data->get_error_dates(0, 1000000);
    $errors_per_week = array();
    foreach ($errors as $value) {
        $week_r = date("j. M Y", $value["errorDate"]);
        if (isset($errors_per_week[$week_r])) {
            $errors_per_week[$week_r] += 1;
        } else {
            $errors_per_week[$week_r] = 1;
        }
    }
    header("Content-Type: application/json");
    exit(json_encode($errors_per_week));
}


function get_reports ($data)
{
    $reports = $data->get_report_dates(0, 1000000);
    $reports_per_week = array();
    foreach ($reports as $value) {
        $week_r = date("j. M Y", $value["reportDate"]);
        if (isset($reports_per_week[$week_r])) {
            $reports_per_week[$week_r] += 1;
        } else {
            $reports_per_week[$week_r] = 1;
        }
    }
    header("Content-Type: application/json");
    exit(json_encode($reports_per_week));
}


function get_visits_clean ($data)
{
    $visits = $data->get_visit_dates_clean(0, 1000000);
    $visits_per_week = array();
    foreach ($visits as $value) {
        $week_r = date("j. M Y", $value["visitDate"]);
        if (isset($visits_per_week[$week_r])) {
            $visits_per_week[$week_r] += 1;
        } else {
            $visits_per_week[$week_r] = 1;
        }
    }
    header("Content-Type: application/json");
    exit(json_encode($visits_per_week));
}

function get_visits_new ($data)
{
    $visits = $data->get_visit_dates_new(0, 1000000);
    $visits_per_week = array();
    foreach ($visits as $value) {
        $week_r = date("j. M Y", $value["visitDate"]);
        if (isset($visits_per_week[$week_r])) {
            $visits_per_week[$week_r] += 1;
        } else {
            $visits_per_week[$week_r] = 1;
        }
    }
    header("Content-Type: application/json");
    exit(json_encode($visits_per_week));
}


function create_code ($data) {
    $rargs = array_merge($_GET, $_POST); //Doesnt keep the variable in this scope??? Therefore also $data as argument


    if (!isset($rargs["codeIntended"]) || !isset($rargs["codeType"]) || !in_array($rargs["codeType"], ["user", "moderator"])) {
        exit("Requesterror");
    } else {
        return [$data->create_code($rargs["codeType"], $rargs["codeIntended"])];
    }
}



function get_codes ($data) {
    return $data->get_codes();
}


function delete_code ($data, $codeId) {
    return $data->delete_code($codeId);
}