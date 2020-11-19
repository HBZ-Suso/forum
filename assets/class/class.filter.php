<?php

class Filter
{

	public static $purifier_url = "/forum/assets/php/htmlpurifier-4.13.0/library/HTMLPurifier.auto.php";

	public function __construct()
	{
		$this->purifierpath = $_SERVER["DOCUMENT_ROOT"] . self::$purifier_url;
		require_once $this->purifierpath;
		$this->purifier_config = HTMLPurifier_Config::createDefault();
		$this->purifier = new HTMLPurifier($this->purifier_config);
	}
	

	public function purify($text, $times)
	{
		$to_return = $text;
		for ($i = 0; $i < $times; $i++) {
			$to_return = $this->purifier->purify($to_return);
		}
		return $to_return;
	}
}
?>