<link rel="stylesheet" href="/forum/v2/assets/style/select_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.select_bar.css">';} ?>
<div class="selectbar-container">
<?php
foreach ($data->get_categories() as $category) {
    if (isset($_SESSION["userId"])) {
        $create_post = '<div class="selectbar-page-create selectbar-' . $category . '-create"><img src="/forum/assets/img/icon/create_post.svg">New Post</div>';
        $crate_post_visible = 'visible';
    }

    $articles = "";
    // IMPLEMENT ARTICLE FIND AND STUF F
    /*$articles .= '
    <div class="selectbar-article-element selectbar-article-element-2" onclick="window.location.hash=\'#Article?articleId=2\'">
        <img src="/forum/assets/img/icon/article.svg">
        <h1>Unser Forum</h1>
        <div>
            <p>Geschrieben von <a onclick="event.stopPropagation();" href="#Profile?userId=1">NathanZumbusch</a> •</p>
            <p>14 Kommentare</a> •</p>
            <p>Letzte Antwort um 17 Uhr</p>
        </div>
    </div>
    ';*/

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
        <div class="selectbar-article-container selectbar-' . $category . '-article-container">
            ' . $articles . '
        </div>
    </div>
    ';
}
?>
</div>

<script>
window.addEventListener("load", () => {document.querySelectorAll(".selectbar-page-create").forEach((element, index) => {element.addEventListener("click", (e) => {window.location.hash = "CreatePost";})})})
</script>