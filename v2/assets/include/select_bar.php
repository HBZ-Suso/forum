<link rel="stylesheet" href="/forum/v2/assets/style/select_bar.css">
<?php if ($info->mobile === true) {echo '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.select_bar.css">';} ?>
<div class="selectbar-container">
<?php
foreach ($data->get_categories() as $category) {
    if (isset($_SESSION["userId"])) {
        $create_post = '<div class="selectbar-page-create selectbar-' . $category . '-create"><img src="/forum/assets/img/icon/create_post.svg">' . $text->get("v2-create-post") . '</div>';
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

    if (isset($_SESSION["userId"])) {
        $logged_space = "selectbar-logged";
    }

    echo '
    <div class="selectbar-page selectbar-' . $category . ' ' . $logged_space . '">
        <div class="selectbar-page-heading">' . $category . '</div>
        <div class="selectbar-sort-container selectbar-' . $category . '-sort-container">
            <div sortname="created" class="selectbar-sort-toggled selectbar-sort-down selectbar-sort-created selectbar-' . $category . '-sort-created selectbar-' . $category . '-sort" onclick="set_sort(this, \'' . $category . '\')"><img src="/forum/assets/img/icon/downarrow.png"><p>' . $text->get("v2-sort-created") . '</p></div>
            <div sortname="comments" class="selectbar-sort-down selectbar-sort-comments selectbar-' . $category . '-sort-comments selectbar-' . $category . '-sort" onclick="set_sort(this, \'' . $category . '\')"><img src="/forum/assets/img/icon/downarrow.png"><p>' . $text->get("v2-sort-comments") . '</p></div>
            <div sortname="views" class="selectbar-sort-down selectbar-sort-views selectbar-' . $category . '-sort-views selectbar-' . $category . '-sort" onclick="set_sort(this, \'' . $category . '\')"><img src="/forum/assets/img/icon/downarrow.png"><p>' . $text->get("v2-sort-views") . '</p></div>
            <div sortname="likes" class="selectbar-sort-down selectbar-sort-likes selectbar-' . $category . '-sort-likes selectbar-' . $category . '-sort" onclick="set_sort(this, \'' . $category . '\')"><img src="/forum/assets/img/icon/downarrow.png"><p>' . $text->get("v2-sort-likes") . '</p></div>
        </div>
        <div class="selectbar-page-tools selectbar-page-tools-create-' . $crate_post_visible . '">
            <div class="selectbar-page-search-box selectbar-page-search-box-create-' . $crate_post_visible . '" onkeyup="update_articles(\'' . $category . '\')">
                <img class="selectbar-' . $category . '-search-logo selectbar-page-search-logo selectbar-page-search-logo-create-' . $crate_post_visible . '" src="/forum/assets/img/icon/search.svg">
                <input class="selectbar-' . $category . '-search selectbar-page-search selectbar-page-search-create-' . $crate_post_visible . '" type="text" placeholder="' . $text->get("v2-search-topic") . '">
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