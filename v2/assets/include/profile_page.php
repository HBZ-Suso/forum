<?php 
if (!isset($_GET["userId"]) || !isset($_GET["site"]) || $_GET["site"] !== "profile") {
    exit("Error whilst trying to load in content. Are the request parameters set correctly?");
}

$user_data = $data->get_user_by_id($_GET["userId"]);
?>
<div class="profile-container">
    <div id="profile-userId" style="display: none;"><?php echo $user_data["userId"];?></div>
    <div class="profile-innerContainer">
        <div class="profile-left-column profile-side-column">
            <div class="articleViews"></div>
            <div class="articleLikes"></div>
            <div class="articleComments"></div>
            <div class="userViews"></div>
            <div class="userLikes"></div>
            <div class="userComments"></div>
        </div>

        <div class="profile-middle-column">
            <div class="profile-image">
                <img src="/forum/assets/img/icon/user.svg" class="author-profile-color-overlay-<?php echo $data->get_user_setting("color", $_GET["userId"]);?>">
            </div>
            <div class="profile-username profile-user-type-<?php echo $user_data["userType"];?>"><?php echo $user_data["userName"];?></div>
            <div class="profile-employment"><?php echo $user_data["userEmployment"];?></div>
            <div class="profile-age"><?php echo $user_data["userAge"];?> years old</div>
            <textarea class="profile-description" disabled><?php echo $user_data["userDescription"];?></textarea>

            <p class="profile-click-tip"><?php echo $text->get("v2-profile-click-here-tip") ?></p>

            <div class="profile-middle-column-click-barrier"></div>
        </div>

        <div class="profile-right-column profile-side-column">
            <div class="userCreated"></div>
            <div class="articles"></div>
            <div class="userEmail"><?php echo $text->get("v2-profile-email-heading") ?><?php echo $user_data["userMail"];?></div>
            <div class="userPhone"><?php echo $text->get("v2-profile-phone-heading") ?><?php echo $user_data["userPhone"];?></div>
            <div class="lastArticle"></div>
            <div class="lastComment"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="/forum/v2/assets/style/profile.css">
<script src="/forum/v2/assets/script/profile.js"></script>