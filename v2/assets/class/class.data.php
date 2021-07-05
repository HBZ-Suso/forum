<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";


class DataV2 extends Data {
    public function get_categories () {
        return array("Home", "About", "Discussion", "Projects", "Help");
    }

    public function get_articleIds_by_category ($category, $orderby="articleCreated", $dir="DESC", $start=0, $limit=100000)
    {
        if (!in_array($dir, ["DESC", "ASC"])) {
            $dir = "ASC";
        }
        if (!in_array($orderby, ["articleCreated", "articleId", "userId", "articleTitle", "articleText"])) {
            $orderby = "articleCreated";
        }
        $query = '
        SELECT articleId, articleTitle, userId, articleCreated, articlePinned
        FROM articles
        WHERE articleCategory=?
        ORDER BY ' . $orderby . ' ' . $dir . '
        LIMIT ?, 
        ?;
        ';
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("sii", $category, $start, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $return = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!in_array($row, $return)) {
                    array_push($return, array_merge($row, ["articleViews" => $this->get_article_views_by_article_id($row["articleId"]), "articleComments" => $this->get_article_comment_number_by_id($row["articleId"]), "articleLikes" => $this->get_article_likes_by_article_id($row["articleId"])]));
                }
            }
        }
        if (count($return) >= 1) {
            return $return;
        } else {
            return false;
        }
    }


    public function get_usernames () {
        $query = '
        SELECT userId, userName
        FROM users
        ORDER BY userId DESC;
        ';
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $return = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (!in_array($row, $return)) {
                    array_push($return, $row);
                }
            }
        }
        if (count($return) >= 1) {
            return $return;
        } else {
            return false;
        }
    }


    public function toggle_article_pin ($articleId) {
        if ($this->check_article_pin($articleId)) {
            $this->change_article_column_by_id_and_name($articleId, "articlePinned", 0);
        } else {
            $this->change_article_column_by_id_and_name($articleId, "articlePinned", 1);
        }
    }


    public function check_article_pin ($articleId) {
        $query = '
        SELECT articlePinned
        FROM articles
        WHERE articleId=?;
        ';
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return (strval($row["articlePinned"]) == "1");
            }
        }
    }


    public function add_log ($type, $text)
    {
        $time = time();
        $query = "INSERT INTO logs (matchKey, logType, logContent, logDate) VALUES (?, ?, ?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iisi", $this->matchKey, $type, $text, $time);
        $stmt->execute();
        $stmt->close();
        return true;
    }








    public function get_personal_data () {
        $data = [];

        $limit = 100000;

        $query = "SELECT * FROM logs WHERE matchKey=? ORDER BY logDate DESC LIMIT 0, ?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $this->matchKey, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, ["type" => "log", "match" => "matchKey", "data" => $row]);
            }
        }
        

        $query = "SELECT * FROM errors WHERE matchKey=? ORDER BY errorDate DESC LIMIT 0, ?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $this->matchKey, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, ["type" => "error", "match" => "matchKey", "data" => $row]);
            }
        }





        $query = "SELECT * FROM visits WHERE matchKey=? ORDER BY visitDate DESC LIMIT 0, ?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $this->matchKey, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, ["type" => "visit", "match" => "matchKey", "data" => $row]);
            }
        }




        
        $query = "SELECT * FROM reports WHERE matchKey=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $this->matchKey);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($data, ["type" => "report", "match" => "matchKey", "data" => $row]);
            }
        }




        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM archivedArticles WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "archivedArticle", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM articleComments WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "articleComment", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM articleLikes WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "articleLike", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM articles WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "article", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM articleViews WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "articleView", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM userComments WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "userComment", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM userLikes WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "userLike", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM users WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row["userPassword"] = "REDACTED - NORMALLY HASH";
                    array_push($data, ["type" => "user", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM userViews WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row["userPassword"] = "REDACTED - NORMALLY HASH";
                    array_push($data, ["type" => "userView", "match" => "userId", "data" => $row]);
                }
            }
        }

        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM notifications WHERE userId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "notification", "match" => "userId", "data" => $row]);
                }
            }
        }


        if ($this->is_logged_in()) {
            $userId = $_SESSION["userId"];
            $query = "SELECT * FROM settingChanges WHERE settingChangeUserId=?";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($data, ["type" => "settingChange", "match" => "userId", "data" => $row]);
                }
            }
        }

        
        return $data;
    }





    public function send_chat_message ($from, $to, $text) {
        $date = time();
        $Read = 0;
        $query = "INSERT INTO messages (messageFrom, messageTo, messageDate, messageText, messageRead) VALUES (?, ?, ?, ?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iiisi", $from, $to, $date, $text, $Read);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function get_chats_by_user_id ($userId) {
        $query = "SELECT messageTo, messageFrom FROM messages WHERE messageFrom=? OR messageTo=? ORDER BY messageDate ASC;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $authors = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (intval($row["messageFrom"]) === $userId){
                    if (!in_array($row["messageTo"], $authors)) {
                        array_push($authors, $row["messageTo"]);
                    }
                } else {
                    if (!in_array($row["messageFrom"], $authors)) {
                        array_push($authors, $row["messageFrom"]);
                    }
                }
            }
            return $authors;
        }
        return false;
    }



    public function get_chat_by_user_ids ($userId, $userTargetId) {
        $return = [];
        
        if (intval($userId) !== intval($userTargetId)) {
            $query = "SELECT * FROM messages WHERE messageFrom=? AND messageTo=? ORDER BY messageDate DESC LIMIT 0, 200;";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $userId, $userTargetId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (intval($row["messageFrom"]) === $userId){
                        $row["messageType"] = "outgoing";
                    } else {
                        $row["messageType"] = "incoming";
                    }
                    array_push($return, $row);
                }
            }
        }


        $query = "SELECT * FROM messages WHERE messageTo=? AND messageFrom=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $userTargetId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (intval($row["messageFrom"]) === $userId){
                    $row["messageType"] = "outgoing";
                } else {
                    $row["messageType"] = "incoming";
                }
                array_push($return, $row);
            }
        }
        return $return;
    }




    public function get_last_message_by_user_id ($userId, $userTargetId) {
        $query = "SELECT * FROM messages WHERE (messageFrom=? OR messageTo=?) AND (messageFrom=? OR messageTo=?) ORDER BY messageDate DESC LIMIT 0, 1;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iiii", $userId, $userId, $userTargetId, $userTargetId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
        return false;
    }



    public function read_message ($messageId) {
        $query = "UPDATE messages SET messageRead=1 WHERE messageId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $messageId);
        $stmt->execute();
        $stmt->close();
    }



    public function message_is_for ($userId, $messageId) {
        $query = "SELECT * FROM messages WHERE messageId=? AND messageTo=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $messageId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }
}