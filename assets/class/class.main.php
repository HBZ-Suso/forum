<?php 

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.info.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";
$data = new Data();
$info = new Info();

include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/frame.php";




/*
$data->create_user("NathanZumbusch", "pwd", 15, "Schüler", "Im a very cool dude!", "n.zumbusch@gmx.de", "000", array("public" => true));

$data->create_article(1, "Das Kopfrechenprojekt!", "Ein sehr sehr tolles Projekt!", array("projekt", "enrichment"));
*/