<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.settings.css">';
echo '<div class="block settings-block theme-main-color-2">';

echo '<div class="settings-block-heading block-heading theme-main-color-2">' . $text->get("settings-block-heading") . '</div>';

echo '<div class="settings-text-box">
    <form class="setting">
        <tr><h1 class="setting-heading">Thema</h1>';

foreach($info->get_themes() as $value) {
    if ($_SESSION["theme"] === $value) {
        $checked = "checked";
    } else {
        $checked = "";
    }
    echo '
    <label name="theme">' . $value . '</label>
    <input class="theme_radio" type="radio" name="theme" id="' . $value . '" ' . $checked . '>
    ';
}

switch ($_SESSION["language"]) {
    case "english":
        $english = "checked";
        break;
    case "deutsch":
        $deutsch = "checked";
        break;
    default: 
        $english = "checked";
        break;
}
echo '</form>
    <form class="setting">
        <h1 class="setting-heading">Sprache</h1>
        <label name="language">Deutsch</label>
        <input class="language_radio" type="radio" name="language" id="deutsch" ' . $deutsch . '>
        <label name="language">English</label>
        <input class="language_radio" type="radio" name="language" id="english" ' . $english . '>
    </form>
</div>';


echo '<div class="settings-save">' . $text->get("settings-save") . '</div>';
echo '</div>';

echo '<script src="/forum/assets/script/settings.js"></script>';

echo '<script>console.log("' . $_SESSION["theme"] .'")</script>';