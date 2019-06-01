<?php 
class file
{
	public function index($conn, $args)
	{
		$out = 0;
		$this->conn = $conn;
		if(method_exists("file", $args['method']))
		{
			// $out = $this->$args['method']($args);
			$string = "\$this->".$args['method']."(\$args);";
			$out = eval("return $string");
		}
		return $out;
	}

	public function add($args)
	{
		require_once 'app/core/Config.php';
		require_once 'app/functions/files.php';

		$idx = 1;
		$select = "SELECT MAX(`idx`) as maxid FROM `file_system`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$idx = (!$fetch['maxid']) ? 1 : ($fetch['maxid']+1);
		}

		$file_path = $args['path']; 
		$file = Config::WEBSITE.Config::PUBLIC_FOLDER_NAME."/".$args['path'];
		$file_size = functions\files::get_size($file);

		$insert = "INSERT INTO `file_system` SET 
		`date`=:datex, 
		`idx`=:idx, 
		`cid`=:cid, 
		`random`=:random, 
		`type`=:type, 
		`page_id`=:page_id, 
		`file_path`=:file_path, 
		`file_size`=:file_size 
		";
		$prepare2 = $this->conn->prepare($insert);
		$prepare2->execute(array(
			":datex"=>time(), 
			":idx"=>$idx, 
			":cid"=>0, 
			":random"=>$args['random'], 
			":type"=>$args['file_attach_type'], 
			":page_id"=>0, 
			":file_path"=>$file_path,  
			":file_size"=>$file_size  
		));
		if($prepare2->rowCount()){
			return $idx;
		}
		return 0;
	}

	public function addSub($args)
	{
		require_once 'app/core/Config.php';
		require_once 'app/functions/files.php';

		$idx = 1;
		$select = "SELECT MAX(`idx`) as maxid FROM `file_system`";
		$prepare = $this->conn->prepare($select);
		$prepare->execute();
		if($prepare->rowCount()){
			$fetch = $prepare->fetch(PDO::FETCH_ASSOC);
			$idx = (!$fetch['maxid']) ? 1 : ($fetch['maxid']+1);
		}

		$file_path = $args['path']; 
		$file = Config::WEBSITE.Config::PUBLIC_FOLDER_NAME."/".$args['path'];
		$file_size = functions\files::get_size($file);

		$insert = "INSERT INTO `file_system` SET 
		`date`=:datex, 
		`idx`=:idx, 
		`cid`=:cid, 
		`random`=:random, 
		`type`=:type, 
		`page_id`=:page_id, 
		`file_path`=:file_path, 
		`file_size`=:file_size 
		";
		$prepare2 = $this->conn->prepare($insert);
		$prepare2->execute(array(
			"datex"=>time(), 
			"idx"=>$idx, 
			"cid"=>$args['item'], 
			"random"=>$args['random'], 
			"type"=>$args['file_attach_type'], 
			"page_id"=>0, 
			"file_path"=>$file_path,  
			"file_size"=>$file_size  
		));
		if($prepare2->rowCount()){
			return $idx;
		}
		return 0;
	}

	public function removeFile($args)
	{
		$delete = "DELETE FROM `file_system` WHERE `idx`=:item OR `cid`=:item";
		$prepare = $this->conn->prepare($delete);
		$prepare->execute(array(
			":item"=>$args['item']
		));
		if($prepare->rowCount()){
			return 1;
		}
		return 0; 
	}

	public function removeFileByPageId($args)
	{
		$delete = "DELETE FROM `file_system` WHERE `page_id`=:page_id AND `type`=:type";
		$prepare = $this->conn->prepare($delete);
		$prepare->execute(array(
			":page_id"=>$args['page_id'], 
			":type"=>$args['type'] 
		));
		if($prepare->rowCount()){
			return 1;
		}
		return 0; 
	}	

	public function selectFilesPathById($args)
	{
		$fetch = ""; 
		$select = "SELECT `file_path` FROM `file_system` WHERE `idx`=:idx AND `type`=:type AND `lang`=:lang ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":idx"=>$args['idx'], 
			":lang"=>$args['lang'],  
			":type"=>$args['type']   
		));
		if($prepare->rowCount()){
			$f = $prepare->fetch(PDO::FETCH_ASSOC);
			$fetch = $f['file_path']; 
		}
		return $fetch;
	}
	

	public function selectFilesByPageId($args)
	{
		$fetch = array(); 
		$cid = (isset($args['cid'])) ? $args['cid'] : 0;
		$select = "SELECT * FROM `file_system` WHERE `cid`=:zero AND `type`=:type AND `page_id`=:page_id AND `lang`=:lang ORDER BY `id` ASC";
		$prepare = $this->conn->prepare($select);
		$prepare->execute(array(
			":zero"=>$cid, 
			":page_id"=>$args['page_id'], 
			":lang"=>$args['lang'],  
			":type"=>$args['type']   
		));
		if($prepare->rowCount()){
			$fetch = $prepare->fetchAll(PDO::FETCH_ASSOC);
		}
		return $fetch;
	}
}