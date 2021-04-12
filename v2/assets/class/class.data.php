<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/forum/assets/class/class.data.php";


class DataV2 extends Data {
    public function get_categories () {
        return array("Home", "About", "Discussion", "Projects", "Help");
    }
}