<link rel="stylesheet" href="/forum/v2/assets/style/view_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.view_bar.css">';} ?>
<div class="viewbar-container" style="display: none;">
    <img class="viewbar-close" src="/forum/assets/img/icon/close.svg" onclick="if (window.innerWidth < 1500 || window.mobileCheck() == true) {close_article();}">
    <div class="viewbar-empty">
        <p><?php echo $text->get("v2-open-article-first");?></p>
    </div>
    <div class="viewbar-content"></div>
</div>