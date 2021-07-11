<?php 


// Setting languages before including classes because class.text.php needs language on construct
if (!isset($_SESSION["language"])) {
    if (isset($_COOKIE["language"])) {
        $_SESSION["language"] = $_COOKIE["language"];
    } else {
        $_SESSION["language"] = "english";
    }
}
if ($_SESSION["language"] !== $_COOKIE["language"]) {
    setcookie("language", $_SESSION["language"], time() +24*3600*365, "/");
}

$rargs = array_merge($_GET, $_POST);

require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.info.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/v2/assets/class/class.data.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.text.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.mail.php";
$data = new DataV2();
$data->do_match();
if (isset($_SESSION["userId"])) {
    $user_v_v = $_SESSION["userId"];
} else {
    $user_v_v = "false";
}

$save_reg = $rargs;
if (isset($save_reg["password"])) {
    $save_reg["password"] = "blurred";
}
if (isset($save_reg["password_2"])) {
    $save_reg["password_2"] = "blurred";
}
$data->add_visit(json_encode($save_reg));

$info = new Info();
$text = new Text($_SESSION["language"]);
$mail = new Mail($data, $text);

if (isset($require_purifier)) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.filter.php";
    $filter = new Filter();
}



if (isset($_SESSION["colorscheme"])) {
    $scheme = $_SESSION["colorscheme"];
    if (!isset($_COOKIE["colorscheme"]) || $_COOKIE["colorscheme"] !== $_SESSION["colorscheme"]) {
        setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    }
} else if (isset($_COOKIE["colorscheme"])) {
    if (in_array($_COOKIE["colorscheme"], array("dark", "light"))) {
        $_SESSION["colorscheme"] = $_COOKIE["colorscheme"];
    }
    $scheme = $_SESSION["colorscheme"];
} else {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    $scheme = $_SESSION["light"];
}

if (!isset($_SESSION["colorscheme"])) {
    $_SESSION["colorscheme"] = "light";
    setcookie("colorscheme", $_SESSION["colorscheme"], time() + 60*60*24*365, "/");
    $scheme = "light";
}

if (!isset($_SESSION["CSRF-TOKEN"])) {
    $_SESSION["CSRF-TOKEN"] = bin2hex(random_bytes(10));
}

echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/assets/style/scheme-' . $scheme . '-file.css"></div>';
echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/v2/assets/style/colors.css"></div>';
if ($info->mobile === true) {
    echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/v2/assets/style/mobile.colors.css"></div>';
}
echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/v2/assets/style/colors.css"></div>';
echo '<div class="scheme-box"><link rel="stylesheet" href="/forum/v2/assets/style/user-profile.css"></div>';
echo '<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>';
echo '
<script>

var categories = ["Home", "About", "Discussion", "Projects", "Help"];

axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": "' . $_SESSION["CSRF-TOKEN"] . '"
}
</script>';
echo '<script src="/forum/v2/assets/script/connection.js"></script>';
echo '<script src="/forum/v2/assets/script/language_management.js"></script>';
echo '<script src="/forum/assets/script/functions.js"></script>';
echo '<script src="/forum/v2/assets/script/share.js"></script>';
echo '<script src="/forum/v2/assets/script/report.js"></script>'; 
echo '<script src="/forum/v2/assets/script/translate.js"></script>';

