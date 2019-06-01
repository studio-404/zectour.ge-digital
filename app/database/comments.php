<?php 
class comments
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("comments", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function removeComments($args)
	{
		$update = "UPDATE `comments` SET `status`=:one WHERE `id`=:id";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":id"=>$args['id'],
			":one"=>1
		)); 
		if($prepare->rowCount())
		{
			return 1;
		}
		return 0;
	}

	private function selectById($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `comments` WHERE `id`=:id AND `status`!=:one";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":id"=>$args['id'],
			":one"=>1 
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			if($fetch[0]["read"]==0 && !isset($args['noUpdateRead'])){
				$this->updateRead($fetch[0]["id"]);
			}
		}
		return $fetch;
	}

	private function updateRead($id)
	{
		$update = "UPDATE `comments` SET `read`=:one WHERE `id`=:id";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":id"=>$id, 
			":one"=>1
		)); 
		if($prepare->rowCount())
		{
			return 1;
		}
		return 0;
	}

	private function select($args)
	{
		$fetch = array();
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		if(!isset($args['file']) || $args['file']==""){
			$select = "SELECT (SELECT COUNT(`id`) FROM `comments` WHERE `status`!=:one) as counted, `id`, `date`, `firstname`, `organization`, `email`, `read` FROM `comments` WHERE `status`!=:one ORDER BY `date` DESC LIMIT ".$from.",".$itemPerPage;
		}else{
			$select = "SELECT (SELECT COUNT(`id`) FROM `comments` WHERE `status`!=:one) as counted, `id`, `date`, `firstname`, `organization`, `email`, `read` FROM `comments` WHERE `commentId`=".$args['file'];
		}

		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function insert($args)
	{
		require_once 'app/functions/server.php';
		$server = new functions\server();
		$ip = $server->ip();
		$out = 0;
		
		try{
			$insert = "INSERT INTO `comments` SET 
			`date`=:datex, 
			`ip`=:ip, 
			`commentId`=:commentId, 
			`firstname`=:firstname, 
			`organization`=:organization, 
			`email`=:email, 
			`comment`=:comment, 
			`lang`=:lang, 			
			`read`=:zero, 
			`status`=:zero 
			";
			$prepare = $this->conn->prepare($insert);
			$prepare->execute(array(
				":datex"=>time(),
				":ip"=>$ip,
				":commentId"=>$args['commentId'],
				":firstname"=>$args['firstname'],
				":organization"=>$args['organization'],
				":email"=>$args['email'],
				":comment"=>$args['comment'],
				":lang"=>$args['lang'],
				":zero"=>0
			));	
			if($prepare->rowCount()){
				$out = 1;	
			}			
		}catch(Exception $e){ $out = 0;	}
		return $out;
	}
}