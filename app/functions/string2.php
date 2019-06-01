<?php 
namespace functions; 

class string2
{
	public function cut($text,$number)
	{
		$charset = 'UTF-8';
		$length = $number;
		$string = strip_tags($text);
		if(mb_strlen($string, $charset) > $length) {
			$string = mb_substr($string, 0, $length, $charset) . '...';
		}
		else
		{
			$string=$text;
		}
		return $string; 
	}

	public static function cutstatic($text,$number)
	{
		$charset = 'UTF-8';
		$length = $number;
		$string = strip_tags($text);
		if(mb_strlen($string, $charset) > $length) {
			$string = mb_substr($string, 0, $length, $charset) . '...';
		}
		else
		{
			$string=$text;
		}
		return $string; 
	}

	public static function random($length)
	{
		$bytes = openssl_random_pseudo_bytes($length * 2);
		return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
	}

	public static function escapeJavaScriptText($string){
		$string = strip_tags($string); 
		return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
	}
}