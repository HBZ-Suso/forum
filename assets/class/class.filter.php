<?php

class Filter
{

	public static $purifier_url = "/forum/assets/php/htmlpurifier-4.13.0/library/HTMLPurifier.auto.php";

	public function __construct()
	{
		require_once $_SERVER["DOCUMENT_ROOT"] . self::$purifier_url;
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