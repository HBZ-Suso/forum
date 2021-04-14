<?php 


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

$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.info.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.mail.php";
$data = new DataV2();
if (isset($_SESSION["userId"])) {
    $user_v_v = $_SESSION["userId"];
} else {
    $user_v_v = "false";
}

$save_reg = $rargs;
if (isset($save_reg["password"])) {
    $save_reg["password"] = "blurred";
}
if (isset($save_reg["password_2"])) {
    $save_reg["password_2"] = "blurred";
}
$data->add_visit($user_v_v, $_SERVER['REMOTE_ADDR'], json_encode($save_reg));

$info = new Info();
$text = new Text($_SESSION["language"]);
$mail = new Mail($data, $text);

if (isset($require_purifier)) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
    $filter = new Filter();
}



if (isset($_SESSION["colorscheme"])) {
    $scheme = $_SESSION["colorscheme"];
    if (!isset($_COOKIE["colorscheme"]) || $_COOKIE["colorscheme"] !== $_SESSION["colorscheme"]) {
        setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    }
} else if (isset($_COOKIE["colorscheme"])) {
    if (in_array($_COOKIE["colorscheme"], array("dark", "light"))) {
        $_SESSION["colorscheme"] = $_COOKIE["colorscheme"];
    }
    $scheme = $_SESSION["colorscheme"];
} else {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    $scheme = $_SESSION["light"];
}

if (!isset($_SESSION["colorscheme"])) {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    $scheme = "light";
}

echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/assets/style/scheme-' . $scheme . '-file.css"></div>';
echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/v2/assets/style/colors.css"></div>';
echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>';
echo '<script src="/forum/assets/script/functions.js"></script>';
echo '<script src="/forum/v2/assets/script/hashmanagement.js"></script>';
echo '<script src="/forum/v2/assets/script/login.js"></script>';
echo '<script src="/forum/v2/assets/script/settings.js"></script>';
echo '<script src="/forum/v2/assets/script/settings_functions.js"></script>';

if ($data->is_logged_in()) {
    echo "<script>var logged_in = true;</script>";
} else {
    echo "<script>var logged_in = false;</script>";
}

if (isset($_SESSION["theme"])) {
    $theme = $_SESSION["theme"];
    if (!isset($_COOKIE["theme"]) || $_COOKIE["theme"] !== $_SESSION["theme"]) {
        setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
    }
} else if (isset($_COOKIE["theme"])) {
    if (in_array($_COOKIE["theme"], $info->get_themes())) {
        $_SESSION["theme"] = $_COOKIE["theme"];
    }
    $theme = $_SESSION["theme"];
} else {
    $_SESSION["theme"] = "aqua";
    setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
    $theme = "aqua";
}

echo '<div id="theme-box"><link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css"></div>';


include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/loading.html";
include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/ask_question.html";
if (!isset($_COOKIE["policy-agreed"]) || $_COOKIE["policy-agreed"] !== "true") {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/policy_popup.php";
}

if (isset($_SESSION["user"]) || isset($_SESSION["userId"])) {
    if (!isset($_SESSION["userIp"]) || $_SESSION["userIp"] !== $info->get_ip()) {
        unset($_SESSION["user"]);
        unset($_SESSION["userId"]);
        unset($_SESSION["userIp"]);
        header("LOCATION: /forum/?forced_logout=differentIp");
        exit("As your ip changed, you were logged out.");
    }
}