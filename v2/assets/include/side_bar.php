<link rel="stylesheet" href="/forum/v2/assets/style/side_bar.css">
<link rel="stylesheet" href="/forum/v2/assets/style/user-profile.css">
<?php 
if ($info->mobile === true) {
    echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.side_bar.css">';
} 

// Set display of elements when logged in
if (isset($_SESSION["userId"])) {
    $user_data = $data->get_user_by_id($_SESSION["userId"]);
    $user_image_element = '<img src="/forum/assets/img/icon/user.svg" alt="U" class="user-profile-picture user-profile-color-overlay-' . $data->get_user_setting("color", $_SESSION["userId"]) . '">';
    $logged_out_show = "style=\"display: none;\"";
} else {
    $user_data = [
        "userName" => "<a href='#Login'>" . $text->get("v2-user-login-promt") . "</a>!",
        "userAge" => $text->get("v2-user-login-effect"),
        "userEmployment" => "<a href='#Login'>" . $text->get("v2-user-login-effect-2") . "</a>!"
    ];
    $user_image_element = '<img src="/forum/assets/img/icon/user.svg" alt="U" style="cursor:pointer;" onclick="window.location.hash = \'Login\'">';
    $hide_l_bar = "style=\"display: none;\"";
}
?>
<div class="sidebar-toggle" onclick='opened = true; document.querySelector(".sidebar-toggle").style.display = "none"; update_sidebar_visibility();'>
    <img src="/forum/assets/img/icon/menu.svg" alt="M">
</div>
<div class="sidebar-container <?php echo $hide_l_bar_css_shorten_block; ?>">
    <div class="userview-container">
    <img class="sidebar-close" src="/forum/assets/img/icon/close.svg" alt="" onclick='opened = false; document.querySelector(".sidebar-toggle").style.display = ""; update_sidebar_visibility();'>
        <div class="userview-user">
            <div class="userview-image">
                <?php echo $user_image_element; ?>
            </div>
            <div class="userview-details">
                <div class="userview-name">
                    <?php echo $user_data["userName"]; ?>
                </div>
                <div class="userview-employment">
                    <?php echo $user_data["userAge"] . ", " . $user_data["userEmployment"];?>
                </div>
            </div>
        </div>
        <div class="userview-bar">
            <div class="userview-login" <?php echo $logged_out_show; ?>>
                <img src="/forum/assets/img/icon/login.svg" alt="L">
            </div>
            <div class="userview-settings">
                <img src="/forum/assets/img/icon/settings.png" alt="S">
            </div>
            <div class="userview-logout" <?php echo $hide_l_bar; ?>>
                <img src="/forum/assets/img/icon/logout.png" alt="L">
            </div>
        </div>
    </div>
    <div class="sidebar-gradient-div"></div>
    <div class="category-container">
        <?php foreach ($data->get_categories() as $category) {echo '
            <a class="category-header" link="' . $category . '">
            ' . $text->get("v2-category-" . $category) . '
            <!--<img src="/forum/assets/img/icon/arrow.svg" alt="">-->
            <div class="bicu"></div>
            <div class="scdb"></div>
            </a>
        ';} // div with class bicu is background on chose, scdb is the side thing like on discord
        ?>
    </div>
    <div class="information-container">
        <div class="information-element">
            <img src="/forum/assets/img/icon/contact.svg" alt="Contact">
        </div>
        <div class="information-element">
            <img src="/forum/assets/img/icon/information.png" alt="Info">
        </div>
    </div>
</div>
<script src="/forum/v2/assets/script/side_bar.js" defer></script>