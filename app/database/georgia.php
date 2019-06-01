<?php 
class georgia
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("georgia", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function select($args)
	{
		$fetch = "[]";
		$itemPerPage = $args['itemPerPage'];
		if(!isset($args['zeroPage'])){
			$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (($_GET['pn']-1)*$itemPerPage) : 0;
		}else{
			$from = 0; 
		}
		$orderby = (!isset($args['orderby'])) ? " ORDER BY `name` ASC" : $args['orderby'];

		$json = Config::CACHE."georgia_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL']))."_".$from.$args['cid'].$args['lang'].".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT (SELECT COUNT(`id`) FROM `georgia` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:one) as counted, `idx`, `cid`, `name` FROM `georgia` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:one".$orderby." LIMIT ".$from.",".$itemPerPage;
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":cid"=>$args['cid'], 
				":lang"=>$args['lang'],
				":one"=>1
			));
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$fetch = @file_get_contents($json); 
			}
		}
		
		return json_decode($fetch, true);
	}

	private function selectById($args)
	{
		$fetch = array();
		$select = "SELECT * FROM `georgia` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:one ORDER BY `name` ASC";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":idx"=>$args['idx'], 
			":lang"=>$args['lang'],
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function edit($args)
	{
		require_once 'app/functions/files.php';

		$idx = $args["idx"];
		$lang = $args["lang"];
		
		$name = $args["name"];
		

		$update = "UPDATE `georgia` SET `name`=:namex WHERE `idx`=:idx AND `lang`=:lang";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":namex"=>$name,
			":idx"=>$idx, 
			":lang"=>$lang 
		));	

		$this->clearCache();

		return 1;
	}

	private function add($args)
	{
		$slug = $args['slug'];
		$name = $args['name'];
		

		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `georgia` WHERE `status`!=:one";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute(array(":one"=>1));
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;

		foreach ($fetch as $val) {
			$insert = "INSERT INTO `georgia` SET `idx`=:idx, `cid`=:cid, `name`=:name, `lang`=:lang";
			$prepare3 = $this->conn->prepare($insert);
			$prepare3->execute(array(
				":idx"=>$maxId, 
				":cid"=>$slug, 
				":name"=>$name, 
				":lang"=>$val['title']
			)); 
		}

		$this->clearCache();

		return array("test"=>"true");
	}

	private function removeCity($args)
	{
		$idx = $args['idx'];

		$update = "UPDATE `georgia` SET `status`=:one WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update); 
		$prepare->execute(array(
			":one"=>1,
			":idx"=>$idx
		));

		$this->clearCache();

		return $prepare->rowCount();
	}

	private function clearCache()
	{
		$mask = Config::CACHE.'georgia_*.*';
		array_map('unlink', glob($mask));
	}
}