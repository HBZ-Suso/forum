<?php

if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION["CSRF-TOKEN"]) {
    unset($_SESSION["user"]);
    unset($_SESSION["userId"]);
    unset($_SESSION["userIp"]);
    unset($_SESSION["linkLogged"]);
    $data->create_error("CSRFerror",  $_SERVER["SCRIPT_NAME"]);
    header("refresh: 1");
    exit("CSRFerror. CSRF-FLAG: PLEASE RELOAD YOUR PAGE!");
}