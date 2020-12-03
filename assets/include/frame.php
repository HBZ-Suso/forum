<?php 

if ($info->mobile === true) {
    echo '
    <link rel="stylesheet" href="/forum/assets/style/mobile.frame.css">
    <div class="main-heading-container">
        <img class="main-menu-icon" src="https://img.icons8.com/material-rounded/50/000000/menu.png"/>

        <h1 class="main-heading-text">' . $text->get("frame-mobile-heading") . '</h1>
    </div>
    ';
} else {
    if (isset($_SESSION["user"])) {
        $account = $text->get("frame-menu-account");
        $logout = '<a class="main-menu-entry" href="/forum/assets/site/create_article.php">' . $text->get("frame-menu-create") . '</a><a class="main-menu-entry" href="/forum/assets/site/login.php?logout=true">' . $text->get("frame-menu-logout") . '</a><br>';
    } else {
        $account = $text->get("frame-menu-login");
        $logout = "";
    }

    echo '
    <link rel="stylesheet" href="/forum/assets/style/pc.frame.css">
    <div class="main-heading-container theme-main-color-1">
        <img class="main-menu-icon" src="https://img.icons8.com/material-rounded/1000/000000/menu.png"/>

        <h1 class="main-heading-text">' . $text->get("frame-pc-heading") . '</h1>

        <form action="/forum/" method="get" class="main-heading-search">
            <input type="text" name="search" autocomplete="off" placeholder="' . $text->get("frame-pc-heading-search") .'"  class="main-heading-search-text theme-main-color-2">
            <input type="submit" class="main-heading-search-submit theme-main-color-2" value="->">
        </form>
    </div>
    <div class="main-menu theme-main-color-1">
        <a class="main-menu-entry hover-theme-main-color-2" href="/forum/?show=account">' . $account . '</a><br>
        <a class="main-menu-entry hover-theme-main-color-2" href="/forum/?show=about">' . $text->get("frame-menu-about") . '</a><br>' . $logout . '
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
}

