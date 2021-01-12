<?php 


class Text
{
    public static $language_file = "/forum/assets/data/languages.json";

    public function __construct ($language)
    {
        $this->language = $language;
        $this->language_codes = array("deutsch" => "de", "english" => "en");
    }

    public function get ($key)
    {
        return json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] .self::$language_file), true)[$this->language][$key];
    }

    public function gecho ($key) 
    {
        echo json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] .self::$language_file), true)[$this->language][$key];
    }

    public function get_all() 
    {
        return json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] .self::$language_file), true)[$this->language];
    }

    public function get_language_code_from_name ()
    {
        if (array_key_exists($this->language, $this->language_codes)) {
            return $this->language_codes[$this->language];
        } else {
            return false;
        };
    }
} 