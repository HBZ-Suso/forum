<link rel="stylesheet" href="/forum/v2/assets/style/select_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.select_bar.css">';} ?>
<div class="selectbar-container">
<?php
foreach ($data->get_categories() as $category) {
    if (isset($_SESSION["userId"])) {
        $create_post = '<div class="selectbar-page-create selectbar-' . $category . '-create"><img src="/forum/assets/img/icon/create_post.svg">New Post</div>';
    }
    echo '
    <div class="selectbar-page selectbar-' . $category . '">
        <div class="selectbar-page-heading">' . $category . '</div>
        <div class="selectbar-page-tools">
            <div class="selectbar-page-search-box">
                <img class="selectbar-' . $category . '-search-logo selectbar-page-search-logo" src="/forum/assets/img/icon/search.svg">
                <input class="selectbar-' . $category . '-search selectbar-page-search" type="text">
            </div>
            ' . $create_post . '
        </div>
    </div>
    ';
}
?>
</div>