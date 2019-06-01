<?php 
namespace functions;

class checkUserExists
{
	public function __construct()
	{

	}

	public function index($pid, $email)
	{
		require_once("app/core/Database.php");
		
		$Database = new \Database("statements", array(
			"method"=>"checkAfterRegister", 
			"pid"=>$pid, 
			"email"=>$email 
		));
		$output = $Database->getter();
		if($output)
		{
			return true;
		}
		return false;
	}
}