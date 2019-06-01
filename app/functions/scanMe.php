<?php
namespace functions; 

class scanMe{
	public function index($scanDir){
		$scanedDir = scandir($scanDir);
		return $scanedDir;
	}
}