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


    public function mail ($title_code, $text_code)
    {
        return '
        <div style="width: 100%; height: 100%; left: 0px; top: 0px; position: absolute; background-color: turquoise;"></div>
        <div style="border: 1px solid black; border-radius: 5px;  position: absolute; min-height: 100%; height: min-content; left: 0px; top: 0px; width: 60%; left: 20%; background-color: gray;">
            <h1 style="color: black; text-align: center; text-decoration: underline;">' . $this->get($title_code) . '</h1>
            <p style="color: darkblue; text-align: center;">' . $this->get($text_code) . '</p>
        </div>
        ';
    }



    public function generate_mail_html ($heading, $text) {
        return '
        <div style="width: 100%; height: 100%; left: 0px; top: 0px; position: absolute; background-color: turquoise;"></div>
        <div style="border: 1px solid black; border-radius: 5px;  position: absolute; min-height: 100%; height: min-content; left: 0px; top: 0px; width: 60%; left: 20%; background-color: gray;">
            <h1 style="color: black; text-align: center; text-decoration: underline;">' . $heading . '</h1>
            <p style="color: darkblue; text-align: center;">' . $text . '</p>
        </div>
        ';
    }
} 