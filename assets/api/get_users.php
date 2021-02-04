<?php
session_start();
$hide_frame = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";


if (isset($rargs["page"])) {
    $page = intval($rargs["page"]);
} else {
    $page = intval($_SESSION["userPage"]);
}

if (isset($rargs["search"])) {
    $phrase = $rargs["search"];
} else {
    $phrase = "";
}

if (intval($_SESSION["userPage"]) < 0) {
    $_SESSION["userPage"] = 0;
}

if (!isset($_SESSION["userPage"])) {
    $_SESSION["userPage"] = 0;
}


if (isset($rargs["rsearch"])) {
    $mode_list = [];

    if (isset($rargs["name"])) {
        array_push($mode_list, "userName");
    }
    if (isset($rargs["mail"])) {
        array_push($mode_list, "userMail");
    }
    if (isset($rargs["description"])) {
        array_push($mode_list, "userDescription");
    }
    if (isset($rargs["phone"])) {
        array_push($mode_list, "userPhone");
    }
    if (isset($rargs["employment"])) {
        array_push($mode_list, "userEmployment");
    }

    $user_list = $data->search_users($rargs["rsearch"], $page * $info->page_amount(), $info->page_amount(), $mode_list);
} else {
    $user_list = $data->search_users($phrase, $page * $info->page_amount(), $info->page_amount());
}

$return = "";
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

    $return .= '
        <div class="user-block-entry hover-theme-main-4 theme-main-color-3 block-entry' . $self . '" user_id="' . $value["userId"] . '" user_name="' . htmlspecialchars($value["userName"]) . '"  id="user_' . $value["userId"] . '">
            <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . htmlspecialchars($value["userName"]) . $verified . '</span><br>
            <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">' . htmlspecialchars($text->get("user-block-mail")) . '</p>' . $value["userMail"] .'</span>
            <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">' . $view_text . '</p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
            <span class="user-block-entry-element block-entry-element user-likes"><p class="user-likes-heading user-block-entry-heading block-entry-heading">' . $like_text . '</p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
        </div>

        <script>
            document.getElementById("user_' . $value["userId"] . '").addEventListener("click", (e) => {
                window.location = "/forum/?userId=' . $value["userId"] . '";
            })
        </script>
    ';
}



echo $return;