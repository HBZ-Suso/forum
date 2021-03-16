<?php
function get_comment_block ($data, $text, $mode, $id) {
    // mode = articleId or userId

    $return = "";

    $return .= '<link rel="stylesheet" href="/forum/assets/style/comment.css">';
    $return .= '<div class="comment-section theme-main-color-1" id="comment_section_' . $mode . '=' . $id . '">';
    $return .= '<h3 id="loading-comments-info">...</h3>';


    // cur_ID and cur_username used in like, delete and verify
    if ($data->is_logged_in()) {
        $return .= '<form class="comment-form comment theme-main-color-1">';
        $return .= '<input class="comment-title theme-main-color-1" name="title" placeholder="' . $text->get("comments-title") . '">';
        $return .= '<h3 class="comment-author theme-main-color-1">' . $data->get_username_by_id($_SESSION["userId"]) . '</h3>';
        $return .= '<textarea class="comment-text theme-main-color-1" name="text" placeholder="' . $text->get("comments-comment") . '"></textarea>';
        $return .= '<input type="submit" name="submit" class="comment-form-submit theme-main-color-1" id="submit-comment" value="' . $text->get("comments-submit") . '">';
        $return .= '</form>
        <script>var cur_Id = "' . $mode . '=' . $id . '";</script>
        <script>var cur_username = "' . $_SESSION["user"] . '";</script>
        <script async defer src="/forum/assets/script/comment.js"></script>
        <div id="js_comments"></div>
        ';
    } else {
        $return .= '<script>var cur_Id = "' . $mode . '=' . $id . '";</script>
        <script>var cur_username = false;</script>
        <script async defer src="/forum/assets/script/comment.js"></script>
        <div id="js_comments"></div>';
    }
    
    
    
    $return .= '
    </div>
    ';
    return $return;
}