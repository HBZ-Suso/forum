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


require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.info.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
$data = new Data();
$info = new Info();
$text = new Text($_SESSION["language"]);


if (!isset($hide_frame)) {
    include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/frame.php";
}






$data->create_user("NathanZumbusch", "pwd", 15, "Schüler", "Im a very cool dude!", "n.zumbusch@gmx.de", "000", array("public" => true), "administrator");

$data->create_article(1, "Das Kopfrechenprojekt!", "Ein sehr sehr tolles Projekt!", array("projekt", "enrichment"));





