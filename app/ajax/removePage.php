<?php 
class removePage
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
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$navType = functions\request::index("POST","navType");
		$pos = functions\request::index("POST","pos");
		$idx = functions\request::index("POST","idx");
		$cid = functions\request::index("POST","cid");
		

		if($navType=="" || $pos=="" || $idx=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('page', array(
					'method'=>'removePage', 
					'navType'=>$navType, 
					'pos'=>$pos, 
					'idx'=>$idx, 
					'cid'=>$cid  
			));

			$DatabaseFile = new Database('file', array(
					'method'=>'removeFileByPageId', 
					'page_id'=>$idx, 
					'type'=>"page" 
			));

			if($Database->getter()==1){
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
		}

		return $this->out;
	}
}