<?php 
class products
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("products", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	private function website_select($args)
	{
		require_once("app/functions/request.php"); 

		$fetch = "[]";
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (((int)$_GET['pn']-1)*$itemPerPage) : 0;
		$slug = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : "";

		if(isset($args['showwebsite'])){ $show="2"; }
		else{  $show="1"; }
		$json = Config::CACHE."products_website_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$show.$slug.$itemPerPage.$from.".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$showwebsiteSql = "";
			if(isset($args['showwebsite'])){
				$showwebsiteSql = ' `products`.`showwebsite`=:showwebsite AND ';
			}
			$select = "SELECT 
			(
				SELECT COUNT(`products`.`id`) 
				FROM `navigation`, `products` 
				WHERE 
				`navigation`.`slug`=:slug AND 
				`navigation`.`lang`=:lang AND 
				`navigation`.`status`!=:one AND 
				`navigation`.`idx`=`products`.`pid` AND 
				`products`.`lang`=:lang AND
				". $showwebsiteSql ."`products`.`status`!=:one
			) as counted, 
			`products`.`idx`, 
			`products`.`title`,
			`products`.`price`,
			`products`.`price_child`,
			`products`.`price_child512`,
			`products`.`price_child1220`,
			`products`.`tourist_points`,
			`products`.`short_description`, 
			`products`.`description`,
			`products`.`sold`,
			`products`.`showwebsite`,
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM 
			`navigation`, `products`
			WHERE 
			`navigation`.`slug`=:slug AND 
			`navigation`.`lang`=:lang AND 
			`navigation`.`status`!=:one AND 
			`navigation`.`idx`=`products`.`pid` AND 
			`products`.`lang`=:lang AND " . $showwebsiteSql ."
			`products`.`status`!=:one 
			ORDER BY `products`.`date` DESC LIMIT ".$from.",".$itemPerPage;

			$prepare = $this->conn->prepare($select); 
			if(isset($args['showwebsite'])){
				$prepare->execute(array(
					":slug"=>$slug, 
					":lang"=>$args['lang'],
					":showwebsite"=>$args['showwebsite'],
					":one"=>1
				));
			}else{
				$prepare->execute(array(
					":slug"=>$slug, 
					":lang"=>$args['lang'],
					":one"=>1
				));
			}
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

	private function sitemap_select($args)
	{
		$fetch = "[]";

		$select = "SELECT 
		`products`.`idx`, 
		`products`.`title`
		FROM 
		`products`
		WHERE 
		`products`.`lang`=:lang AND 
		`products`.`status`!=:one";

		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":lang"=>$args['lang'],
			":one"=>1
		));

		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);			
		}

		return $fetch;
	}

	private function select($args)
	{
		require_once("app/functions/request.php"); 

		$fetch = "[]";
		$itemPerPage = $args['itemPerPage'];
		$from = (isset($_GET['pn']) && $_GET['pn']>0) ? (((int)$_GET['pn']-1)*$itemPerPage) : 0;
		$pid = (isset($_SESSION["URL"][3])) ? $_SESSION["URL"][3] : 0;
		// $parsed_url = $args['parsed_url'];
		if(isset($args['showwebsite'])){ $show="2"; }
		else{  $show="1"; }
		$json = Config::CACHE."products_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$show.$itemPerPage.$from.".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$showwebsiteSql = "";
			if(isset($args['showwebsite'])){
				$showwebsiteSql = ' `products`.`showwebsite`=:showwebsite AND ';
			}
			$select = "SELECT 
			(SELECT COUNT(`id`) FROM `products` WHERE `products`.`pid`=:pid AND `products`.`lang`=:lang AND" . $showwebsiteSql ."`products`.`status`!=:one) as counted, 
			`products`.`idx`, 
			`products`.`title`,
			`products`.`price`,
			`products`.`tourist_points`,
			`products`.`short_description`, 
			`products`.`description`,
			`products`.`sold`,
			`products`.`showwebsite`,
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM 
			`products` 
			WHERE 
			`products`.`pid`=:pid AND 
			`products`.`lang`=:lang AND " . $showwebsiteSql ."
			`products`.`status`!=:one 
			ORDER BY `products`.`date` DESC LIMIT ".$from.",".$itemPerPage;


			$prepare = $this->conn->prepare($select); 
			if(isset($args['showwebsite'])){
				$prepare->execute(array(
					":pid"=>$pid, 
					":lang"=>$args['lang'],
					":showwebsite"=>$args['showwebsite'],
					":one"=>1
				));
			}else{
				$prepare->execute(array(
					":pid"=>$pid, 
					":lang"=>$args['lang'],
					":one"=>1
				));
			}
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

	private function tourMaxMin(){
		$out["min"] = 0;
		$out["max"] = 0;

		$select = "SELECT MIN(CAST(`products`.`price` AS DECIMAL(8,0))) as min,  MAX(CAST(`products`.`price` AS DECIMAL(8,0))) as max FROM `products` WHERE `products`.`pid`=:pid AND `products`.`lang`=:lang AND `products`.`showwebsite`=2 AND `products`.`status`!=:one";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":pid"=>3, 
			":lang"=>$_SESSION["LANG"],
			":one"=>1
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$out["min"] = $fetch["min"];
			$out["max"] = $fetch["max"];
		}

		// echo "<pre>";
		// print_r($out);
		// echo "</pre>";

		return $out;
	}

	private function selectTop($args){
		$fetch = "[]";

		$json = Config::CACHE."products_homepagetopshow".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT 
			`products`.`idx`, 
			`products`.`title`, 
			`products`.`lang`, 
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM `products` 
			WHERE
			 `products`.`pid`=:pid AND 
			 `products`.`lang`=:lang AND 
			 `products`.`showwebsite`=:showwebsite AND 
			 `products`.`status`!=:one ORDER BY `products`.`views` DESC LIMIT 10";
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":pid"=>3, 
				":showwebsite"=>2, 
				":lang"=>$_SESSION["LANG"],
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

	private function selectSpecial($args){
		$fetch = "[]";

		$limit = (isset($args["limit"])) ? $args["limit"] : 3;
		$json = Config::CACHE."products_homepageSpecialshow".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT 
			`products`.`idx`, 
			`products`.`title`, 
			`products`.`price`, 
			`products`.`short_description`, 
			`products`.`lang`, 
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM `products` 
			WHERE
			 `products`.`pid`=:pid AND 
			 `products`.`lang`=:lang AND 
			 `products`.`showwebsite`=:showwebsite AND 
			 `products`.`status`!=:one ORDER BY `products`.`views` DESC LIMIT ".$limit;
			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
				":pid"=>3, 
				":showwebsite"=>2,  
				":lang"=>$_SESSION["LANG"],
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

	private function add($args)
	{
		$current_lang = $args["lang"];
		$catalogId = (int)$args["catalogId"];
		$date = strtotime($args['date']);
		$title = $args["title"];
		
		$tourist_points = $args["tourist_points"];
		$price = $args["price"];
		$price_child = $args["price_child"];

		$price_child512 = $args["price_child512"];
		$price_child1220 = $args["price_child1220"];
		$min_liter = $args["min_liter"];

		$sold = $args["sold"];
		$short_description = $args["shortDescription"];
		$description = $args["longDescription"];
		$location = $args["locations"];
		$showwebsite = $args["showwebsite"];
		$hompagelist = $args["hompagelist"];
		
		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `products`";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute();
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;	

		foreach ($fetch as $val) {
			$insert = "INSERT INTO `products` SET 
			`idx`=:idx, 
			`pid`=:pid, 
			`date`=:datex, 
			`title`=:title, 
			`tourist_points`=:tourist_points, 
			`price`=:price, 
			`price_child`=:price_child, 
			`price_child512`=:price_child512, 
			`price_child1220`=:price_child1220, 
			`min_liter`=:min_liter,
			`sold`=:sold, 
			`short_description`=:short_description, 
			`description`=:description, 
			`location`=:location, 
			`showwebsite`=:showwebsite,
			`hompagelist`=:hompagelist,
			`visibility`=:visibility,  
			`views`=:views,  
			`status`=:status,  
			`lang`=:lang";
			$prepare3 = $this->conn->prepare($insert);
			$prepare3->execute(array(
				":idx"=>$maxId, 
				":pid"=>$catalogId, 
				":datex"=>$date, 
				":title"=>$title, 
				":tourist_points"=>$tourist_points,
				":price"=>$price,
				":price_child"=>$price_child,
				":price_child512"=>$price_child512, 
				":price_child1220"=>$price_child1220,
				":min_liter"=>$min_liter,
				":sold"=>$sold,
				":short_description"=>$short_description,
				":description"=>$description,
				":location"=>$location,
				":showwebsite"=>$showwebsite,
				":hompagelist"=>$hompagelist,
				":visibility"=>0,
				":views"=>0,
				":status"=>0,
				":lang"=>$val['title']
			)); 

			if(count($args["serialPhotos"])){
				foreach ($args["serialPhotos"] as $pic) {
					if(!empty($pic)):
					$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
					$photoPerpare = $this->conn->prepare($photo);
					$photoPerpare->execute(array(
						":parent"=>$maxId, 
						":pathx"=>$pic, 
						":type"=>"products", 
						":lang"=>$val['title'], 
						":zero"=>0
					));
					endif;
				}
			}
		}

		$this->clearCache();
	}

	private function remove($args)
	{
		$val = $args['val'];
		$update = "UPDATE `products` SET `status`=:one WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update); 
		$prepare->execute(array(
			":one"=>1,
			":idx"=>$val
		));
		if($prepare->rowCount()){
			$update2 = "UPDATE `photos` SET `status`=:one WHERE `parent`=:parent AND `type`=:type";
			$prepare2 = $this->conn->prepare($update2); 
			$prepare2->execute(array(
				":one"=>1,
				":parent"=>$val,
				":type"=>"products"
			));

			$delete = "DELETE FROM `subservices` WHERE `product_idx`=:product_idx";
			$prepare3 = $this->conn->prepare($delete); 
			$prepare3->execute(array(
				":product_idx"=>$val
			));
		}
		$this->clearCache();
		return 1;
	}

	private function selectById($args)
	{
		$fetch = "";
		if(isset($args['showwebsite'])){ $show="2"; }
		else{  $show="1"; }

		if(isset($args["increament"])){
			$increament = "UPDATE `products` SET `views` = `views` + 1 WHERE `idx`=:idx";
			$in_prepare = $this->conn->prepare($increament); 
			$in_prepare->execute(array(
				":idx"=>$args['idx']
			));
		}

		$json = Config::CACHE."products_byid_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$show.$args['idx'].".json";
		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{	
			$showwebsiteSql = "";
			if(isset($args['showwebsite'])){
				$showwebsiteSql = ' `showwebsite`=:showwebsite AND ';
			}

			$select = "SELECT *, 
			(
				SELECT 
				`photos`.`path` FROM 
				`photos` WHERE 
				`photos`.`parent`=`products`.`idx` AND 
				`photos`.`type`='products' AND 
				`photos`.`lang`=`products`.`lang` AND 
				`photos`.`status`!=:one 
				ORDER BY `photos`.`id` ASC LIMIT 1
			) AS photo 
			FROM `products` 
			WHERE `idx`=:idx AND 
			`lang`=:lang AND ".$showwebsiteSql."`status`!=:one";
			$prepare = $this->conn->prepare($select); 
			if(isset($args['showwebsite'])){
				$prepare->execute(array(
					":idx"=>$args['idx'], 
					":lang"=>$args['lang'], 
					":showwebsite"=>$args['showwebsite'], 
					":one"=>1
				));
			}else{
				$prepare->execute(array(
					":idx"=>$args['idx'], 
					":lang"=>$args['lang'], 
					":one"=>1
				));
			}
			if($prepare->rowCount()){
				$db_fetch = $prepare->fetch(PDO::FETCH_ASSOC);
				$fh = @fopen($json, 'w') or die("Error opening output file");
				@fwrite($fh, json_encode($db_fetch,JSON_UNESCAPED_UNICODE));
				@fclose($fh);
				$fetch = @file_get_contents($json);
			}

		}
		return json_decode($fetch, true);
	}

	private function edit($args)
	{
		$current_lang = $args["lang"];
		$idx = (int)$args["idx"];
		$date = strtotime($args['date']);
		$title = $args["title"];
		$tourist_points = $args["chooseTouristCount"];
		$price = $args["price"];
		$price_child = $args["price_child"];

		$price_child512 = $args["price_child512"];
		$price_child1220 = $args["price_child1220"];
		$min_liter = $args["min_liter"];

		$sold = $args["sold"];
		$short_description = $args["shortDescription"];
		$description = $args["longDescription"];
		$location = $args["locations"];
		
		$showwebsite = $args["showwebsite"];
		$hompagelist = $args["hompagelist"];


		// update one language
		$update = "UPDATE `products` SET 
		`title`=:title, 
		`short_description`=:short_description, 
		`description`=:description
		WHERE `idx`=:idx AND `lang`=:lang";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":title"=>$title,  
			":short_description"=>$short_description,  
			":description"=>$description,  
			":idx"=>$args['idx'],  
			":lang"=>$args['lang']   
		));	

		// update in all language
		$updateShow = "UPDATE `products` SET 
		`date`=:datex, 
		`tourist_points`=:tourist_points, 
		`price`=:price, 
		`price_child`=:price_child, 
		`price_child512`=:price_child512, 
		`price_child1220`=:price_child1220, 
		`min_liter`=:min_liter, 
		`sold`=:sold, 
		`showwebsite`=:showwebsite, 
		`hompagelist`=:hompagelist, 
		`location`=:location WHERE 
		`idx`=:idx";
		$prepareShow = $this->conn->prepare($updateShow);
		$prepareShow->execute(array(
			":datex"=>$date, 
			":tourist_points"=>$tourist_points,
			":price"=>$price, 
			":price_child"=>$price_child, 
			":price_child512"=>$price_child512, 
			":price_child1220"=>$price_child1220, 
			":min_liter"=>$min_liter, 
			":sold"=>$sold, 
			":showwebsite"=>$showwebsite, 
			":hompagelist"=>$hompagelist, 
			":location"=>$location, 
			":idx"=>$args['idx']
		));


		$photos = new Database('photos', array(
			'method'=>'deleteByParent', 
			'idx'=>$args['idx'], 
			'type'=>"products",
			'lang'=>$args['lang'] 
		));

		if(count($args["serialPhotos"])){

			foreach($args["serialPhotos"] as $pic) {
				if(!empty($pic)):
				$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
				$photoPerpare = $this->conn->prepare($photo);
				$photoPerpare->execute(array(
					":parent"=>$args['idx'], 
					":pathx"=>$pic, 
					":type"=>"products", 
					":lang"=>$args['lang'], 
					":zero"=>0
				));
				endif;
			}
		}

		$this->clearCache();
	}

	public function countRegions($args){
		$count = 0;
		$sql = "SELECT DISTINCT `region` FROM `products` WHERE `lang`='ge' AND `status`!=1"; 
		$prepare = $this->conn->prepare($sql); 
		$prepare->execute();
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
			$count = count($fetch);
		}
		return $count;
	}

	private function countByDestination($args)
	{
		$count = 0;
		$select = "SELECT COUNT(`id`) as counted FROM `products` WHERE FIND_IN_SET(:numberx, `destination`) AND `showwebsite`=2 AND `lang`=:lang AND `status`!=1";
		$prepare = $this->conn->prepare($select); 
		$prepare->execute(array(
			":numberx"=>$args["numberx"],
			":lang"=>$args["lang"],
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$count = $fetch["counted"];
		}
		return $count;
	}

	private function clearCache()
	{
		$mask = Config::CACHE.'products_*.*';
		array_map('unlink', glob($mask));

		$mask2 = Config::CACHE.'subservicves_*.*';
		array_map('unlink', glob($mask2));

		$mask3 = Config::CACHE.'module_*.*';
		array_map('unlink', glob($mask3));

		$mask4 = Config::CACHE.'homepagelist_*.*';
		array_map('unlink', glob($mask4));	
	}

	private function selectHomepageList($args)
	{
		require_once("app/functions/request.php"); 

		$fetch = "[]";

		$json = Config::CACHE."homepagelist_unsigned_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{

			$select = "SELECT 
			(SELECT COUNT(`id`) FROM `products` WHERE `products`.`hompagelist`!=0 AND `products`.`lang`=:lang AND `products`.`status`!=:one) as counted, 
			`products`.`idx`, 
			`products`.`title`,
			`products`.`price`,
			`products`.`price_child`,
			`products`.`price_child512`,
			`products`.`price_child1220`,
			`products`.`tourist_points`,
			`products`.`short_description`, 
			`products`.`description`,
			`products`.`sold`,
			`products`.`showwebsite`,
			(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`products`.`idx` AND `photos`.`type`='products' AND `photos`.`lang`=`products`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
			FROM 
			`products` 
			WHERE 
			`products`.`hompagelist`!=0 AND 
			`products`.`lang`=:lang AND
			`products`.`status`!=:one 
			ORDER BY CAST(`products`.`hompagelist` AS unsigned) ASC";


			$prepare = $this->conn->prepare($select); 
			$prepare->execute(array(
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
}