<?php 



if (isset($_SESSION["user"])) {
    $account = $text->get("frame-menu-account");
    $account_ref = "/forum/?show=account";
    $logged = '<a class="main-menu-entry hover-theme-main-color-3 theme-main-color-1" href="/forum/assets/site/create_article.php">' . $text->get("frame-menu-create") . '</a><a class="main-menu-entry theme-main-color-1 hover-theme-main-color-3 main-menu-entry-last" href="/forum/assets/site/login.php?logout=true">' . $text->get("frame-menu-logout") . '</a><br>';
    $last_text = "";
} else {
    $account = $text->get("frame-menu-login");
    $account_ref = "/forum/assets/site/login.php";
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
    <img class="main-menu-icon" alt="Menu" src="https://img.icons8.com/material-rounded/1000/000000/menu.png"/>

    <h1 class="main-heading-text">' . $text->get("frame-pc-heading") . '</h1>';




    
if ($info->mobile === false) {
    echo '
    <form action="/forum/" method="get" class="main-heading-search">
        <input type="text" name="search" autocomplete="off" placeholder="' . $text->get("frame-pc-heading-search") .'"  class="main-heading-search-text theme-main-color-2">

        <script src="/forum/assets/script/preview.js"></script>
        <div class="theme-main-color-2 main-heading-search-preview"></div>
        
        <input type="submit" class="main-heading-search-submit theme-main-color-2" value="&#x1F50E;">
    </form>
    
    </div>
    <div class="main-menu theme-main-color-1">
        <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-3 main-menu-entry-first" href="' . $account_ref . '">' . $account . '</a><br>
        <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-3 ' . $last_text . '" href="/forum/?show=about">' . $text->get("frame-menu-about") . '</a><br>' . $logged . '
    </div>
    
    <script src="/forum/assets/script/include/frame.js"></script>';
} else {
    echo '
    </div>
    <div class="main-menu theme-main-color-1">
        
        <input class="main-menu-entry main-menu-entry-search main-menu-entry-first theme-main-color-1" placeholder="' . $text->get("frame-menu-search") .'">
        <button class="frame-menu-entry-search-button theme-main-color-1 hover-theme-main-color-3">' . $text->get("frame-menu-search-button") .'</button><br>
    
        <script>
            document.querySelector(".main-menu-entry-search").addEventListener("keydown", (e) => {
                if (e.key === "Enter" ) {
                    window.location = `/forum/?search=${e.target.value}`
                }
            });

            document.querySelector(".frame-menu-entry-search-button").addEventListener("click", (e) => {
                window.location = `/forum/?search=${document.querySelector(".main-menu-entry-search").value}`
            });
        </script>

        <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-3" href="' . $account_ref . '">' . $account . '</a><br>
        <a class="main-menu-entry theme-main-color-1 hover-theme-main-color-3 ' . $last_text . '" href="/forum/?show=about">' . $text->get("frame-menu-about") . '</a><br>' . $logged . '
    </div>
    
    <script src="/forum/assets/script/include/frame.js"></script>
    
    
    <div class="theme-switcher theme-main-color-1 hover-theme-main-color-2" id="theme-switcher">' . $text->get("theme-switcher") . '</div>
    <div class="language-switcher theme-main-color-1 hover-theme-main-color-2" id="language-switcher">' . $text->get("language-switcher") . '</div>
    ';
}