if ($data->is_logged_in()) {
        $id = $_SESSION["userId"];

        $user_data = $data->get_user_by_id($id);

        $user_data["userLikes"] = $data->get_user_likes_by_targetUserId($id);
        $user_data["articleLikes"] = $data->get_article_likes_by_user_Id($id);
        $user_data["userComments"] = $data->get_user_comments_by_targetUserId($id);
        $user_data["articleComments"] = count($data->get_article_comments_by_user_id($id));
        $user_data["userViews"] = $data->get_user_views_by_targetUserId($id);
        $user_data["articleViews"] = $data->get_article_views_by_user_id($id);
        $user_data["articles"] = count($data->get_articles_by_user_id($id));
        $user_data["color"] = $data->get_user_setting("color", $id);
        $user_data["profilePictureExtension"] = $data->get_user_setting("pPE", $id);
        if (isset($_SESSION["userId"])) {
            $user_data["liked"] = $data->check_if_user_liked_by_user($_SESSION["userId"], $id);
        } else {
            $user_data["liked"] = false;
        }


        unset($user_data["userPassword"]);

        if (isset($rargs["transformVerified"]) || isset($rargs["transformBoolean"])) {
            if ($user_data["userVerified"] == "1") {
                $user_data["userVerified"] = true;
            } else {
                $user_data["userVerified"] = false;
            }
        }
        if (isset($rargs["transformBoolean"])) {
            if ($user_data["userLocked"] == "1") {
                $user_data["userLocked"] = true;
            } else {
                $user_data["userLocked"] = false;
            }
        }
        if (isset($_GET["transformNull"])) {
            if ($user_data["userPhone"] == "") {
                $user_data["userPhone"] = null;
            }
            if ($user_data["userMail"] == "") {
                $user_data["userMail"] = null;
            }
        }

    echo '<script>var startup_data_user_data_json = ' . json_encode($user_data) . ';</script>';
    echo '<script src="/forum/v2/assets/script/user.js"></script>'; 
}
if (!isset($_GET["site"]) || $_GET["site"] !== "profile") {
    echo '<script src="/forum/v2/assets/script/hashmanagement.js"></script>';
    echo '<script src="/forum/v2/assets/script/login.js"></script>';
    echo '<script src="/forum/v2/assets/script/signup.js"></script>';
    echo '<script src="/forum/v2/assets/script/settings.js"></script>';
    echo '<script src="/forum/v2/assets/script/settings_functions.js"></script>';
    echo '<script src="/forum/v2/assets/script/create_post.js"></script>';
    echo '<script src="/forum/v2/assets/script/findings.js"></script>';
    echo '<script src="/forum/v2/assets/script/comment.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/show_article.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/show_profile.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/info.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/setting_html.js"></script>';
    echo '<script src="/forum/v2/assets/script/notification.js"></script>';
    echo '<script src="/forum/v2/assets/script/science.js"></script>';
    echo '<script async src="//cdn.jsdelivr.net/npm/@fingerprintjs/fingerprintjs@3/dist/fp.min.js"onload="initFingerprintJS()"></script>';
    echo '<script src="/forum/v2/assets/script/uaparser.min.js"></script>';

}
if ($data->is_logged_in()) {
    echo '<script src="/forum/v2/assets/chat/chat.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/profilepicture.js"></script>'; 
}
if ($data->is_logged_in() && ($data->is_admin_by_id($_SESSION["userId"]))) {
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    echo '<link href="https://unpkg.com/tabulator-tables@4.9.3/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@4.9.3/dist/js/tabulator.min.js"></script>';
    echo '<script src="/forum/v2/assets/script/show_administration.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/administration/graph_functions.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/administration/code_functions.js"></script>'; 
    echo '<script src="/forum/v2/assets/script/administration/table_functions.js"></script>'; 
    
    
}

if ($data->is_logged_in()) {
    echo "<script>var logged_in = true;</script>";
    if ($data->is_moderator_by_id($_SESSION["userId"])) {
        echo "<script>var user_type = 'moderator';</script>";
    } else if ($data->is_admin_by_id($_SESSION["userId"])) {
        echo "<script>var user_type = 'administrator';</script>";
    } else {
        echo "<script>var user_type = 'user';</script>";
    }
    echo "<script>var logged_in_user_id = " . $_SESSION["userId"] . ";</script>"; 
} else {
    echo "<script>var logged_in = false;</script>";
    echo "<script>var user_type = 'notlogged';</script>";
}




if (isset($_SESSION["theme"])) {
    $theme = $_SESSION["theme"];
    if (!isset($_COOKIE["theme"]) || $_COOKIE["theme"] !== $_SESSION["theme"]) {
        setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
    }
} else if (isset($_COOKIE["theme"])) {
    if (in_array($_COOKIE["theme"], $info->get_themes())) {
        $_SESSION["theme"] = $_COOKIE["theme"];
    }
    $theme = $_SESSION["theme"];
} else {
    $_SESSION["theme"] = "aqua";
    setcookie("theme", $_SESSION["theme"], time() + 60*60*24*365, "/");
    $theme = "aqua";
}

echo '<div id="theme-box"><link rel="stylesheet" href="/forum/assets/theme/' . $theme . '.css"></div>';


include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/loading.html";
include_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/include/ask_question.html";
if (!isset($_COOKIE["policy-agreed"]) || $_COOKIE["policy-agreed"] !== "true") {
    echo "<script src='/forum/v2/assets/script/tutorial.js'></script>";
}

if (isset($_SESSION["user"]) || isset($_SESSION["userId"])) {
    if (!isset($_SESSION["userIp"]) || $_SESSION["userIp"] !== $info->get_ip()) {
        unset($_SESSION["user"]);
        unset($_SESSION["userId"]);
        unset($_SESSION["userIp"]);
        header("LOCATION: /forum/?forced_logout=differentIp");
        exit("As your ip changed, you were logged out.");
    }
}