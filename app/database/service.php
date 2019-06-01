<?php 
class service
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("service", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	public function subservicves($args)
	{
		$out = "[]";

		$json = Config::CACHE."subservicves_".$args["product_idx"].$args["service_idx"].str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).".json";

		if(file_exists($json)){
			$out = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `subservices` WHERE `product_idx`=:product_idx AND `service_idx`=:service_idx AND `lang`=:lang ORDER BY `id` ASC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":product_idx"=>$args["product_idx"], 
				":service_idx"=>$args["service_idx"], 
				":lang"=>$args["lang"], 
			));
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$out = @file_get_contents($json); 
			}
		}
		return json_decode($out, true);
	}

	private function allSubServices($args)
	{
		$out = "[]";

		$json = Config::CACHE."subservicves_all_".$args["product_idx"].str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).".json";

		if(file_exists($json)){
			$out = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `subservices` WHERE `product_idx`=:product_idx AND `lang`=:lang ORDER BY `id` ASC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":product_idx"=>$args["product_idx"], 
				":lang"=>$args["lang"], 
			));
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);

				$out = @file_get_contents($json); 
			}
		}
		return json_decode($out, true);
	}

	public function remove($args)
	{
		$removeSub = "DELETE FROM `subservices` WHERE `product_idx`=:product_idx AND `lang`=:lang";
		$removePerpare = $this->conn->prepare($removeSub);
		$removePerpare->execute(array(
			":product_idx"=>$args['idx'],
			":lang"=>$args['lang']
		));
		if($removePerpare->rowCount()){
			return true;
		}
		return false;
	}
}
?>