<?php 
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$data->do_match();
$filter = new Filter();


$rargs = array_merge($_GET, $_POST);


if (
    !isset($_POST["username"]) || 
    !isset($_POST["password"]) || 
    !isset($_POST["password_2"]) ||
    !isset($_POST["code"])
) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}


$code_query = $data->use_code($_POST["code"]);


if ($code_query === false) {
    $data->create_error("Codeerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Codeerror");
}


if ($_POST["password"] !== $_POST["password_2"]) {
    $data->create_error("Passworderror",  $_SERVER["SCRIPT_NAME"]);
    exit("Passworderror");
}

if ($data->create_user($filter->purify($_POST["username"], 25), $_POST["password"], $filter->purify($_POST["age"], 12), $filter->purify($_POST["employment"], 25), $filter->purify($_POST["description"], 50), $filter->purify($_POST["mail"], 25), $filter->purify($_POST["phone"], 15), array("public" => true), $code_query["type"], $code_query["intended"])) {
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
    
    $mail->notify($data->get_user_id_by_name($_POST["username"], 25), 13, "/forum/v2/#Profile?userId=" . $data->get_user_id_by_name($_POST["username"], 25), '{{accountcreated}}');    
    exit("Success");
} else {
    $data->create_error("Creationerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Creationerror");
}
