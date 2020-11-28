<?php 
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!isset($_SESSION["userId"])) {
    header("LOCATION:/forum/?form=permissionerror");
    exit("Formerror");
} 

$userId = $_SESSION["userId"];
$user_data = $data->get_user_by_id($userId);
$cleaned_user_data = [
    "userName" => $user_data["userName"],
    "userDescription" => $user_data["userDescription"],
    "userMail" => $user_data["userMail"],
    "userPhone" => $user_data["userPhone"],
    "userEmployment" => $user_data["userEmployment"],
    "userAge" => $user_data["userAge"],
    "userIntended" => $user_data["userIntended"],
    "userType" => $user_data["userType"]
];

echo '
    <script>var user_data = ' . json_encode($cleaned_user_data) . '</script>
';

if (isset($_GET["selected"])) {
    echo '<script>var selected = "' . $_GET["selected"] . '";</script>';
}
?>

<link rel="stylesheet" href="/forum/assets/style/account.css">

<div class="window">
    <form id="main_form" action="/forum/assets/site/change_data.php" method="post">
        <div class="flex-container">
            <h1 id="Title"><?php echo $user_data["userName"];?></h1>
            <textarea id="userMail"></textarea>
            <textarea id="userPhone"></textarea>
            <textarea id="userEmployment"></textarea>
            <textarea id="userAge"></textarea>
            <textarea id="userIntended" disabled><?php echo $user_data["userIntended"];?></textarea>
            <textarea id="userDescription"></textarea>
        </div>


        <input style="display: none;" name="change_data" id="change_data" type="text">

        <input type="submit" id="userSubmit" value="Save">
    </form>
</div>
<span id="counter" class="counter">20</span>
<script src="/forum/assets/script/account.js"></script>

