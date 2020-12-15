<?php 
session_start();
$hide_frame = true;
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    exit("Formerror");
}


if (!isset($_POST["change_data"])) {
    exit("Formerror");
}

echo $_POST["change_data"];

$change = json_decode($_POST["change_data"], true);

if (isset($change["userPassword"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPassword", password_hash($change["userPassword"], PASSWORD_DEFAULT));
}
if (isset($change["userDescription"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userDescription", $filter->purify($change["userDescription"], 25));
}
if (isset($change["userAge"])) {
    if (!is_numeric($change["userAge"])) {
        exit("Formerror");
    }
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userAge", $filter->purify($change["userAge"], 25));
}
if (isset($change["userEmployment"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userEmployment", $filter->purify($change["userEmployment"], 25));
}
if (isset($change["userMail"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userMail", $filter->purify($change["userMail"], 25));
}
if (isset($change["userPhone"])) {
    $data->change_user_column_by_id_and_name($_SESSION["userId"], "userPhone", $filter->purify($change["userPhone"], 25));
}



exit();