<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.choose.css">';

echo '<div class="block choose-block theme-main-color-2">';

echo '<div class="block-placeholder" style="box-shadow: none;"></div>';

echo '<div class="block-entry choose-entry choose-overview theme-main-color-3" show="overview-block-heading">' . $text->get("overview-block-heading") . '</div>';
echo '<div class="block-entry choose-entry choose-about theme-main-color-3" show="about-block-heading">' . $text->get("about-us-title") . '</div>';
echo '<div class="block-placeholder"></div>';
echo '<div class="block-entry choose-entry choose-views theme-main-color-3" show="view-block-heading" style="display: none;">' . $text->get("view-block-heading") . '</div>';
echo '<div class="block-entry choose-entry choose-articles theme-main-color-3" show="article-block-heading">' . $text->get("article-block-heading") . '</div>';
echo '<div class="block-entry choose-entry choose-users theme-main-color-3" show="user-block-heading">' . $text->get("user-block-heading") . '</div>';

if ($data->is_logged_in()) {
    echo '<div class="block-entry choose-entry choose-highlights theme-main-color-3" show="highlight-block-heading">' . $text->get("highlight-block-heading") . '</div>';
    echo '<div class="block-placeholder"></div>';
    echo '<a href="/forum/assets/site/account.php" class="block-entry choose-entry choose-account theme-main-color-3" show="account-heading">' . $text->get("frame-menu-account") . '</a>';
    if ($data->is_admin_by_id($_SESSION["userId"])) {
        echo '<a href="/forum/assets/admin/" class="block-entry choose-entry choose-administration theme-main-color-3" show="administration-heading">' . $text->get("choose-block-administration") . '</a>';
    }
    echo '<div class="block-entry choose-entry choose-create theme-main-color-3" show="frame-menu-create">' . $text->get("frame-menu-create") . '</div>';
}
echo '<div class="block-placeholder"></div>';
echo '<div class="block-entry choose-entry choose-report theme-main-color-3" show="frame-menu-create-report">' . $text->get("frame-menu-create-report") . '</div>';
echo '<div class="block-entry choose-entry choose-settings theme-main-color-3" show="settings-block-heading">' . $text->get("settings-block-heading") . '</div>';
echo '</div>';