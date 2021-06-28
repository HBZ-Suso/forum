<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
$data = new DataV2();

$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/include/CSRF.php";

if ($data->is_logged_in() && ($data->is_moderator_by_id($_SESSION["userId"]) || $data->is_admin_by_id($_SESSION["userId"]))) {
    if (isset($rargs["articleId"])) {
        $data->toggle_article_pin($rargs["articleId"]);
        echo $data->check_article_pin($rargs["articleId"]);
        if ($data->check_article_pin($rargs["articleId"]) == "1") {
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
                
                $mail->notify($data->get_article_by_id($rargs["articleId"])["userId"], 16, "/forum/v2/#Article?articleId=" . $rargs["articleId"], '"' . $data->get_article_by_id($rargs["articleId"])["articleTitle"] . '"{{pinned}}');    
            }
        }

        exit();
    } else {
        $data->create_error("Requesterror",  $_SERVER["SCRIPT_NAME"]);
        exit("Requesterror");
    }
} else {
    $data->create_error("Permissionerror",  $_SERVER["SCRIPT_NAME"]);
    exit("Permissionerror");
}