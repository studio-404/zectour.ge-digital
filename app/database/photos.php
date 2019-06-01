<?php 
class photos
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("photos", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function selectByParent($args)
	{
		$sql = "SELECT * FROM `photos` WHERE `parent`=:parent AND `lang`=:lang AND `type`=:type AND `status`!=:one ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($sql);
		$prepare->execute(array(
			":parent"=>$args["idx"], 
			":lang"=>$args["lang"], 
			":type"=>$args["type"], 
			":one"=>1
		));
		if($prepare->rowCount()){
			return $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return array();
	}

	private function deleteByParent($args)
	{
		$delete = "DELETE FROM `photos` WHERE `parent`=:idx AND `type`=:type AND `lang`=:lang";
		$prepareDel = $this->conn->prepare($delete);
		$prepareDel->execute(array(
			":idx"=>$args["idx"], 
			":type"=>$args["type"], 
			":lang"=>$args["lang"]  
		));
		if($prepareDel->rowCount()){
			return 1;
		}
		return 0;
	}

}