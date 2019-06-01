<?php 
class removeFile
{
	public $out; 
	
	public function __construct()
	{
		require_once 'app/core/Config.php';
		if(!isset($_SESSION[Config::SESSION_PREFIX."username"]))
		{
			exit();
		}
	}

	public function index(){
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);
		$item = functions\request::index("POST","item");
		$output = false;

		if($item=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				)
			);
		}else{			
			$Database = new Database('file', array(
					'method'=>'removeFile', 
					'item'=>$item 
			));
			$output = $Database->getter();
		}

		if($output){
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				),
				"Success"=>array(
					"Code"=>1, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>"" 
				)
			);
		}else{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ოპერაციის შესრულებისას დაფიქსირდა შეცდომა !",
					"Details"=>""
				)
			);
		}

		return $this->out;
	}
}