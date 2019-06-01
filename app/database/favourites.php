<?php 
class favourites
{
	public function __construct()
	{

	}

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("favourites", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}



	private function check($args)
	{
		$select = "SELECT `id` FROM `favourites` WHERE `user`=:user AND `tour_id`=:tour_id";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":user"=>$args['user'],
			":tour_id"=>$args['tour_id']
		));
		if($prepare->rowCount()){
			return true;
		}
		return false;
	}

	private function remove($args)
	{
		$select = "DELETE FROM `favourites` WHERE `user`=:user AND `tour_id`=:tour_id";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":user"=>$args['user'],
			":tour_id"=>$args['tour_id']
		));
		if($prepare->rowCount()){
			$this->clearCache();
			return true;
		}
		return false;
	}

	private function insertFavourite($args)
	{
		$insert = "INSERT INTO `favourites` SET `user`=:user, `tour_id`=:tour_id";
		$prepare = $this->conn->prepare($insert);
		$prepare->execute(array(
			":user"=>$args['user'],
			":tour_id"=>$args['tour_id']
		));

		if($prepare->rowCount()){
			$this->clearCache();
			return true;
		}
		return false;
	}

	private function select($args)
	{
		require_once("app/functions/request.php"); 

		$fetch = "[]";
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && (int)$_GET['pn']>0) ? (((int)$_GET['pn']-1)*$itemPerPage) : 0;

		$json = Config::CACHE."favourites_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$from.$itemPerPage.".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{

			$select = "SELECT 
			(SELECT COUNT(`favourites`.`id`) FROM `favourites` WHERE `favourites`.`user`=:user) as counted, 
			`products`.`idx`, 
			`products`.`title`,
			`products`.`short_description`, 
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM 
			`favourites`, `products`
			WHERE 
			`favourites`.`user`=:user AND 
			`favourites`.`tour_id`=`products`.`idx` AND 
			`products`.`pid`=:pid AND
			`products`.`lang`=:lang AND
			`products`.`status`!=:one AND 
			`products`.`showwebsite`=:two
			ORDER BY `products`.`id` DESC LIMIT ".$from.",".$itemPerPage;


			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":user"=>$args['user'], 
				":pid"=>3, 
				":lang"=>$args['lang'],
				":one"=>1,
				":two"=>2
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


	private function clearCache()
	{
		$mask = Config::CACHE.'favourites_*.*';
		array_map('unlink', glob($mask));
	}

}