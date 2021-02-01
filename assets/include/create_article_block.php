<?php

echo '<link rel="stylesheet" href="/forum/assets/style/pc.create_article_block.css">';

echo '<div class="block create-article-block">';

echo '<div class="frame-menu-create block-heading theme-main-color-2">' . $text->get("frame-menu-create") . '</div>';

echo 
'
<form action="/forum/assets/site/create_article.php" method="post" class="create-article-block-form">
    <input type="text" name="title" placeholder="' . $text->get("create-article-title") . '" class="title">
    <textarea rows="15" columns="20" name="text" placeholder="' . $text->get("create-article-text") . '" class="text"></textarea>
    <input type="text" name="tags" placeholder="' . $text->get("create-article-tags") . '" class="tags">
    <input type="submit" name="submit" class="submit" id="submit-article">
</form>
';

echo '</div>';