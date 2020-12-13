<?php 


if (isset($_SESSION["user"])) {
    $account = $text->get("frame-menu-account");
    $logged = '<a class="main-menu-entry hover-theme-main-color-2" href="/forum/assets/site/create_article.php">' . $text->get("frame-menu-create") . '</a><a class="main-menu-entry hover-theme-main-color-2" href="/forum/assets/site/login.php?logout=true">' . $text->get("frame-menu-logout") . '</a><br>';
} else {
    $account = $text->get("frame-menu-login");
    $logged = "";
}

echo '
<link rel="stylesheet" href="/forum/assets/style/pc.frame.css">
<div class="main-heading-container theme-main-color-1">
    <img class="main-menu-icon" src="https://img.icons8.com/material-rounded/1000/000000/menu.png"/>

    <h1 class="main-heading-text">' . $text->get("frame-pc-heading") . '</h1>';

if ($info->mobile === false) {
    echo '
        <form action="/forum/" method="get" class="main-heading-search">
            <input type="text" name="search" autocomplete="off" placeholder="' . $text->get("frame-pc-heading-search") .'"  class="main-heading-search-text theme-main-color-2">
            <input type="submit" class="main-heading-search-submit theme-main-color-2" value="->">
        </form>';
}
    
echo '
</div>
<div class="main-menu theme-main-color-1">
    <a class="main-menu-entry hover-theme-main-color-2" href="/forum/?show=account">' . $account . '</a><br>
    <a class="main-menu-entry hover-theme-main-color-2" href="/forum/?show=about">' . $text->get("frame-menu-about") . '</a><br>' . $logged . '
</div>

<script>
    var hidden = true;
    document.querySelector(".main-menu-icon").addEventListener("click", (e) => {
        if (hidden === true) {
            document.querySelector(".main-menu").style.display = "initial";
            hidden = false;
        } else {
            document.querySelector(".main-menu").style.display = "none";
            hidden = true;
        }
    })
</script>
<script>
    var size_heading = () => {
        let font_size = Math.min(window.innerWidth / 23,  60);
        document.querySelector(".main-heading-text").style.fontSize = font_size + "px";
    }

    window.onresize = size_heading;
    window.onload = size_heading;
</script>
';


echo '
<div class="theme-switcher theme-main-color-1" id="theme-switcher">' . $text->get("theme-switcher") . '</div>
<script src="/forum/assets/script/theme.js"></script>
';

echo '
<div class="language-switcher theme-main-color-1" id="language-switcher">' . $text->get("language-switcher") . '</div>
<script src="/forum/assets/script/language.js"></script>
';