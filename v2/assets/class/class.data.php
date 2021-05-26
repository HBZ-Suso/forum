<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";


class DataV2 extends Data {
    public function get_categories () {
        return array("Home", "About", "Discussion", "Projects", "Help");
    }

    public function get_articleIds_by_category ($category, $limit=100000)
    {
        $query = '
        SELECT articleId, articleTitle, userId
        FROM articles
        WHERE articleCategory=?
        ORDER BY articleCreated DESC
        LIMIT 0, 
        ?;
        ';
        $stmt = $this->connId->prepare($query);
        $stmt->bind_param("si", $category, $limit);
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
}