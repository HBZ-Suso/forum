<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();
$data->do_match();

$rargs = array_merge($_GET, $_POST, $_FILES);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if (!isset($rargs["profilePicture"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if ($data->is_logged_in()) {
    if (filesize($_FILES['profilePicture']['tmp_name']) > 200000) {
        $data->create_error("Imagesizeerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Imagesizeerror");
    }

    $verifyimg = getimagesize($_FILES['profilePicture']['tmp_name']);

    $ext = "";
    if ($verifyimg['mime'] !== 'image/png' && $verifyimg['mime'] !== 'image/jpg' && $verifyimg['mime'] !== 'image/jpeg') {
        $data->create_error("Filetypeerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Filetypeerror");
    }
    if ($verifyimg['mime'] === 'image/png') {
        $ext = ".png";
    }
    if ($verifyimg['mime'] === 'image/jpg') {
        $ext = ".jpg";
    }
    if ($verifyimg['mime'] === 'image/jpeg') {
        $ext = ".jpeg";
    }


    $uploaddir = $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/data/profilePictures/";

    $uploadfile = $uploaddir . $_SESSION["userId"] . $ext;
    unlink($uploadfile);


    if (copy($_FILES['profilePicture']['tmp_name'], $uploadfile)) {
        $data->set_user_setting("pPE", $_SESSION["userId"], $ext);
        echo "Success";
    } else {
        $data->create_error("Executionerror",  $_SERVER["SCRIPT_NAME"]);
        exit("Executionerror");
    }
    exit();
} else {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}