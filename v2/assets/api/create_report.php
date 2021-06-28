<?php 
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);

if (!isset($rargs["title"]) || !isset($rargs["text"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

$data->create_report($filter->purify($rargs["title"], 50), $filter->purify($rargs["text"], 35));




if ($data->is_logged_in()) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.mail.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
    // Setting languages before including classes because class.text.php needs language on construct
    if (!isset($_SESSION["language"])) {
        if (isset($_COOKIE["language"])) {
            $_SESSION["language"] = $_COOKIE["language"];
        } else {
            $_SESSION["language"] = "english";
        }
    }
    if ($_SESSION["language"] !== $_COOKIE["language"]) {
        setcookie("language", $_SESSION["language"], time() +24*3600*365, "/");
    }
    $text = new Text($_SESSION["language"]);
    $mail = new Mail($data, $text);
    $mail->notify($_SESSION["userId"], 14, "", '{{reportsent}}');    
}

