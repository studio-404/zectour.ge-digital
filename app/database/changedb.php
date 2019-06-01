<?php 
class changedb
{
	public function __construct()
	{

	}

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("changedb", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	public function selectandinsert($args)
	{
		echo "Exit";
		exit();
		$fetch = array();
		$select = "SELECT * FROM `countries`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			
			$idx = 1;
			foreach ($fetch as $v) {
				$insert2 = "INSERT INTO `countrie_names` SET `idx`=:idx, `name`=:name, `lang`=:lang";
				$prepare2 = $this->conn->prepare($insert2);
				$prepare2->execute(array(
					":idx"=>$idx,
					":name"=>$v["name_en"],
					":lang"=>"en"
				));

				$insert3 = "INSERT INTO `countrie_names` SET `idx`=:idx, `name`=:name, `lang`=:lang";
				$prepare3 = $this->conn->prepare($insert3);
				$prepare3->execute(array(
					":idx"=>$idx,
					":name"=>$v["name_ru"],
					":lang"=>"ru"
				));

				$insert4 = "INSERT INTO `countrie_names` SET `idx`=:idx, `name`=:name, `lang`=:lang";
				$prepare4 = $this->conn->prepare($insert4);
				$prepare4->execute(array(
					":idx"=>$idx,
					":name"=>$v["name_fr"],
					":lang"=>"fr"
				));


				$idx++;
			}
			

			echo "Done";
		}
		return $fetch;
	}
}