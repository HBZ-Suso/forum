<?php 

if ($info->mobile === true) {

} else {
    echo '
    <link rel="stylesheet" href="/forum/assets/style/pc.frame.css">
    <div class="main-heading-container">
        <img class="main-menu-icon" src="https://img.icons8.com/material-rounded/50/000000/menu.png"/>

        <h1 class="main-heading-text">' . $text->get("frame-pc-heading") . '</h1>

        <form action="/forum/" method="get" class="main-heading-search">
            <input type="text" name="search" placeholder="' . $text->get("frame-pc-heading-search") .'"  class="main-heading-search-text">
            <input type="submit" class="main-heading-search-submit" value="->">
        </form>
    </div>
    ';







}

