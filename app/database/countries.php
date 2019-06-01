<?php 
class countries
{
	public function __construct()
	{

	}

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("countries", $args['method']))
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
		$select = "SELECT `idx`, `name` FROM `countries` WHERE `lang`=:lang ORDER BY `name` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":lang"=>$args['lang']
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}
}