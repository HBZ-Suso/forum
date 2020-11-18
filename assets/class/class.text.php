<?php 


class Text
{
    public static $language_file = "/forum/assets/data/languages.json";

    public function __construct ($language)
    {
        $this->language = $language;
    }

    public function get ($key)
    {
        return json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] .self::$language_file), true)[$this->language][$key];
    }

    public function gecho ($key) 
    {
        echo json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] .self::$language_file), true)[$this->language][$key];
    }
} 