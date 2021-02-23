<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.create_report_block.css">';

echo '<div class="block create-report-block theme-main-color-2">';

echo '<div class="frame-menu-create-report block-heading">' . $text->get("frame-menu-create-report") . '</div>';

echo 
'
<form action="/forum/assets/site/create_report.php" method="post" class="create-report-block-form">
    <input type="text" name="title" placeholder="' . $text->get("create-report-title") . '" class="title">
    <textarea rows="15" columns="20" name="text" placeholder="' . $text->get("create-report-text") . '" class="text"></textarea>
    <input type="submit" name="submit" class="submit" id="submit-report">
</form>
';

echo '</div><script src="/forum/assets/script/create_report.js"></script>';