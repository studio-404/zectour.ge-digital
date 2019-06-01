<?php 
class newsletter
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("newsletter", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function check($args)
	{
		$select = "SELECT `id` FROM `newsletter` WHERE `email`=:email";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":email"=>$args["email"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function add($args)
	{
		require_once("app/functions/server.php");
		$server = new functions\server();

		$select = "INSERT INTO `newsletter` SET `ip`=:ip, `email`=:email";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":ip"=>$server->ip(),
			":email"=>$args["email"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}
}