<?php

$args = ["title", "text", "author", "name", "mail", "description", "phone", "employment"];
$set = [];
$one_set = false;
foreach($args as $value) {
    if (isset($_GET[$value])) {
        $set[$value] = "checked";
        $set_c[$value] = "refined-search-icon-checked";
        $one_set = true;
    } else {
        $set[$value] = "";
        $set_c[$value] = "";
    }
}

if ($one_set === false) {
    foreach($args as $value) {
        $set[$value] = "checked";
        $set_c[$value] = "refined-search-icon-checked";
    }
}


if (isset($_GET["search"])) {
    $search = $_GET["search"];
} else if (isset($_GET["rsearch"])) {
    $search = $_GET["rsearch"];
} else {
    $search = "";
}

if (!isset($_GET["rsearch"])) {
    $style = 'display: none;';
} else {
    $style = '';
}


echo '
    <link rel="stylesheet" href="/forum/assets/style/refined_search.css">

    <form action="/forum/?rsearch=true" method="get" class="refined-search" style="' . $style . '" id="refined-search-form">
        <input type="text" name="rsearch" autocomplete="off" placeholder="Refined Search..." value="' . htmlspecialchars($search) . '"  class="refined-search-text theme-main-color-2">
        <input type="submit" class="refined-search-submit theme-main-color-2" value="->"><br>

        <table class="refined-search-table">
            <tr>
                <th><label for="title" class="refined-search-label">' . $text->get("refined-title") . '</label></th>
                <th><label for="text" class="refined-search-label">' . $text->get("refined-text") . '</label></th>
                <!--<th><label for="author" class="refined-search-label">' . $text->get("refined-author") . '</label></th>-->
                <th><label for="info" class="refined-search-label">|</label></th>
                <th><label for="title" class="refined-search-label">' . $text->get("refined-name") . '</label></th>
                <th><label for="text" class="refined-search-label">' . $text->get("refined-mail") . '</label></th>
                <th><label for="title" class="refined-search-label">' . $text->get("refined-description") . '</label></th>
                <th><label for="text" class="refined-search-label">' . $text->get("refined-phone") . '</label></th>
                <th><label for="text" class="refined-search-label">' . $text->get("refined-employment") . '</label><br></th>
            </tr>
            <tr>
                <td><img ' . $set["title"] . ' class="refined-search-icon ' . $set_c["title"] . '" id="title" src="/forum/assets/img/icon/title.png"></td>
                <td><img ' . $set["text"] . ' class="refined-search-icon ' . $set_c["text"] . '" id="text" src="/forum/assets/img/icon/text.png"></td>
                <td><p></p></td>
                <td><img ' . $set["name"] . ' class="refined-search-icon ' . $set_c["name"] . '" id="name" src="/forum/assets/img/icon/name.png"></td>
                <td><img ' . $set["mail"] . ' class="refined-search-icon ' . $set_c["mail"] . '" id="mail" src="/forum/assets/img/icon/mail.png"></td>
                <td><img ' . $set["description"] . ' class="refined-search-icon ' . $set_c["description"] . '" id="description" src="/forum/assets/img/icon/description.png"></td>
                <td><img ' . $set["phone"] . ' class="refined-search-icon ' . $set_c["phone"] . '" id="phone" src="/forum/assets/img/icon/phone.png"></td>
                <td><img ' . $set["employment"] . ' class="refined-search-icon ' . $set_c["employment"] . '" id="employment" src="/forum/assets/img/icon/employment.png"></td>
            </tr>
        </table>

        <div style="display: none;">
            <input type="checkbox" name="title" id="cb-title" ' . $set["title"] . '>
            <input type="checkbox" name="text" id="cb-text" ' . $set["text"] . '>
            <input type="checkbox" name="name" id="cb-name" ' . $set["name"] . '> 
            <input type="checkbox" name="description" id="cb-description" ' . $set["description"] . '>
            <input type="checkbox" name="phone" id="cb-phone" ' . $set["phone"] . '>
            <input type="checkbox" name="employment" id="cb-employment" ' . $set["employment"] . '>
            <input type="checkbox" name="mail" id="cb-mail" ' . $set["mail"] . '>
        </div>
    </form>   
';


echo '
<script>
    document.querySelectorAll(".refined-search-icon").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            if (e.target.classList.contains("refined-search-icon-checked") || e.target.hasAttribute("checked")) {
                e.target.classList.remove("refined-search-icon-checked");
                e.target.removeAttribute("checked");
                document.getElementById("cb-" + e.target.id).removeAttribute("checked");
            } else {
                e.target.classList.add("refined-search-icon-checked");
                e.target.setAttribute("checked", "");
                document.getElementById("cb-" + e.target.id).setAttribute("checked", "");
            }
        })
    });
</script>';
