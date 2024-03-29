<?php 

/*
if (!isset($_SESSION["res_x"]) || !isset($_SESSION["res_y"])) {
    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
    echo '
        <script>
            axios.get("/forum/assets/api/set_resolution.php?res_x=" + window.innerWidth + "&res_y=" + window.innerHeight).then((response) => {window.location.reload();}).catch((error) => {console.debug(error); window.location.reload();});
        </script>
    ';
    exit();
} 
*/




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

if (!isset($_SESSION["CSRF-TOKEN"])) {
    $_SESSION["CSRF-TOKEN"] = bin2hex(random_bytes(10));
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.info.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.mail.php";
$data = new Data();
$data->do_match();
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

$data->add_visit(json_encode($save_reg));

$info = new Info();
$text = new Text($_SESSION["language"]);

if (isset($require_purifier)) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
    $filter = new Filter();
}



if (isset($_SESSION["colorscheme"])) {
    $theme = $_SESSION["colorscheme"];
    if (!isset($_COOKIE["colorscheme"]) || $_COOKIE["colorscheme"] !== $_SESSION["colorscheme"]) {
        setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    }
} else if (isset($_COOKIE["colorscheme"])) {
    if (in_array($_COOKIE["colorscheme"], array("dark", "light"))) {
        $_SESSION["colorscheme"] = $_COOKIE["colorscheme"];
    }
    $theme = $_SESSION["colorscheme"];
} else {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    $theme = $_SESSION["light"];
}

if (!isset($_SESSION["colorscheme"])) {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
}

$mail = new Mail($data, $text);
if (!isset($hide_frame)) {

    echo '
    <!DOCTYPE html>
    <html lang="' . $text->get_language_code_from_name($_SESSION["language"]) . '">
    ';

    echo '
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>HBZ-Forum</title>
        <meta name="description" content="Das offizielle HBZ-Forum | The official HBZ-forum">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
        * {font-family: \'Roboto\', sans-serif;} 
        </style>
    </head>';

    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
    echo 'axios.defaults.headers.common = {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": "' . $_SESSION["CSRF-TOKEN"] . '"
    }';
    echo '<script src="/forum/assets/script/functions.js"></script>';
    echo '<script src="/forum/assets/script/like.js" defer></script>';


    echo "
    <style>
        .script-warning {display: none;}
        @media (scripting: none) {.script-warning {background-color: red;position: fixed;height: 100%;width: 100%;top: 0px;left: 0px; display: block!important; z-index: 6;}}
    </style>";
    echo "<div class='script-warning'>This site is relying on Javascript, please switch to a browser that supports JS or activate it.</div>";
    echo '<script src="/forum/assets/script/include/resolution.js"></script>';



    
    echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/assets/style/scheme-' . $theme . '-file.css"></div>';


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
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/frame.php";

    echo '<script src="/forum/assets/script/language.js"></script>';
    echo '<script src="/forum/assets/script/theme.js"></script>';

    if ($info->mobile !== true) {
        echo '<script src="/forum/assets/script/notifications.js" defer></script>';
        echo '<link rel="stylesheet" href="/forum/assets/style/error_display_style.css"><div id="error-box" style="height: 0px; width: 0px;"></div>';
    }
}

if (isset($show_essentials)) {

    echo '

    <html lang="' . $text->get_language_code_from_name($_SESSION["language"]) . '">

    ';
    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
    echo 'axios.defaults.headers.common = {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": "' . $_SESSION["CSRF-TOKEN"] . '"
    }';
    echo '<script src="/forum/assets/script/like.js" defer></script>';
    echo '<script src="/forum/assets/script/functions.js"></script>';
    echo '<script src="/forum/assets/script/language.js"></script>';
    echo '<script src="/forum/assets/script/theme.js"></script>';


    echo "
    <style>
        .script-warning {display: none;}
        @media (scripting: none) {.script-warning {background-color: red;position: fixed;height: 100%;width: 100%;top: 0px;left: 0px; display: block!important; z-index: 6;}}
    </style>";
    echo "<div class='script-warning'>This site is relying on Javascript, please switch to a browser that supports JS or activate it.</div>";


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

    echo '
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>HBZ-Forum</title>
        <meta name="description" content="Das offizielle HBZ-Forum | The official HBZ-forum">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap");
        * {font-family: \'Roboto\', sans-serif;} 
        </style>
    </head>';

    echo '<div id="theme-box"><link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css"></div>';

    if ($info->mobile !== true) {
        echo '<script src="/forum/assets/script/notifications.js" defer></script>';
        echo '<link rel="stylesheet" href="/forum/assets/style/error_display_style.css"><div id="error-box" style="height: 0px; width: 0px;"></div>';
    }
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


if (!($data->is_logged_in() && ($data->is_moderator_by_id($_SESSION["userId"] || $data->is_admin_by_id($_SESSION["userId"])))) && !strpos(substr($_SERVER["REQUEST_URI"], 0, 20), "forum/assets/api/")) {
    header("LOCATION: /forum/v2/?redirected=" . "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit("<script>window.location = '/forum/v2/?redirected=https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';</script>");
}

if ($data->is_logged_in() && ($data->is_moderator_by_id($_SESSION["userId"] || $data->is_admin_by_id($_SESSION["userId"])))) {
    if (!isset($_COOKIE["wVers"]) && !$_COOKIE["wVers"] === "version-old" && !strpos(substr($_SERVER["REQUEST_URI"], 0, 20), "forum/assets/api/")) {
        header("LOCATION: https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        exit("<script>window.location = '/forum/v2/?redirected=https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';</script>");
    }
}