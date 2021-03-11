<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.settings.css">';
echo '<link rel="stylesheet" href="/forum/assets/style/elements/pc.radio_style.css">';
echo '<div class="block settings-block theme-main-color-2">';

echo '<div class="settings-block-heading block-heading theme-main-color-2">' . $text->get("settings-block-heading") . '</div>';

echo '<div class="settings-text-box">
    <form class="setting">
        <h1 class="setting-heading">' . $text->get("theme-setting-heading") . '</h1>
        <div class="container">';

foreach($info->get_themes() as $value) {
    if ($_SESSION["theme"] === $value) {
        $checked = "checked";
    } else {
        $checked = "";
    }
    echo '
    <div class="option">
        <input class="theme_radio" type="radio" name="language" id="' . $value . '" value="royal" ' . $checked . '>
        <label for="' . $value . '" aria-label="' . $value . '">
        <span></span>
        
        ' . $value . '

        </label>
    </div>
    ';
}

switch ($_SESSION["language"]) {
    case "english":
        $english = "checked";
        break;
    case "deutsch":
        $deutsch = "checked";
        break;
    case "français":
        $français = "checked";
        break;
    default: 
        $english = "checked";
        break;
}
echo '</div></form>
    <form class="setting">
        <h1 class="setting-heading">' . $text->get("language-setting-heading") . '</h1>
        <div class="container">
            <div class="option">
                <input class="language_radio" type="radio" name="language" id="english" value="language" ' . $english . '>
                <label for="english" aria-label="english">
                <span></span>
                English
                </label>
            </div>
        
            <div class="option">
                <input class="language_radio" type="radio" name="language" id="deutsch" value="language" ' . $deutsch . '>
                <label for="deutsch" aria-label="deutsch">
                <span></span>
                Deutsch
                </label>
            </div>

            <div class="option">
                <input class="language_radio" type="radio" name="language" id="français" value="language" ' . $français . '>
                <label for="français" aria-label="français">
                <span></span>
                Français
                </label>
            </div>
        </div>
    </form>
</div>';


echo '<div class="settings-save">' . $text->get("settings-save") . '</div>';
echo '</div>';

echo '<script src="/forum/assets/script/settings.js"></script>';