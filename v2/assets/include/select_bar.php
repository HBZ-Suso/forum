<link rel="stylesheet" href="/forum/v2/assets/style/select_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.select_bar.css">';} ?>
<div class="selectbar-container">
<?php
foreach ($data->get_categories() as $category) {
    if (isset($_SESSION["userId"])) {
        $create_post = '<div class="selectbar-page-create selectbar-' . $category . '-create"><img src="/forum/assets/img/icon/create_post.svg">New Post</div>';
        $crate_post_visible = 'visible';
    }
    echo '
    <div class="selectbar-page selectbar-' . $category . '">
        <div class="selectbar-page-heading">' . $category . '</div>
        <div class="selectbar-page-tools selectbar-page-tools-create-' . $crate_post_visible . '">
            <div class="selectbar-page-search-box selectbar-page-search-box-create-' . $crate_post_visible . '">
                <img class="selectbar-' . $category . '-search-logo selectbar-page-search-logo selectbar-page-search-logo-create-' . $crate_post_visible . '" src="/forum/assets/img/icon/search.svg">
                <input class="selectbar-' . $category . '-search selectbar-page-search selectbar-page-search-create-' . $crate_post_visible . '" type="text" placeholder="Search topic">
            </div>
            ' . $create_post . '
        </div>
    </div>
    ';
}
?>
</div>