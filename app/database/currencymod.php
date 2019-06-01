<?php 
class currencymod
{
	public function __construct()
	{
		
	}

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("currencymod", $args['method']))
		{
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function insert($args)
	{
		$insert = "INSERT INTO `currency` SET `name`=:name, `value`=:value";
		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":name"=>strtoupper($args['name']), 
			":value"=>(float)$args['value']
		));
		return 1;
	}

	private function select($args){
		$out = array();
		$select = "SELECT `name`,`value` FROM `currency` WHERE `name` IN('USD','RUB') ORDER BY `name` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();

		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			foreach ($fetch as $v) {
				$out[] = $v;
			}
		}

		return $out;
	}

	private function removeAll($args)
	{
		$delete = "DELETE FROM `currency` WHERE 1";
		$prepare = $this->conn->prepare($delete);
		$prepare->execute();
		return 1;
	}
}