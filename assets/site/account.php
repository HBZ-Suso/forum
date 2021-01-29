<?php 
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (!$data->is_logged_in()) {
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
    <form id="main_form" action="" method="post">
        <div class="flex-container">
            <h1 id="title"><?php echo $user_data["userName"];?></h1>
            <textarea id="userMail" class="theme-main-color-2 user-entry-first"></textarea>
            <textarea id="userPhone" class="theme-main-color-2"></textarea>
            <textarea id="userEmployment" class="theme-main-color-2"></textarea>
            <textarea id="userAge" class="theme-main-color-2"></textarea>
            <textarea id="userIntended" disabled class="theme-main-color-2"><?php echo $user_data["userIntended"];?></textarea>
            <input type="password" id="userNewPassword" class="theme-main-color-2" placeholder="<?php echo $text->get("account-change-password-1"); ?>"></input>
            <input type="password" id="userNewPassword2" class="theme-main-color-2" placeholder="<?php echo $text->get("account-change-password-2"); ?>"></input>
            <input type="submit" id="userChangePassword" class="theme-main-color-2" value="<?php echo $text->get("account-change-password"); ?>">
            <textarea id="userDescription" class="theme-main-color-2 user-entry-last"></textarea>
            <input type="submit" id="userSubmit" value="Save" class="theme-main-color-2">
        </div>

        
    </form>
    <div id="placeholder-id"></div>
</div>




<script src="/forum/assets/script/account.js"></script>

<script>
    document.getElementById("userChangePassword").addEventListener("click", (e) => {
        e.preventDefault();
        let pwd1 = document.getElementById("userNewPassword").value;
        let pwd2 = document.getElementById("userNewPassword2").value;
        if (pwd1 === pwd2 && pwd1 !== "") {
            ajax_request = "change_data=" +  JSON.stringify({"userPassword": pwd1});
            axios
                .post("/forum/assets/api/change_data.php", ajax_request)
                .then((response) => {
                    reload.changed = false;
                    document.getElementById("userChangePassword").style.backgroundColor = "green";
                    document.getElementById("userNewPassword").value = "";
                    document.getElementById("userNewPassword2").value = "";
                    setTimeout(() => {document.getElementById("userChangePassword").style.transition = "0.3s all linear"; document.getElementById("userChangePassword").style.backgroundColor = ""}, 1500);
                })
                .catch((error) => {
                    console.debug(error);
                })
        } else {
            document.getElementById("userChangePassword").style.backgroundColor = "red";
            setTimeout(() => {document.getElementById("userChangePassword").style.transition = "0.3s all linear"; document.getElementById("userChangePassword").style.backgroundColor = "";}, 1000)
        }
    })
</script>