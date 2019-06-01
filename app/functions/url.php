<?php 
namespace functions;

class url
{
	public function getUrl(){
		$request = parse_url($_SERVER['REQUEST_URI']);
		$path = $request["path"];
		$result = trim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $path), '/');
		return $result;
	}
}