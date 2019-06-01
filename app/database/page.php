<?php 
class page
{
	private $conn;

	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("page", $args['method']))
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

		$json = Config::CACHE."pages_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$args['cid'].$args['nav_type'].".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `navigation` WHERE `cid`=:cid AND `nav_type`=:nav_type AND `lang`=:lang AND `status`=:status ORDER BY `position` ASC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":cid"=>$args['cid'], 
				":nav_type"=>$args['nav_type'],
				":lang"=>$args['lang'], 
				":status"=>$args['status'], 
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

	private function updateVisibility($args)
	{
		$visibility = ($args['visibility']==0) ? 1 : 0;
		$idx = (int)$args['idx'];

		$update = "UPDATE `navigation` SET `visibility`=:visibility WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":visibility"=>$visibility, 
			":idx"=>$idx
		));
		if($prepare->rowCount())
		{
			$this->clearCache();
			return 1;
		}
		return 0;
	}

	private function selectById($args)
	{
		$fetch = array();
		$idx = $args['idx']; 
		$lang = $args['lang'];

		$select = "SELECT * FROM `navigation` WHERE `idx`=:idx AND `lang`=:lang AND `status`!=:one";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":idx"=>$idx, 
			":lang"=>$lang, 
			":one"=>1 
		)); 
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}

	private function selecteByCid($args)
	{
		$fetch = "[]";
		$cid = $args['cid']; 
		$lang = $args['lang'];

		$json = Config::CACHE."pages_cid_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$args['cid'].".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `navigation` WHERE `cid`=:cid AND `lang`=:lang AND `status`!=:one ORDER BY `position` ASC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":cid"=>$cid, 
				":lang"=>$lang, 
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

	private function selecteMyaccountNav($args)
	{
		require_once("app/functions/request.php");
		$view = functions\request::index("GET", "view");
		$fetch = "[]";
		$lang = $args['lang'];

		$json = Config::CACHE."pages_myaccount_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$view.".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			$select = "SELECT * FROM `myaccount_nav` WHERE `lang`=:lang ORDER BY `position` ASC";
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":lang"=>$lang
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

	private function selecteBySlug($args)
	{
		$fetch = "[]";
		$slug = $args['slug']; 
		$lang = $args['lang'];
		$all = (!isset($args['all'])) ? "noall" : "";
		$json = Config::CACHE."pages_slug_".str_replace(array("-"," "), "", implode("_",$_SESSION['URL'])).$all.$args['slug'].".json";

		if(file_exists($json)){
			$fetch = @file_get_contents($json); 
		}else{
			if(!isset($args['all'])){
				$select = "SELECT `type` FROM `navigation` WHERE `slug`=:slug AND `lang`=:lang AND `status`!=:one";
			}else{
				$select = "SELECT 
				`navigation`.*,
				(SELECT `photos`.`path` FROM `photos` WHERE `photos`.`parent`=`navigation`.`idx` AND `photos`.`type`=`navigation`.`type` AND `photos`.`lang`=`navigation`.`lang` AND `photos`.`status`!=:one ORDER BY `photos`.`id` ASC LIMIT 1) AS photo
				FROM 
				`navigation`
				WHERE 
				`navigation`.`slug`=:slug AND 
				`navigation`.`lang`=:lang AND 
				`navigation`.`status`!=:one";
			}
			$prepare = $this->conn->prepare($select);
			$prepare->execute(array(
				":slug"=>$slug, 
				":lang"=>$lang, 
				":one"=>1 
			)); 
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

	private function add($args)
	{
		$current_lang = $args["lang"];
		$input_cid = (int)$args["input_cid"];
		$navtype = (int)$args["chooseNavType"];
		$type = $args["choosePageType"];
		$title = $args["title"];
		$slug = $args["slug"];
		$cssclass = (isset($args["cssclass"])) ? $args["cssclass"] : "";
		$usefull_type = (isset($args["usefull_type"])) ? $args["usefull_type"] : "false";
		$redirect = $args["redirect"];
		$description = $args["pageDescription"];
		$textx = $args["pageText"];

		$select = "SELECT `title` FROM `languages`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);

		$max = "SELECT MAX(`idx`) as maxidx FROM `navigation`";
		$prepare2 = $this->conn->prepare($max);
		$prepare2->execute();
		$fetch2 = $prepare2->fetch(PDO::FETCH_ASSOC);
		$maxId = ($fetch2["maxidx"]) ? $fetch2["maxidx"] + 1 : 1;

		$max2 = "SELECT MAX(`position`) as maxidx FROM `navigation` WHERE `cid`=:cid AND `status`!=:one AND `nav_type`=:navType";
		$prepare3 = $this->conn->prepare($max2);
		$prepare3->execute(array(
			":cid"=>$input_cid,
			":one"=>1,
			":navType"=>$navtype
		));
		$fetch3 = $prepare3->fetch(PDO::FETCH_ASSOC);
		$maxPosition = ($fetch3["maxidx"]) ? $fetch3["maxidx"] + 1 : 1;

		$cid = $input_cid;
		$datex = time();
		$visibility = 0;
		$status = 0;

		foreach ($fetch as $val) {
			$insert = "INSERT INTO `navigation` SET 
			`idx`=:idx, 
			`cid`=:cid, 
			`date`=:datex, 
			`nav_type`=:nav_type,
			`type`=:type, 
			`title`=:title, 
			`description`=:description, 
			`text`=:textx, 
			`slug`=:slug, 
			`usefull_type`=:usefull_type, 
			`cssclass`=:cssclass, 
			`redirect`=:redirect, 
			`lang`=:lang, 
			`position`=:position,
			`visibility`=:visibility, 
			`status`=:status";
			$prepare2 = $this->conn->prepare($insert);
			$prepare2->execute(array(
				":idx"=>$maxId,
				":cid"=>$cid,
				":datex"=>$datex,
				":type"=>$type,
				":nav_type"=>(int)$navtype, 
				":title"=>$title,
				":description"=>$description,
				":textx"=>$textx,
				":slug"=>$slug,
				":usefull_type"=>$usefull_type,
				":cssclass"=>$cssclass,
				":redirect"=>$redirect,
				":lang"=>$val['title'],
				":position"=>$maxPosition,
				":visibility"=>$visibility,
				":status"=>$status
			));	

			if(count($args["serialPhotos"])){
				foreach ($args["serialPhotos"] as $pic) {
					if(!empty($pic)):
					$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
					$photoPerpare = $this->conn->prepare($photo);
					$photoPerpare->execute(array(
						":parent"=>$maxId, 
						":pathx"=>$pic, 
						":type"=>$type, 
						":lang"=>$val['title'], 
						":zero"=>0
					));
					endif;
				}
			}

			
		}

		if(count($args["serialFiles"])){
			$fileposition = 1;
			foreach ($args["serialFiles"] as $file) {
				if(!empty($file)):
				$explode = explode(",",$file); 
				$type = (isset($explode[0])) ? $explode[0] : "";
				$random = (isset($explode[1])) ? $explode[1] : "";
				$idx = (isset($explode[2])) ? $explode[2] : "";
				$cid = (isset($explode[3])) ? $explode[3] : "";
				$path = (isset($explode[4])) ? $explode[4] : "";

				if($type != "" && $random != "" && $idx != "" && $cid != "" && $path != ""){
					$files = 'UPDATE `file_system` SET `type`=:type, `random`=:clear, `page_id`=:page_id, `lang`=:lang, `position`=:position WHERE `idx`=:idx AND `cid`=:cid AND `random`=:random';
					$filePerpare = $this->conn->prepare($files);
					$filePerpare->execute(array(
					":clear"=>"", 
					":page_id"=>$maxId, 
					":position"=>$fileposition, 
					":lang"=>$current_lang,
					":idx"=>$idx, 
					":cid"=>$cid, 
					":random"=>$random, 
					":type"=>$type 
					));

					$fileposition++;					
				}
				
				endif;
			}
		}
		$this->clearCache();
		return 1;
	}

	private function edit($args)
	{
		require_once 'app/functions/files.php';

		$idx = $args["idx"];
		$lang = $args["lang"];
		$navtype = $args["chooseNavType"];
		$type = $args["choosePageType"];
		$title = $args["title"];
		$slug = $args["slug"];
		$cssclass = (isset($args["cssClass"])) ? $args["cssClass"] : "";
		$usefull_type = (isset($args["attachModule"])) ? $args["attachModule"] : "false";
		$redirect = $args["redirect"];
		$description = $args["pageDescription"];
		$textx = $args["pageText"];

		$update = "UPDATE `navigation` SET 
		`type`=:type, 
		`title`=:title, 
		`description`=:description, 
		`text`=:textx, 
		`slug`=:slug, 
		`usefull_type`=:usefull_type,
		`cssclass`=:cssclass,
		`redirect`=:redirect WHERE `idx`=:idx AND `lang`=:lang";
		$prepare = $this->conn->prepare($update);
		$prepare->execute(array(
			":type"=>$type,
			":title"=>$title,
			":description"=>$description,
			":textx"=>$textx,
			":slug"=>$slug,
			":usefull_type"=>$usefull_type,
			":cssclass"=>$cssclass,
			":redirect"=>$redirect,
			":idx"=>$idx, 
			":lang"=>$lang 
		));	
		
		$photos = new Database('photos', array(
			'method'=>'deleteByParent', 
			'idx'=>$idx, 
			'type'=>$type,  
			'lang'=>$lang  
		));

		if(count($args["serialPhotos"])){

			foreach($args["serialPhotos"] as $pic) {
				if(!empty($pic)):
				$photo = 'INSERT INTO `photos` SET `parent`=:parent, `path`=:pathx, `type`=:type, `lang`=:lang, `status`=:zero';
				$photoPerpare = $this->conn->prepare($photo);
				$photoPerpare->execute(array(
					":parent"=>$idx, 
					":pathx"=>$pic, 
					":type"=>$type, 
					":lang"=>$lang, 
					":zero"=>0
				));
				endif;
			}
		}


		// remove old files
		$removeFiles = "DELETE FROM `file_system` WHERE `page_id`=:page_id AND `type`=:type AND `lang`=:lang"; 
		$fileDeletePerpare = $this->conn->prepare($removeFiles);
		$fileDeletePerpare->execute(array(
			":page_id"=>$args["idx"], 
			":lang"=>$lang, 
			":type"=>"page"  
		));
		

		if(count($args["serialFiles"])){
			$fileposition = 1;
			foreach ($args["serialFiles"] as $file) {
				if(!empty($file)):
				$explode = explode(",",$file); 
				$type = (isset($explode[0])) ? $explode[0] : "";
				$random = (isset($explode[1])) ? $explode[1] : "";
				$idx = (isset($explode[2])) ? $explode[2] : "";
				$cid = (isset($explode[3])) ? $explode[3] : "";
				$path = (isset($explode[4])) ? $explode[4] : "";

				$fpath = Config::WEBSITE.Config::PUBLIC_FOLDER_NAME."/".$path;
				$file_size = functions\files::get_size($fpath);

				if($idx != "" && $cid != "" && $path != ""){
					$files = 'INSERT INTO `file_system` SET `date`=:datex, `idx`=:idx, `cid`=:cid, `page_id`=:page_id, `file_path`=:file_path, `file_size`=:file_size, `type`=:type, `lang`=:lang, `position`=:position';
					$filePerpare = $this->conn->prepare($files);
					$filePerpare->execute(array(
					":datex"=>time(), 
					":idx"=>$idx, 
					":cid"=>$cid, 
					":page_id"=>$args["idx"], 
					":file_path"=>$path, 
					":file_size"=>$file_size,
					":lang"=>$lang,
					":type"=>$type,
					":position"=>$fileposition					
					));

					$fileposition++;					
				}
				
				endif;
			}
		}
		$this->clearCache();
		return 1;
	}

	private function changePagePositions($args)
	{
		$unserialize = unserialize($args['unserialize']);
		if(is_array($unserialize) && count($unserialize))
		{
			$position = 1;
			foreach ($unserialize as $val) {
				$update = "UPDATE `navigation` SET `position`=:position WHERE `cid`=:cid AND `idx`=:idx AND `nav_type`=:navType"; 
				$prepare = $this->conn->prepare($update); 
				$prepare->execute(array(
					":cid"=>$args['input_cid'], 
					":navType"=>$args['navType'], 
					":position"=>$position, 
					":idx"=>$val
				));
				$position++;
			}
			$this->clearCache();
			return 1;	
		}
		return 0;
	}

	private function removePage($args)
	{
		$navType = $args['navType'];
		$position = $args['pos'];
		$idx = $args['idx'];
		$cid = (!isset($args['cid']) || $args['cid']==0) ? 0 : $args['cid'];

		$update = "UPDATE `navigation` SET `status`=:one WHERE `idx`=:idx";
		$prepare = $this->conn->prepare($update); 
		$prepare->execute(array(
			":one"=>1,
			":idx"=>$idx
		));
		if($prepare->rowCount()){
			$updateP = "UPDATE `products` SET `status`=:one WHERE `pid`=:idx";
			$prepareP = $this->conn->prepare($updateP); 
			$prepareP->execute(array(
				":one"=>1,
				":idx"=>$idx
			));

			$photoRemove = "UPDATE `photos` SET `status`=:one WHERE `parent`=:parent AND `type`=:type";
			$photoPrepare = $this->conn->prepare($photoRemove); 
			$photoPrepare->execute(array(
				":one"=>1,
				":parent"=>$idx,
				":type"=>"page"
			));

			$select = "SELECT `idx`, `position` FROM `navigation` WHERE `position`>:deletedItemPosition AND `nav_type`=:nav_type AND `cid`=:cid AND `status`!=:one";
			$prepare2 = $this->conn->prepare($select);
			$prepare2->execute(array(
				":deletedItemPosition"=>$position, 
				":nav_type"=>$navType, 
				":cid"=>$cid, 
				":one"=>1
			));
			if($prepare2->rowCount()){
				$fetch = $prepare2->fetchAll(PDO::FETCH_ASSOC);
				foreach ($fetch as $val) {
					$idx2 = $val['idx'];
					$newPosition = $val['position'] - 1;
					$update2 = "UPDATE `navigation` SET `position`=:newPosition WHERE `idx`=:idx2 AND `cid`=:cid";
					$prepare3 = $this->conn->prepare($update2);
					$prepare3->execute(array(
						":newPosition"=>$newPosition, 
						":idx2"=>$idx2, 
						":cid"=>$cid
					)); 
				}
			}
		}
		$this->clearCache();
		return 1;
	}

	private function clearCache()
	{
		$mask = Config::CACHE.'pages_*.*';
		array_map('unlink', glob($mask));

		$mask2 = Config::CACHE.'products_*.*';
		array_map('unlink', glob($mask2));
	}
}