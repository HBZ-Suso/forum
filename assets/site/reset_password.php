<?php 
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

exit("DEPRECATED");


if (!isset($rargs["username"])) {
    header("LOCATION:/forum/?error=Requesterror&errorId=" . $data->create_error("Requesterror", $_SERVER["SCRIPT_NAME"]));
    exit("Requesterror");
}

$mail->send_mail("linked", $data->get_user_id_by_name($rargs["username"]));



echo '
<div class="reset_block">

    ' . $text->get("reset-block-text") . '

</div>
<style>
    body {
        background-color: gray;
    }

    .reset_block {
        background-color: lightblue;
        width: 70%;
        max-width: 400px;
        position: absolute;
        top: 0%;
        height: min-content;
        left: 0%;
        margin: auto;
        border-bottom-right-radius: 5px;
        padding: 10px;
    }
</style>
';