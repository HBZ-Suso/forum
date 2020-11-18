<?php 

class Data
{
    /*
    URL of config file
    */
    public $configFile;

    /*
    URL of error file
    */
    public $errorFile;


    public $connId;

    /*
    Konstruktor für das automatische Verbinden bei Instanzierung
    */
    public function __construct()
    {
        $this->errorFile = $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/data/sql_error.json";
        $this->connect();
    }

    private function create_error ($er)
    {
        @$ef = file_get_contents($this->errorFile);
        if ($ef) {
            $ef = json_decode($ef, true);
            array_push($ef, $er);
            file_put_contents($this->errorFile, json_encode($ef));
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
        $con = $this->connId = mysqli_connect("localhost","forum", "forum", "forum");

        
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
        $query = "SELECT " . $columnName . " FROM " . $tableName . " WHERE " . $columnName . "='" . $entry . "'";
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function create_user ($username, $password, $age, $employment, $description, $mail, $phone, $settings)
    {
        if ($this->check_entry_exists("users", "userName", $username)) {
            return false;
        }

        $query = "INSERT INTO users (userName, userPassword, userAge, userEmployment, userDescription, userMail, userPhone, userSettings) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ssisssss", $username, password_hash($password, PASSWORD_DEFAULT), $age, $employment, $description, $mail, $phone, json_encode($settings));
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


    public function create_like ($userId, $articleId)
    {
        $query = "SELECT likeId FROM likes WHERE articleId=" . $articleId . " AND userId=" . $userId;
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            return false;
        }

        $query = "INSERT INTO likes (userId, articleId) VALUES (?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
        $stmt->execute();
        $stmt->close();
        return true;
    }


    public function create_view ($userId, $articleId)
    {
        $query = "SELECT viewId FROM views WHERE articleId=" . $articleId . " AND userId=" . $userId;
        $result = $this->connId->query($query);
        if ($result->num_rows > 0) {
            return false;
        }


        $query = "INSERT INTO views (userId, articleId) VALUES (?, ?)";
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("ii", $userId, $articleId);
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


    public function search_articles ($phrase, $max=100) 
    {
        $query = "SELECT * FROM articles WHERE articleName='%" . $phrase . "%' LIMIT " . $max;
        $result = $this->connId->query($query);
        $return = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                array_push($return, $row);
            }
            return $return;
        } else {
            return array();
        }
        return array();
    }



}