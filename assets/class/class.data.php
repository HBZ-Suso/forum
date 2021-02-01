<?php

class Connector
{
    /*
    URL of config file
    */
    public static $configFile = "/forum/assets/data/credentials.json";

    /*
    URL of error file
    */
    public static $errorFile = "/forum/assets/data/sql_error.json";


    public $connId;

    /*
    Konstruktor für das automatische Verbinden bei Instanzierung
    */
    public function __construct()
    {
        $this->connect();
    }

    private function create_error($er)
    {
        @$ef = file_get_contents($_SERVER["DOCUMENT_ROOT"] . self::$errorFile);
        if ($ef) {
            $ef = json_decode($ef, true);
            array_push($ef, $er);
            file_put_contents(self::$errorFile, json_encode($ef));
        }
    }

    private function connect()
    {
        $reporting = error_reporting(0);

        if (!function_exists('mysqli_connect')) {
            printf("Connection to database failed, MySqli not enabled.");
            $this->create_error("Connection to database failed, MySqli not enabled." . date("d:m:Y"));
            die("Connection to database failed, MySqli not enabled.");
            return;
        }


        /* Verbindung aufnehmen */
        $credentials = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . self::$configFile), true);
        $con = $this->connId = mysqli_connect($credentials["address"], $credentials["user"], $credentials["password"], "forum");


        if ($con->connect_errno) {
            printf("Connection to database failed: %s\n", $con->connect_error);
            $this->create_error("Error whilst trying to connect to database, error:" . $con->connect_errno . " " . date("d:m:Y"));
            die("Connection to database failed");
        }
    }

    public function close()
    {
        mysqli_close($this->connId);
    }
}



// -----------------------------------------------------------------------------------------------------




class Data extends Connector
{

