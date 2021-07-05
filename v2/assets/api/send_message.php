<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
$data = new DataV2();
$data->do_match();
$filter = new Filter();

$rargs = array_merge($_GET, $_POST);


if (!$data->is_logged_in()) {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}


if (!isset($rargs["text"]) || !isset($rargs["userId"])) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if ($data->get_username_by_id($rargs["userId"]) === false) {
    $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
    exit("Requesterror");
}

if ($rargs["userId"] !== $_SESSION["userId"]) {
    switch ($data->get_user_setting("messages", $rargs["userId"])) {
        case "off":
            $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
            exit("Permissionerror");
            break;
        case "followed";
            if (!$data->check_if_user_liked_by_user($rargs["userId"], $_SESSION["userId"])) {
                $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
                exit("Permissionerror");
                break;
            }
            break;
        case "contacted":
            if (count($data->get_chat_by_user_ids($rargs["userId"], $_SESSION["userId"])) < 1) {
                $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
                exit("Permissionerror");
                break;
            }
            break;
        default:
            break;
    }
}



if ($data->get_last_message_by_user_id($_SESSION["userId"], $rargs["userId"])["messageRead"] !== 0) {
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
    
    
    $mail->notify($rargs["userId"], 17, "-|-openchat**" . $_SESSION["userId"] . "-|-", '"' . $data->get_username_by_id($_SESSION["userId"]) . '"{{messaged}}'); 
} 



$data->send_chat_message($_SESSION["userId"], $rargs["userId"], $filter->purify($rargs["text"], 25));
exit("Success");