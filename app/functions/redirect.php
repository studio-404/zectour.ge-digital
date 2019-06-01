<?php
namespace functions;

class redirect
{
	public static function url($url = "")
	{
		if(empty($url)){
			echo '<meta http-equiv="refresh" content="0"/>';
		}else{
			echo '<meta http-equiv="refresh" content="0; url='.$url.'"/>';
		}
		exit();
	}
}