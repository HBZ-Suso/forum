<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.settings.css">';
echo '<link rel="stylesheet" href="/forum/assets/style/elements/pc.radio_style.css">';
echo '<div class="block settings-block theme-main-color-2">';

echo '<div class="settings-block-heading block-heading theme-main-color-2">' . $text->get("settings-block-heading") . '</div>';

echo '
<div class="settings-navigation-bar">
    <img src="/forum/assets/img/icon/translation.png" class="snb-element snb-language" open="settings-page-language">
    <img src="/forum/assets/img/icon/theme.png" class="snb-element snb-theme" open="settings-page-theme">';
    if ($data->is_logged_in()) { echo '<img src="/forum/assets/img/icon/padlock.png" class="snb-element snb-public" open="settings-page-public">
    <img src="/forum/assets/img/icon/notification.png" class="snb-element snb-notification" open="settings-page-notification">';} echo '
</div>
<img src="/forum/assets/img/icon/reload.png" class="settings-reload" alt="Reload Page">
';





// LANGUAGE
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
echo '
    <div class="settings-page settings-page-language" style="display: none;">
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
    </div>
';




if ($_SESSION["colorscheme"] === "dark") {
    $scheme_checked = "checked";
}


echo '
    <div class="settings-page settings-page-theme" style="display: none;">
        <form class="setting">
            <h1 class="setting-heading">' . $text->get("theme-setting-scheme") . '</h1>
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
                    </div>';
                }   
        echo '</div>
        </form>
        <form class="setting">
            <h1 class="setting-heading">' . $text->get("theme-setting-heading") . '</h1>
            <label class="switch scheme-switch">
                <input type="checkbox" class="scheme-switch-box" ' . $scheme_checked  . '>
                <span class="slider round"></span>
            </label>
        </form>
    </div>
';



if ($data->is_logged_in()) {

if (json_decode($data->get_user_by_id($_SESSION["userId"]), true)["public"]) {
    $public = "checked";
} else {
    $hidden = "checked";
}

echo '
    <div class="settings-page settings-page-public" style="display: none;">
        <form class="setting">
            <h1 class="setting-heading">' . $text->get("public-setting-heading") . '</h1>
            <div class="container">
                <div class="option">
                    <input class="public_radio" type="radio" name="public" id="i-hidden" value="public" ' . $hidden . '>
                    <label for="i-hidden" aria-label="i-hidden">
                    <span></span>
                    ' . $text->get("public-setting-hidden") . '
                    </label>
                </div>
            
                <div class="option">
                    <input class="public_radio" type="radio" name="public" id="i-public" value="public" ' . $public . '>
                    <label for="i-public" aria-label="i-public">
                    <span></span>
                    ' . $text->get("public-setting-public") . '
                    </label>
                </div>
            </div>
        </form>
    </div>
';



if (json_decode($data->get_user_by_id($_SESSION["userId"]), true)["privacy"] == "low") {
    $low = "checked";
} else if (json_decode($data->get_user_by_id($_SESSION["userId"]), true)["privacy"] == "medium") {
    $medium = "checked";
} else {
    $high = "checked";
}

echo '
    <div class="settings-page settings-page-notification" style="display: none;">
        <form class="setting">
            <h1 class="setting-heading">' . $text->get("notification-setting-heading") . '</h1>
            <div class="container">
                <div class="option">
                    <input class="notification_radio" type="radio" name="notification" id="low" value="low" ' . $low . '>
                    <label for="low" aria-label="low">
                    <span></span>
                    ' . $text->get("notification-setting-low") . '
                    </label>
                </div>
            
                <div class="option">
                    <input class="notification_radio" type="radio" name="notification" id="medium" value="medium" ' . $medium . '>
                    <label for="medium" aria-label="medium">
                    <span></span>
                    ' . $text->get("notification-setting-medium") . '
                    </label>
                </div>

                <div class="option">
                    <input class="notification_radio" type="radio" name="notification" id="high" value="high" ' . $high . '>
                    <label for="high" aria-label="high">
                    <span></span>
                    ' . $text->get("notification-setting-high") . '
                    </label>
                </div>
            </div>
        </form>
    </div>
';

};



/*
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
*/
echo '</div>';


echo '<script src="/forum/assets/script/settings.js"></script>';