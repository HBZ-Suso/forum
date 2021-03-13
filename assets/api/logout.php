<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION["userId"]);
unset($_SESSION["userIp"]);
unset($_SESSION["linkLogged"]);
exit("Succcess");