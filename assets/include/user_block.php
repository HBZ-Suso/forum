<?php 

echo '<script src="/forum/assets/script/include/replace_users.js" defer></script>';

echo '
<div class="user-block block block theme-main-color-2">
    <h1 class="user-block-heading block-heading">' . $text->get("user-block-heading") . '</h1>';
                
if (isset($_GET["search"])) {
    $phrase = $_GET["search"];
} else {
    $phrase = "";
}

if (intval($_SESSION["userPage"]) < 0) {
    $_SESSION["userPage"] = 0;
}

if (!isset($_SESSION["userPage"])) {
    $_SESSION["userPage"] = 0;
}


if (isset($_GET["rsearch"])) {
    $mode_list = [];

    if (isset($_GET["name"])) {
        array_push($mode_list, "userName");
    }
    if (isset($_GET["mail"])) {
        array_push($mode_list, "userMail");
    }
    if (isset($_GET["description"])) {
        array_push($mode_list, "userDescription");
    }
    if (isset($_GET["phone"])) {
        array_push($mode_list, "userPhone");
    }
    if (isset($_GET["employment"])) {
        array_push($mode_list, "userEmployment");
    }

    $user_list = $data->search_users($_GET["rsearch"], intval($_SESSION["userPage"]) * $info->page_amount(), $info->page_amount(), $mode_list);
} else {
    $user_list = $data->search_users($phrase, intval($_SESSION["userPage"]) * $info->page_amount(), $info->page_amount());
    if ($mobile === true) {
        $user_list = $data->search_users($phrase, intval($_SESSION["userPage"]) * $info->page_amount(), $info->page_amount());
    }
}

echo '<div class="scroll-el" id="user-block-scroll">';


foreach ($user_list as $value) {
    if ($data->is_logged_in() && ($_SESSION["userId"] === $value["userId"])) {
        $self = " owned";
    } else {
        $self = "";
    }

    if ($value["userVerified"] == "1") {
        $verified = '<p class="verified">&#10003</p>';
    } else {
        $verified = "";
    }

    if ($info->mobile === true) {
        $like_text = '<img class="like-icon-heart" alt="Likes:" src="https://img.icons8.com/fluent/1000/000000/like.png"/>';
    } else {
        $like_text = $text->get("user-block-like");
    }

    if ($info->mobile === true) {
        $view_text = '<img class="view-icon-eye" alt="Views: " src="https://img.icons8.com/material-sharp/1000/000000/visible.png"/>';
    } else {
        $view_text = $text->get("user-block-views");
    }

    echo '
        <div ref="userId=' . $value["userId"] . '" class="user-block-entry hover-theme-main-4 theme-main-color-3 block-entry' . $self . '" user_id="' . $value["userId"] . '" user_name="' . htmlspecialchars($value["userName"]) . '"  id="user_' . $value["userId"] . '">
            <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["userName"]) . $verified . '</span><br>
            <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">' . htmlspecialchars($text->get("user-block-mail")) . '</p>' . $value["userMail"] .'</span>
            <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
            <span class="user-block-entry-element block-entry-element user-likes"><p class="user-likes-heading user-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
        </div>

        <script>
        document.getElementById("user_' . $value["userId"] . '").addEventListener("click", (e) => {
            if (typeof pc_findings == "undefined") {
                window.location = "/forum/?userId=' . $value["userId"] . '";
            } else {
                view("userId=' . $value["userId"] . '");
            }
        })
        </script>
    ';
}

echo '
</div>
<img alt="->" id="uwr" class="page-arrow page-arrow-right" src="https://img.icons8.com/flat_round/64/000000/arrow--v1.png"/>
<script>document.getElementById("uwr").addEventListener("click", () => {axios.post("/forum/assets/api/set_userPage.php?userPage=" + (parseInt(document.getElementById("upc").innerText))).then((result) => {reset_users(); document.getElementById("upc").innerText = parseInt(document.getElementById("upc").innerText) + 1}).catch((e) => {console.debug(e);})})</script>
<p class="userPage" id="upc">' . (intval($_SESSION["userPage"]) + 1) .'</p>
<img alt="<-" id="uwl" class="page-arrow page-arrow-left" style="transform: rotate(180deg); " src="https://img.icons8.com/flat_round/64/000000/arrow--v1.png"/>
<script>document.getElementById("uwl").addEventListener("click", () => {axios.post("/forum/assets/api/set_userPage.php?userPage=" + (parseInt(document.getElementById("upc").innerText - 2))).then((result) => {if (parseInt(document.getElementById("upc").innerText) - 1  > 0) {reset_users(); document.getElementById("upc").innerText = parseInt(document.getElementById("upc").innerText) - 1}}).catch((e) => {console.debug(e);})})</script>
</div>';