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

$s_mobile = "pc.";

if ($info->mobile === true) {
    $s_mobile = "mobile.";
}

?>

<link rel="stylesheet" href="/forum/assets/style/<?php echo $s_mobile; ?>account.css">

<div class="window theme-main-color-1">
    <form id="main_form" action="/forum/assets/site/change_data.php" method="post">
        <div class="flex-container">
            <h1 id="title"><?php echo $user_data["userName"];?></h1>
            <textarea id="userMail" class="theme-main-color-2 user-entry-first"></textarea>
            <textarea id="userPhone" class="theme-main-color-2"></textarea>
            <textarea id="userEmployment" class="theme-main-color-2"></textarea>
            <textarea id="userAge" class="theme-main-color-2"></textarea>
            <textarea id="userIntended" disabled class="theme-main-color-2"><?php echo $user_data["userIntended"];?></textarea>
            <textarea id="userDescription" class="theme-main-color-2 user-entry-last"></textarea>
            <input type="submit" id="userSubmit" value="Save" class="theme-main-color-2">
        </div>

        
    </form>
    <div id="placeholder-id"></div>
</div>




<script src="/forum/assets/script/account.js"></script>

