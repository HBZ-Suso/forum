<?php 

if (!isset($_SESSION["res_x"]) || !isset($_SESSION["res_y"])) {
    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
    echo '
        <script>
            axios.get("/forum/assets/api/set_resolution.php?res_x=" + window.innerWidth + "&res_y=" + window.innerHeight).then((response) => {window.location.reload;}).catch((error) => {console.debug(error);});
        </script>
    ';
    exit();
} 



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
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
$data = new Data();
$info = new Info();
$text = new Text($_SESSION["language"]);

if (isset($require_purifier)) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
    $filter = new Filter();
}



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
        <meta name="description" content="Das ofizielle HBZ-Forum | The official HBZ-forum">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>';

    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
    echo '<script src="/forum/assets/script/functions.js"></script>';


    echo "
    <style>
        .script-warning {display: none;}
        @media (scripting: none) {.script-warning {background-color: red;position: fixed;height: 100%;width: 100%;top: 0px;left: 0px; display: block!important; z-index: 6;}}
    </style>";
    echo "<div class='script-warning'>This site is relying on Javascript, please switch to a browser that supports JS or activate it.</div>";
    echo '<script src="/forum/assets/script/include/resolution.js"></script>';

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
        $_SESSION["theme"] = "dark";
        setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
        $theme = "dark";
    }

    echo '<div id="theme-box"><link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css"></div>';
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/loading.html";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/ask_question.html";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/frame.php";

    echo '<script src="/forum/assets/script/language.js"></script>';
    echo '<script src="/forum/assets/script/theme.js"></script>';
}

if (isset($show_essentials)) {

    echo '

    <html lang="' . $text->get_language_code_from_name($_SESSION["language"]) . '">

    ';
    echo '<script src="https://unpkg.com/axios/dist/axios.min.js"></script>';
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
        $_SESSION["theme"] = "dark";
        setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
        $theme = "dark";
    }

    echo '
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>HBZ-Forum</title>
        <meta name="description" content="Das ofizielle HBZ-Forum | The official HBZ-forum">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>';

    echo '<div id="theme-box"><link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css"></div>';
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