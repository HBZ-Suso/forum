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

echo "
<style>
    @media (scripting: enabled) {.script-warning {display: none;}}
    @media (scripting: none) {.script-warning {background-color: red;position: fixed;height: 100%;width: 100%;top: 0px;left: 0px;}}
</style>";
echo "<div class='script-warning'>This site is relying on Javascript, please switch to a browser that supports JS or activate it.</div>";



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
    if (isset($_SESSION["theme"])) {
        $theme = $_SESSION["theme"];
        if (!isset($_COOKIE["theme"]) || $_COOKIE["theme"] !== $_SESSION["theme"]) {
            setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
        }
    } else if (isset($_COOKIE["theme"])) {
        if (in_array($_COOKIE["theme"], ["dark", "yellow"])) {
            $_SESSION["theme"] = $_COOKIE["theme"];
        }
        $theme = $_SESSION["theme"];
    } else {
        $_SESSION["theme"] = "dark";
        setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
    }


    echo '<link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css">';
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/loading.html";
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/frame.php";
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