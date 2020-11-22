<?php 
session_start();
$require_purifier = true;
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.main.php";

if (isset($_GET["show"])) {
    switch ($_GET["show"]) {
        case "account":
            if (isset($_SESSION["user"])) {
                header("LOCATION:/forum/assets/site/account.php");
            } else {
                header("LOCATION:/forum/assets/site/login.php");
            }
            break;
        case "about":
            exit("Not coded yet ;-)");
            break;
    }
}




if (isset($_GET["search"]) || (!isset($_GET["show"]) && !isset($_GET["userId"]) && !isset($_GET["userName"]) && !isset($_GET["articleId"]) && !isset($_GET["articleTitle"]))) {
    if ($info->mobile === false) {

        if (isset($_GET["search"]) || isset($_GET["rsearch"])) {
            $args = ["title", "text", "author", "name", "mail", "description", "phone", "employment"];
            $set = [];
            foreach($args as $value) {
                if (isset($_GET[$value])) {
                    $set[$value] = "checked";
                } else {
                    $set[$value] = "";
                }
            }

            if (isset($_GET["search"])) {
                $search = $_GET["search"];
            } else {
                $search = $_GET["rsearch"];
            }


            echo '
                <form action="/forum/?rsearch=true" method="get" class="refined-search">
                    <input type="text" name="rsearch" autocomplete="off" value="' . $search . '"  class="refined-search-text">
                    <input type="submit" class="refined-search-submit" value="->"><br>

                    <table class="refined-search-table">
                        <tr>
                            <th><label for="title" class="refined-search-label">Title</label></th>
                            <th><label for="text" class="refined-search-label">Text</label></th>
                            <!--<th><label for="author" class="refined-search-label">Author</label></th>-->
                            <th><label for="info class="refined-search-label">|</label></th>
                            <th><label for="title" class="refined-search-label">Name</label></th>
                            <th><label for="text" class="refined-search-label">Mail</label></th>
                            <th><label for="title" class="refined-search-label">Description</label></th>
                            <th><label for="text" class="refined-search-label">Phone</label></th>
                            <th><label for="text" class="refined-search-label">Employment</label><br></th>
                        </tr>
                        <tr>
                            <td><div class="checkbox-div" id="1"><input type="checkbox" name="title" ' . $set["title"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <td><div class="checkbox-div" id="2"><input type="checkbox" name="text" ' . $set["text"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <!--<td><div class="checkbox-div" id="3"><input type="checkbox" name="author" ' . $set["author"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>-->
                            <td><p></p></td>
                            <td><div class="checkbox-div" id="4"><input type="checkbox" name="name" ' . $set["name"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <td><div class="checkbox-div" id="5"><input type="checkbox" name="mail" ' . $set["mail"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <td><div class="checkbox-div" id="6"><input type="checkbox" name="description" ' . $set["description"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <td><div class="checkbox-div" id="7"><input type="checkbox" name="phone" ' . $set["phone"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                            <td><div class="checkbox-div" id="8"><input type="checkbox" name="employment" ' . $set["employment"] . ' autocomplete="off" class="refined-search-checkbox"></div></td>
                        </tr>
                    </table>
                </form>   
            ';
        
            for ($i = 1; $i < 9; $i++) {
                echo '
                <script>
                    document.getElementById("' . $i . '").addEventListener("click", event => {
                        if (document.getElementById("' . $i . '").children[0].checked) {
                            document.getElementById("' . $i . '").style.backgroundColor = "#0D3326";
                        } else {
                            document.getElementById("' . $i . '").style.backgroundColor = "";
                        }
                    });
                    if (document.getElementById("' . $i . '").children[0].checked) {
                        document.getElementById("' . $i . '").style.backgroundColor = "#0D3326";
                    } else {
                        document.getElementById("' . $i . '").style.backgroundColor = "";
                    }
                </script>';
            }

            $top = " big-top";
        } else {
            $top = "";
        }


        echo '<link rel="stylesheet" href="/forum/assets/style/pc.findings.css">';

        echo '<div class="block-container' . $top . '">
            <div class="article-block block">
                <h1 class="article-block-heading block-heading">Articles</h1>';
                
        if (isset($_GET["search"])) {
            $phrase = $_GET["search"];
        } else {
            $phrase = "";
        }

        if (isset($_GET["rsearch"])) {
            $mode_list = array();

            if (isset($_GET["title"])) {
                array_push($mode_list, "articleTitle");
            }
            if (isset($_GET["text"])) {
                array_push($mode_list, "articleText");
            }
            if (isset($_GET["author"])) {
                array_push($mode_list, "userId");
            }
            
            $article_list = $data->search_articles($_GET["rsearch"], 100, $mode_list);
        } else {
            $article_list = $data->search_articles($phrase);
        }

        foreach ($article_list as $value) {
            if (isset($_SESSION["userId"]) && ($_SESSION["userId"] === $value["userId"])) {
                $self = " owned";
            } else {
                $self = "";
            }

            echo '
                <div class="article-block-entry block-entry' . $self . '" id="article_' . $value["articleId"] . '">
                    <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . $value["articleTitle"] .'</span><br>
                    <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">Author: </p>' . $data->get_username_by_id($value["userId"]) .'</span>
                    <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Views: </p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
                    <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
                </div>

                <script>
                    document.getElementById("article_' . $value["articleId"] . '").addEventListener("click", (e) => {
                        window.location = "/forum/?articleId=' . $value["articleId"] . '&articleTitle=' . $value["articleTitle"] . '";
                    })
                </script>
            ';
        }

        echo '</div>
        ';






        echo '
            <div class="user-block block">
                <h1 class="user-block-heading block-heading">Users</h1>';
                
        if (isset($_GET["search"])) {
            $phrase = $_GET["search"];
        } else {
            $phrase = "";
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

            $user_list = $data->search_users($_GET["rsearch"], 100, $mode_list);
        } else {
            $user_list = $data->search_users($phrase);
        }

        

        foreach ($user_list as $value) {
            if (isset($_SESSION["userId"]) && ($_SESSION["userId"] === $value["userId"])) {
                $self = " owned";
            } else {
                $self = "";
            }

            echo '
                <div class="user-block-entry block-entry' . $self . '" user_id="' . $value["userId"] . '" user_name="' . $value["userName"] . '"  id="user_' . $value["userId"] . '">
                    <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . $value["userName"] .'</span><br>
                    <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">Mail: </p>' . $value["userMail"] .'</span>
                    <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Views: </p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
                    <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
                </div>

                <script>
                    document.getElementById("user_' . $value["userId"] . '").addEventListener("click", (e) => {
                        window.location = "/forum/?userId=' . $value["userId"] . '&userName=' . $value["userName"] . '";
                    })
                </script>
            ';
        }

        echo '</div>
        ';

        if (isset($_SESSION["userId"])) {
            echo '
                <div class="highlights-block block">
                    <h1 class="highlights-block-heading block-heading">Highlights</h1>';
                    
            if (isset($_GET["search"])) {
                $phrase = $_GET["search"];
            } else {
                $phrase = "";
            }
            
            $highlight_data = $data->get_highlights_by_user_id($_SESSION["userId"]);

            //echo json_encode($highlight_data);

            foreach ($highlight_data as $value) {
                if (isset($_SESSION["userId"]) && ($_SESSION["userId"] === $value["userId"])) {
                    $self = " owned";
                } else {
                    $self = "";
                }

                

                if (isset($value["articleId"])) {
                    echo '
                        <div class="article-block-entry block-entry' . $self . '" id="highlights_' . $value["articleId"] . '">
                            <span class="article-block-entry-element block-entry-element article-title"><p class="article-title-heading article-block-entry-heading block-entry-heading"></p>' . $value["articleTitle"] .'</span><br>
                            <span class="article-block-entry-element block-entry-element article-author"><p class="article-author-heading article-block-entry-heading block-entry-heading">Author: </p>' . $data->get_username_by_id($value["userId"]) .'</span>
                            <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Views: </p>' . $data->get_article_views_by_article_id($value["articleId"]) .'</span>
                            <span class="article-block-entry-element block-entry-element article-views"><p class="article-views-heading article-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_article_likes_by_article_id($value["articleId"]) .'</span><br>
                        </div>

                        <script>
                            document.getElementById("highlights_' . $value["articleId"] . '").addEventListener("click", (e) => {
                                window.location = "/forum/?articleId=' . $value["articleId"] . '&articleTitle=' . $value["articleTitle"] . '";
                            })
                        </script>
                    ';
                } else if (isset($value["userId"])) {
                    echo '
                    <div class="highlights-block-entry block-entry' . $self . '" id="highlights_' . $value["userId"] . '">
                        <span class="user-block-entry-element block-entry-element user-name"><p class="user-name-heading user-block-entry-heading block-entry-heading"></p>' . $value["userName"] .'</span><br>
                        <span class="user-block-entry-element block-entry-element user-mail"><p class="user-mail-heading user-block-entry-heading block-entry-heading">Mail: </p>' . $value["userMail"] .'</span>
                        <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Views: </p>' . $data->get_user_views_by_targetUserId($value["userId"]) .'</span>
                        <span class="user-block-entry-element block-entry-element user-views"><p class="user-views-heading user-block-entry-heading block-entry-heading">Likes: </p>' . $data->get_user_likes_by_targetUserId($value["userId"]) .'</span><br>
                    </div>

                    <script>
                        document.getElementById("highlights_' . $value["userId"] . '").addEventListener("click", (e) => {
                            window.location = "/forum/?userId=' . $value["userId"] . '&userName=' . $value["userName"] . '";
                        })
                    </script>
                ';
                }

                
            }

            echo '</div>
            ';
        }

        echo "</div>";
    }
} else if (isset($_GET["userId"]) || isset($_GET["userName"])) {
    if (isset($_GET["userId"])) {
        $userId = $_GET["userId"];
        if (isset($_GET["userName"]) && intval($data->get_id_by_username($_GET["userName"])) !== intval($_GET["userId"])) {
            header("LOCATION:/forum/?error=requesterror");
            die("Requesterror");
        }
    } else {
        $userId = intval($data->get_id_by_username($_GET["userName"]));
    }

    $user_data = $data->get_user_by_id($userId);
    if ($user_data === false) {
        header("LOCATION:/forum/?error=notexistentuser");
        die("This user does not exist");
    }


    if (isset($_SESSION["userId"])) {
        $data->create_user_view($_SESSION["userId"], $userId);
        if ($data->check_if_user_liked_by_user($_SESSION["userId"], $userId)) {
            $liked = " liked";
        } else {
            $liked = "";
        }
    }



    if (isset($_SESSION["userId"]) && (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($_SESSION["userId"])) || intval($userId) === intval($_SESSION["userId"]))) {
        $delete_button = '<div class="delete-user">Delete</div>
        <script>document.querySelector(".delete-user").addEventListener("click", (e) => {window.location = "/forum/assets/site/delete.php?userId=' . $userId . '&refer=/forum/";})</script>';
    } else {
        $delete_button = "";
    }



    echo '
    <link rel="stylesheet" href="/forum/assets/style/pc.user.css">

    <div class="user-block">
        <div class="like-user ' . $liked . '">Like</div>
        ' . $delete_button . '
        <textarea disabled class="user-block-entry user-block-title user-type-' . $user_data["userType"] . '">' . $user_data["userName"] . '</textarea>
        <textarea disabled class="user-block-entry user-block-employment">Employment: ' . $user_data["userEmployment"] . '</textarea>
        <textarea disabled class="user-block-entry user-block-age">Age: ' . $user_data["userAge"] . '</textarea>
        <textarea disabled class="user-block-entry user-block-mail">Mail: ' . $user_data["userMail"] . '</textarea>
        <textarea disabled class="user-block-entry user-block-phone">Phone: ' . $user_data["userPhone"] . '</textarea>
    
    
        <textarea disabled class="user-block-description">' . $user_data["userDescription"] . '</textarea>
    </div>

    <script>document.querySelector(".like-user").addEventListener("click", (e) => {window.location = "/forum/assets/site/like.php?targetUserId=' . $userId . '&refer=/forum/?userId=' . $userId . '";})</script>
    ';


} else if (isset($_GET["articleId"]) || isset($_GET["articleTitle"])) {


    if (isset($_GET["articleId"])) {
        $articleId = $_GET["articleId"];
        if (isset($_GET["articleTitle"]) && intval($data->get_id_by_articletitle($_GET["articleTitle"])) !== intval($_GET["articleId"])) {
            header("LOCATION:/forum/?error=requesterror");
            die("Requesterror");
        }
    } else {
        $articleId = intval($data->get_id_by_articletitle($_GET["articleTitle"]));
    }

    $article_data = $data->get_article_by_id($articleId);
    if ($article_data === false) {
        header("LOCATION:/forum/?error=notexistentarticle");
        die("This article does not exist");
    }

    if (isset($_SESSION["userId"])) {
        $data->create_article_view($_SESSION["userId"], $articleId);
        if ($data->check_if_article_liked_by_user($_SESSION["userId"], $articleId)) {
            $liked = " liked";
        } else {
            $liked = "";
        }
    }
    
    
    if (isset($_SESSION["userId"]) && (($data->is_admin_by_id($_SESSION["userId"]) && !$data->is_admin_by_id($article_data["userId"])) || $_SESSION["userId"] === $article_data["userId"])) {
        $delete_button = '<div class="delete-article">Delete</div>
        <script>document.querySelector(".delete-article").addEventListener("click", (e) => {window.location = "/forum/assets/site/delete.php?articleId=' . $articleId . '&refer=/forum/";})</script>';
    } else {
        $delete_button = "";
    }

    // USE VARIABLE TO REDUCE QUERY AMOUNT
    $try_author_name = $data->get_username_by_id($article_data["userId"]);

    if ($try_author_name && $try_author_name !== "") {
        $author = "Author: " . $try_author_name;
    } else {
        $author = "The author of this article was deleted...";
    }

    echo '
    <link rel="stylesheet" href="/forum/assets/style/pc.article.css">

    

    <div class="article-block">
        <div class="like-article ' . $liked . '">Like</div>
        ' . $delete_button . '
        <textarea disabled class="article-block-entry article-block-title">' . $article_data["articleTitle"] . '</textarea>
        <textarea disabled class="article-block-entry article-block-author">' . $author . '</textarea>
        <textarea disabled class="article-block-entry article-block-tags">Tags: ' . implode("; ", json_decode($article_data["articleTags"])) . '</textarea>
        <textarea disabled class="article-block-entry article-block-created">Created: ' . $article_data["articleCreated"] . '</textarea>
    
        <textarea disabled class="article-block-content">' . $article_data["articleText"] . '</textarea>
    </div>



    <script>document.querySelector(".like-article").addEventListener("click", (e) => {window.location = "/forum/assets/site/like.php?articleId=' . $articleId . '&refer=/forum/?articleId=' . $articleId . '";})</script>
    ';

}