<?php 


if (isset($_SESSION["user"])) {
    $account = $text->get("frame-menu-account");
    $logged = '<a class="main-menu-entry hover-theme-main-color-2 theme-main-color-1" href="/forum/assets/site/create_article.php">' . $text->get("frame-menu-create") . '</a><a class="main-menu-entry theme-main-color-1 hover-theme-main-color-2 main-menu-entry-last" href="/forum/assets/site/login.php?logout=true">' . $text->get("frame-menu-logout") . '</a><br>';
    $last_text = "";
} else {
    $account = $text->get("frame-menu-login");
    $logged = "";
    $last_text = "main-menu-entry-last";
}

if ($info->mobile === false) {
    echo '<link rel="stylesheet" href="/forum/assets/style/pc.frame.css">';
} else {
    echo '<link rel="stylesheet" href="/forum/assets/style/mobile.frame.css">';
}

echo '
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
    <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-2 main-menu-entry-first" href="/forum/?show=account">' . $account . '</a><br>
    <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-2 ' . $last_text . '" href="/forum/?show=about">' . $text->get("frame-menu-about") . '</a><br>' . $logged . '
</div>

<script src="/forum/assets/script/include/frame.js"></script>

<div class="theme-switcher theme-main-color-1" id="theme-switcher">' . $text->get("theme-switcher") . '</div>
<div class="language-switcher theme-main-color-1" id="language-switcher">' . $text->get("language-switcher") . '</div>
';