<?php 

class Data
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

    private function create_error ($er)
    {
        @$ef = file_get_contents($_SERVER["DOCUMENT_ROOT"] . self::$errorFile);
        if ($ef) {
            $ef = json_decode($ef, true);
            array_push($ef, $er);
            file_put_contents(self::$errorFile, json_encode($ef));
        }
    }

    private function connect ()
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





    // -----------------------------------------------------------------------------------------------------






    public function check_entry_exists ($tableName, $columnName, $entry) {
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


    public function create_user ($username, $password, $age, $employment, $description, $mail, $phone, $settings, $type, $intended)
    {
        if ($this->check_entry_exists("users", "userName", $username)) {
            return false;
        }

        $query = "INSERT INTO users (userName, userPassword, userAge, userEmployment, userDescription, userMail, userPhone, userSettings, userType, userIntended) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ssisssssss", $username, password_hash($password, PASSWORD_DEFAULT), $age, $employment, $description, $mail, $phone, json_encode($settings), $type, $intended);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function create_article ($userId, $title, $text, $tags)
    {
        if ($this->check_entry_exists("articles", "articleTitle", $title)) {
            return false;
        }

        $query = "INSERT INTO articles (userId, articleTitle, articleText, articleTags) VALUES (?, ?, ?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("isss", $userId, $title, $text, json_encode($tags));
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function execute_like ($userId, $articleId)
    {
        $query = "SELECT likeId FROM likes WHERE articleId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $articleId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            $query = "DELETE FROM likes WHERE articleId=? AND userId=?;";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $articleId, $userId);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            $query = "INSERT INTO likes (userId, articleId) VALUES (?, ?);";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("ii", $userId, $articleId);
            $stmt->execute();
            $stmt->close();
            return true;
        }
    }


    public function create_view ($userId, $articleId)
    {
        $query = "SELECT * FROM views WHERE articleId=? AND userId=?;";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $articleId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            return false;
        }

        $query = "INSERT INTO views (userId, articleId) VALUES (?, ?);";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function delete_article_by_id ($articleId)
    {

        $query = "DELETE FROM articles WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $articleId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function delete_user_by_id ($userId)
    {

        $query = "DELETE FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
        return true;
    }



    public function check_login ($username, $password)
    {
        if (!$this->check_entry_exists("users", "userName", $username)) {
            return false;
        }

        $query = "SELECT userPassword FROM users WHERE userName='" . $username . "'";
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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


    public function get_article ($articleId) 
    {
        if (!$this->check_entry_exists("articles", "articleId", $articleId)) {
            return false;
        }

        $query = "SELECT * FROM articles WHERE articleId=" . $articleId;
        $result = $this->connId->query($query);

        while($row = $result->fetch_assoc()) {
            return $row;
        }

        return false;
    }


    public function is_admin_by_id ($userId)
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


    public function search_articles ($phrase, $max=100, $mode = ["articleTitle", "articleTags", "articleText"], $order="articleCreated DESC") 
    {
        $return = array();
        foreach($mode as $value) {
            $query = "SELECT * FROM articles WHERE " . $value . " LIKE ? ORDER BY " . $order . " LIMIT " . $max . ";";
            $query_phrase = "%" . $phrase . "%";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("s", $query_phrase);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (!in_array($row, $return)) {
                        array_push($return, $row);
                    }
                }
            }
        }
        if (count($return) >= 1) {
            return $return;
        } else {
            return false;
        }
    }


    public function search_users ($phrase, $max=100, $mode = ["userName", "userDescription", "userMail", "userPhone", "userEmployment"], $order="userCreated DESC")
    {   
        $return = array();
        foreach($mode as $value) {
            $query = "SELECT * FROM users WHERE " . $value . " LIKE ? ORDER BY " . $order . " LIMIT " . $max . ";";
            $query_phrase = "%" . $phrase . "%";
            $stmt = $this->connId->prepare($query);
            $stmt->bind_param("s", $query_phrase);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if (!in_array($row, $return)) {
                        array_push($return, $row);
                    }
                }
            }
        }
        if (count($return) >= 1) {
            return $return;
        } else {
            return false;
        }
    }


    public function get_user_by_id ($id) 
    {
        $query = "SELECT * FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", intval($id));
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
        return false;
    }


    public function get_article_by_id ($id) 
    {
        $query = "SELECT * FROM articles WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", intval($id));
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row;
            }
        } else {
            return false;
        }
        return false;
    }



    public function get_username_by_id ($code) 
    {
        $query = "SELECT userName FROM users WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $code);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                return $row["userName"];
            }
        } else {
            return false;
        }
        return false;
    }


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
    }



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
    }



    public function get_article_views_by_article_id ($id) 
    {
        $query = "SELECT viewId FROM views WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_likes_by_article_id ($id) 
    {
        $query = "SELECT likeId FROM likes WHERE articleId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_views_by_user_id ($id) 
    {
        $query = "SELECT viewId FROM views WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function get_article_likes_by_user_id ($id) 
    {
        $query = "SELECT likeId FROM likes WHERE userId=?";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows;
    }


    public function check_if_article_liked_by_user ($userId, $articleId) 
    {
        $query = "SELECT likeId FROM likes WHERE userId=? AND articleId=?";
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


    public function use_code ($code) 
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
            while($row = $result->fetch_assoc()) {
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

}