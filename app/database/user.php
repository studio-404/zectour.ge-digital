<?php
class user
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("user", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function select($args)
	{
		$fetch = array();
		$sql = 'SELECT * FROM `users_website` WHERE `email`=:email';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":email"=>$args["email"]
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function removeUser($args)
	{
		$sql = 'UPDATE `users_website` SET `status`=1 WHERE `email`=:email';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":email"=>$args["email"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function selectAll($args)
	{
		$fetch = array();
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		
		$select = "SELECT (SELECT COUNT(`id`) FROM `users_website` WHERE `status`!=1) as counted, `id`, `register_date`, `register_ip`, `email`, `firstname`, `lastname` FROM `users_website` WHERE `status`!=1 ORDER BY `register_date` DESC LIMIT ".$from.",".$itemPerPage;	
		$prepare = $this->conn->prepare($select); 
		$prepare->execute();
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	/* ADMIN PANEL method */
	private function check_admin($args){
		$sql = 'SELECT `id` FROM `users` WHERE `username`=:username AND `password`=:password';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":username"=>$args["user"],
			":password"=>md5($args["pass"])
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function check($args){
		$sql = 'SELECT `id` FROM `users_website` WHERE `email`=:username AND (`password`=:password OR `recoverpassword`=:password)';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":username"=>$args["user"],
			":password"=>sha1(md5($args["pass"]))
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function updaterecover($args){
		$sql = 'UPDATE `users_website` SET `recoverpassword`=:password  WHERE `email`=:username';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":password"=>sha1(md5($args["pass"])),
			":username"=>$args["user"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function updatepassword($args){
		$sql = 'UPDATE `users_website` SET `password`=:password  WHERE `email`=:username';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":password"=>sha1(md5($args["password"])),
			":username"=>$_SESSION[Config::SESSION_PREFIX."web_username"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}


	private function check_user_exists($args){
		$sql = 'SELECT `id` FROM `users_website` WHERE `email`=:username';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":username"=>$args["username"]
		));
		if($prepare->rowCount()){
			return true;
		}

		return false;
	}

	private function checkpassword($args){
		$sql = 'SELECT `id` FROM `users_website` WHERE `password`=:current_password AND `email`=:email';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":current_password"=>sha1(md5($args["current_password"])), 
			":email"=>$_SESSION[Config::SESSION_PREFIX."web_username"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function insert($args){
		require_once("app/functions/server.php");
		$server = new functions\server();

		$sql = 'INSERT INTO `users_website` SET 
		`register_date`=:register_date, 
		`register_ip`=:register_ip, 
		`email`=:username, 
		`password`=:password, 
		`firstname`=:firstname, 
		`lastname`=:lastname,
		`dob`=:dob,
		`gender`=:gender,
		`country`=:country,
		`city`=:city,
		`phone`=:phone,
		`postcode`=:postcode
		';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":register_date"=>time(), 
			":register_ip"=>$server->ip(), 
			":username"=>$args["username"], 
			":password"=>sha1(md5($args["password"])), 
			":firstname"=>$args["firstname"], 
			":lastname"=>$args["lastname"], 
			":dob"=>$args["dob"], 
			":gender"=>$args["gender"], 
			":country"=>$args["country"], 
			":city"=>$args["city"], 
			":phone"=>$args["phone"], 
			":postcode"=>$args["postcode"] 
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function update($args){
		$sql = 'UPDATE `users_website` SET 
		`firstname`=:firstname, 
		`lastname`=:lastname,
		`dob`=:dob,
		`gender`=:gender,
		`country`=:country,
		`city`=:city,
		`phone`=:phone,
		`postcode`=:postcode
		WHERE 
		`email`=:email
		';
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":firstname"=>$args["firstname"], 
			":lastname"=>$args["lastname"], 
			":dob"=>$args["dob"], 
			":gender"=>$args["gender"], 
			":country"=>$args["country"], 
			":city"=>$args["city"], 
			":phone"=>$args["phone"], 
			":postcode"=>$args["postcode"], 
			":email"=>$_SESSION[Config::SESSION_PREFIX."web_username"]
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}
}
?>