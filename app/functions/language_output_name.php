<?php 
namespace functions;

class language_output_name
{
	public function index()
	{
		require_once("app/core/Database.php");
		
		$Database = new \Database("language", array(
			"method"=>"current"
		));
		;
		if($getter = $Database->getter()){
			return $getter;
		}else{
			return array("name"=>"French");
		}
	}
}