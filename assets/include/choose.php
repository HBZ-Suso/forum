<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.choose.css">';

echo '<div class="block choose-block theme-main-color-2">';

echo '<div class="block-entry choose-entry choose-overview theme-main-color-3" show="overview-block-heading">' . $text->get("overview-block-heading") . '</div>';
echo '<div class="block-entry choose-entry choose-articles theme-main-color-3" show="article-block-heading">' . $text->get("article-block-heading") . '</div>';
echo '<div class="block-entry choose-entry choose-users theme-main-color-3" show="user-block-heading">' . $text->get("user-block-heading") . '</div>';

if ($data->is_logged_in()) {
    echo '<div class="block-entry choose-entry choose-highlights theme-main-color-3" show="highlight-block-heading">' . $text->get("highlight-block-heading") . '</div>';
    echo '<a href="/forum/assets/site/account.php" class="block-entry choose-entry choose-account theme-main-color-3" show="account-heading">' . $text->get("frame-menu-account") . '</a>';
    echo '<div class="block-entry choose-entry choose-create theme-main-color-3" show="frame-menu-create">' . $text->get("frame-menu-create") . '</div>';
}

echo '<div class="block-entry choose-entry choose-collaborators theme-main-color-3" show="about-collab-title">' . $text->get("about-collab-title") . '</div>';

echo '</div>';