    public function check_entry_exists($tableName, $columnName, $entry)
    {
        $query = "SELECT " . $columnName . " FROM " . $tableName . " WHERE " . $columnName . "=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $entry);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function create_user($username, $password, $age, $employment, $description, $mail, $phone, $settings, $type, $intended)
    {
        if ($this->check_entry_exists("users", "userName", $username)) {
            return false;
        }

        $time = time();
        $query = "INSERT INTO users (userName, userPassword, userAge, userEmployment, userDescription, userMail, userPhone, userSettings, userType, userIntended, userVerified, userLastArticle, userLastComment, userLocked) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connId->prepare($query);
        $verify = "0";
        $settings_encoded = json_encode($settings);
        $stmt->bind_param("ssisssssssssis", $username, password_hash($password, PASSWORD_DEFAULT), $age, $employment, $description, $mail, $phone, $settings_encoded, $type, $intended, $verify, $time, $time, $verify); // SECOND VERIFY INSTEAD OF NEW VAR LOCKED
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row;
                exit();
            }
        } else {
            return true;
        }
        $stmt->close();
        return true;
    }


    public function create_article($userId, $title, $text, $tags)
    {
        if ($this->check_entry_exists("articles", "articleTitle", $title)) {
            return false;
        }

        $query = "INSERT INTO articles (userId, articleTitle, articleText, articleTags) VALUES (?, ?, ?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("isss", $userId, $title, $text, json_encode($tags));
        $stmt->execute();
        $stmt->close();

        $time = time();
        $query = "UPDATE users SET userLastArticle=? WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ss", $time, $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function execute_article_like($userId, $articleId)
    {
        $query = "SELECT likeId FROM articleLikes WHERE articleId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $articleId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $query = "DELETE FROM articleLikes WHERE articleId=? AND userId=?;";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $articleId, $userId);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            $query = "INSERT INTO articleLikes (userId, articleId) VALUES (?, ?);";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $userId, $articleId);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }


    public function execute_user_like($userId, $targetUserId)
    {
        $query = "SELECT likeId FROM userLikes WHERE targetUserId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $targetUserId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $query = "DELETE FROM userLikes WHERE targetUserId=? AND userId=?;";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $targetUserId, $userId);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            $query = "INSERT INTO userLikes (userId, targetUserId) VALUES (?, ?);";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $userId, $targetUserId);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }



    public function execute_verify_by_user_id($userId)
    {
        $query = "SELECT * FROM users WHERE userId=? AND userVerified=?";
        $stmt = $this->connId->prepare($query);
        $set = "1";
        $stmt->bind_param("ss", $userId, $set);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $set = "0";
        }

        $query = "UPDATE users SET userVerified=? WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ss", $set, $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function create_article_view($userId, $articleId)
    {
        $query = "SELECT * FROM articleViews WHERE articleId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $articleId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return false;
        }

        $query = "INSERT INTO articleViews (userId, articleId) VALUES (?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function create_user_view($userId, $targetUserId)
    {
        $query = "SELECT * FROM userViews WHERE targetUserId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $targetUserId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return false;
        }

        $query = "INSERT INTO userViews (userId, targetUserId) VALUES (?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $targetUserId);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function delete_article_by_id($articleId)
    {

        $query = "DELETE FROM articles WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function delete_user_by_id($userId)
    {

        $query = "DELETE FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function check_login($username, $password)
    {
        if (!$this->check_entry_exists("users", "userName", $username)) {
            return false;
        }

        $query = "SELECT userPassword FROM users WHERE userName=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row["userPassword"])) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }

        return false;
    }


    public function check_login_by_Id($userId, $password)
    {
        $query = "SELECT * FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows <= 0) {
            return false;
        }
        $stmt->close();


        $query = "SELECT userPassword FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if (password_verify($password, $row["userPassword"])) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }

        return false;
    }


    public function is_admin_by_id($userId)
    {
        $query = "SELECT userType FROM users WHERE  userId=? AND userType='administrator';";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }


    public function is_moderator_by_id ($userId)
    {
        $query = "SELECT userType FROM users WHERE  userId=? AND userType='moderator';";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }


    public function search_articles($phrase, $min = 1, $max = 100, $mode = ["articleTitle", "articleTags", "articleText"], $order = "articleCreated DESC")
    {
        if (strlen($phrase) || count($mode) < 1) {
            $q_str = ' WHERE ';
        }

        if (strlen($phrase) && in_array("articleTitle", $mode)) {
            $q_str .= "articleTitle LIKE ? ";
        }
        if (strlen($phrase) && in_array("articleTags", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "articleTags LIKE ? ";
        }
        if (strlen($phrase) && in_array("articleText", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "articleText LIKE ? ";
        }

        $query = '
        SELECT *
        FROM articles
        ' . $q_str . '
        ORDER BY ' . $order . '
        LIMIT ' . strval(round(intval($min))) . ', 
        ' . strval(round(intval($max))) . ';
        ';
        $stmt = $this->connId->prepare($query);
        $query_phrase = "%" . $phrase . "%";
       
        if (count($mode) === 1) {
            $stmt->bind_param("s", $query_phrase);
        } else if (count($mode) === 2) {
            $stmt->bind_param("ss", $query_phrase, $query_phrase);
        } else if (count($mode) === 3) {
            $stmt->bind_param("sss", $query_phrase, $query_phrase, $query_phrase);
        }

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


    public function get_highlights_by_user_id($userId, $min = 0, $max = 25)
    {
        if (!is_numeric($userId)) {
            exit("Mysqli not numeric value error.");
        }
        
        /*$query = "
            (
                SELECT 
                    targetUserId, 
                    likeCreated,
                    userId
                FROM userLikes 
            )
        JOIN
            (
                SELECT 
                    articleId AS Id, 
                    likeCreated,
                    userId
                FROM articleLikes 
        
        ORDER BY likeCreated desc;";

        
        $highlighted = [];
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            array_push($highlighted, $row);
        }

        echo json_encode($highlighted);*/

        $highlighted = [];
        $query = "SELECT articleId, likeCreated FROM articleLikes WHERE userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            array_push($highlighted, $row);
        }

        $query = "SELECT targetUserId, likeCreated FROM userLikes WHERE userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            array_push($highlighted, $row);
        }

        usort($highlighted, function($a, $b)
        {
            return strcmp($a["likeCreated"], $b["likeCreated"]);
        });

        if (count($highlighted) > 0) {
            $return = [];

            foreach ($highlighted as $value) {
                if (isset($value["articleId"])) {
                    $fetch = $value["articleId"];
                    $content = $this->get_article_by_id($fetch);
                    if ($content !== false) {
                        array_push($return, $this->get_article_by_id($fetch));
                    }
                } else if (isset($value["targetUserId"])) {
                    $fetch = $value["targetUserId"];
                    $content = $this->get_user_by_id($fetch);
                    if ($content !== false) {
                        array_push($return, $this->get_user_by_id($fetch));
                    }
                }
            }
            $return = array_slice($return, $min, $max);
            return $return;
        }

        return false;
    }


    public function search_users($phrase, $min=0, $max=100, $mode = ["userName", "userDescription", "userMail", "userPhone", "userEmployment"], $order = "userCreated DESC")
    {
        if (strlen($phrase) || count($mode) < 1) {
            $q_str = ' WHERE ';
        }

        if (strlen($phrase) && in_array("userName", $mode)) {
            $q_str .= "userName LIKE ? ";
        }
        if (strlen($phrase) && in_array("userDescription", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "userDescription LIKE ? ";
        }
        if (strlen($phrase) && in_array("userMail", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "userMail LIKE ? ";
        }
        if (strlen($phrase) && in_array("userPhone", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "userPhone LIKE ? ";
        }
        if (strlen($phrase) && in_array("userEmployment", $mode)) {
            if (count($mode) > 1) {
                $q_str .= "OR ";
            }
            $q_str .= "userEmployment LIKE ? ";
        }

        $query = '
        SELECT *
        FROM users
        ' . $q_str . '
        ORDER BY ' . $order . '
        LIMIT ' . strval(intval($min)) . ', 
        ' . strval(intval($max)) . ';
        ';
        $stmt = $this->connId->prepare($query);
        $query_phrase = "%" . $phrase . "%";
        if (count($mode) === 1) {
            $stmt->bind_param("s", $query_phrase);
        } else if (count($mode) === 2) {
            $stmt->bind_param("ss", $query_phrase, $query_phrase);
        } else if (count($mode) === 3) {
            $stmt->bind_param("sss", $query_phrase, $query_phrase, $query_phrase);
        } else if (count($mode) === 4) {
            $stmt->bind_param("ssss", $query_phrase, $query_phrase, $query_phrase, $query_phrase);
        } else if (count($mode) === 5) {
            $stmt->bind_param("sssss", $query_phrase, $query_phrase, $query_phrase, $query_phrase, $query_phrase);
        }

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


    public function get_user_by_id($id)
    {
        $query = "SELECT * FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
        return false;
    }


    public function get_article_by_id($id)
    {
        $query = "SELECT * FROM articles WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
        return false;
    }



    public function get_username_by_id($code)
    {
        $query = "SELECT userName FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["userName"];
            }
        } else {
            return false;
        }
        return false;
    }


    public function get_user_id_by_name($name)
    {
        $query = "SELECT userId FROM users WHERE userName=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["userId"];
            }
        } else {
            return false;
        }
        return false;
    }

    /* DEPRECATED, use get_user_id_by_name
    public function get_id_by_username ($username) 
    {
        $query = "SELECT userId FROM users WHERE userName=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return intval($row["userId"]);
            }
        } else {
            return false;
        }
        return false;
    }*/


    public function get_article_id_by_title($title)
    {
        $query = "SELECT articleId FROM articles WHERE articleTitle=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return intval($row["articleId"]);
            }
        } else {
            return false;
        }
        return false;
    }


    /* DEPRECATED, use get_article_id_by_title
    public function get_id_by_articletitle ($title) 
    {
        $query = "SELECT articleId FROM articles WHERE articleTitle=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return intval($row["articleId"]);
            }
        } else {
            return false;
        }
        return false;
    }*/



    public function get_article_views_by_article_id($id)
    {
        $query = "SELECT viewId FROM articleViews WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_likes_by_article_id($id)
    {
        $query = "SELECT likeId FROM articleLikes WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_user_likes_by_targetUserId($userId)
    {
        $query = "SELECT likeId FROM userLikes WHERE targetUserId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_user_views_by_targetUserId($userId)
    {
        $query = "SELECT viewId FROM userViews WHERE targetUserId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_user_likes_by_user_Id($userId)
    {
        $query = "SELECT likeId FROM userLikes WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_user_views_by_user_Id($userId)
    {
        $query = "SELECT viewId FROM userViews WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_views_by_user_id($id)
    {
        $query = "SELECT viewId FROM articleViews WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_likes_by_user_id($id)
    {
        $query = "SELECT likeId FROM articleLikes WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function check_if_article_liked_by_user($userId, $articleId)
    {
        $query = "SELECT likeId FROM articleLikes WHERE userId=? AND articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function check_if_user_liked_by_user($userId, $targetUserId)
    {
        $query = "SELECT likeId FROM userLikes WHERE userId=? AND targetUserId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $targetUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function use_code($code)
    {
        if (!$this->check_entry_exists("codes", "codeName", $code)) {
            return false;
        }


        $query = "SELECT * FROM codes WHERE codeName=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $type = array("type" => $row["codeType"], "intended" => $row["codeIntended"]);
            }
        } else {
            return false;
        }


        $query = "DELETE FROM codes WHERE codeName=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $stmt->close();
        return $type;
    }



    public function change_user_column_by_id_and_name($userId, $column, $change_to)
    {
        if (!(strtoupper($column) === "USERNAME" || strtoupper($column) === "USERID" || strtoupper($column) === "USERINTENDED" || strtoupper($column) === "USERLASTARTICLE" || strtoupper($column) === "USERTYPE" || strtoupper($column) === "USERCREATED" || strtoupper($column) === "USERLOCKED")) {
            return false;
        } else {
            $query = 'UPDATE users SET ' . $column . '=? WHERE userId=?';
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("si", $change_to, $userId);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }

    public function change_article_column_by_id_and_name($articleId, $column, $change_to)
    {
        if (!(strtoupper($column) === "ARTICLETEXT" || strtoupper($column) === "ARTICLETAGS" || strtoupper($column) === "ARTICLETITLE")) {
            return false;
        } else {
            $query = 'UPDATE articles SET ' . $column . '=? WHERE articleId=?';
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("si", $change_to, $articleId);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }


    public function toggle_user_lock ($userId, $set)
    {
        $query = 'UPDATE users SET userLocked=? WHERE userId=?';
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("si", $set, $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function get_user_lock ($userId) 
    {
        $query = "SELECT userLocked FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["userLocked"];
            }
        } else {
            return false;
        }
    }


    public function create_article_comment($userId, $articleId, $commentTitle, $commentText)
    {
        $query = "INSERT INTO articleComments (userId, articleId, commentTitle, commentText) VALUES (?, ?, ?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iiss", $userId, $articleId, $commentTitle, $commentText);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function create_user_comment($userId, $targetUserId, $commentTitle, $commentText)
    {
        $query = "INSERT INTO userComments (userId, targetUserId, commentTitle, commentText) VALUES (?, ?, ?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iiss", $userId, $targetUserId, $commentTitle, $commentText);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function delete_article_comment_by_id($commentId)
    {
        $query = "DELETE FROM articleComments WHERE commentID=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $stmt->close();
    }


    public function delete_user_comment_by_id($commentId)
    {
        $query = "DELETE FROM userComments WHERE commentID=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $stmt->close();
    }



    public function get_article_comments_by_id($articleId)
    {
        $query = "SELECT * FROM articleComments WHERE articleId=? ORDER BY commentCreated desc";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $return = [];
            while ($row = $result->fetch_assoc()) {
                array_push($return, $row);
            }
            return $return;
        } else {
            return false;
        }
    }



    public function get_user_comments_by_id($targetUserId)
    {
        $query = "SELECT * FROM userComments WHERE targetUserId=? ORDER BY commentCreated desc";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $targetUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $return = [];
            while ($row = $result->fetch_assoc()) {
                array_push($return, $row);
            }
            return $return;
        } else {
            return false;
        }
    }


    public function get_user_collaborators()
    {
        $query = "SELECT * FROM collaborators";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $return = [];
            while ($row = $result->fetch_assoc()) {
                array_push($return, $row);
            }
            return $return;
        } else {
            return false;
        }
    }


    public function get_user_comment_by_id($commentId)
    {
        $query = "SELECT * FROM userComments WHERE commentId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
    }


    public function get_article_comment_by_id($commentId)
    {
        $query = "SELECT * FROM articleComments WHERE commentId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
    }



    public function set_comment_timeout_by_id($userId)
    {
        $time = time();
        $query = "UPDATE users SET userLastComment=? WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ss", $time, $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function get_last_user_comment_id()
    {
        $query = "SELECT commentId FROM userComments ORDER BY commentId desc";
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["commentId"];
            }
        } else {
            return false;
        }
    }


    public function get_last_article_comment_id()
    {
        $query = "SELECT commentId FROM articleComments ORDER BY commentId desc";
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["commentId"];
            }
        } else {
            return false;
        }
    }


    public function add_password_change ($userId, $userIp)
    {
        $time = time();
        $query = "INSERT INTO passwordChanges (passwordChangeUserId, passwordChangeIp, passwordChangeDate) VALUES (?, ?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("iss", $userId, $userIp, $time);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function is_logged_in ()
    {
        if (!isset($_SESSION["user"]) || !isset($_SESSION["userId"])) {
            return false;
        } else if (strtoupper($this->get_user_by_id($_SESSION["userId"])["userName"]) !== strtoupper($_SESSION["user"])) {
            return false;
        } else {
            return true;
        }
    } // USAGE: $data->is_logged_in()
}
