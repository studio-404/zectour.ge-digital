<?php 
class strip_output
{
	public static function index($str)
	{
		$output = strip_tags($str,"<p><strong><i><em><div><a><table><thead><tr><td><ul><ol><li>");
		return $output;
	}
}