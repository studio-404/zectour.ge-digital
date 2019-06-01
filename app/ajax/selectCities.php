<?php 
class selectCities
{
	public $out; 

	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			),
			"Success"=> array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>"!"
			)
		);

		$regionId = (int)functions\request::index("POST","regionId");
		$lang = functions\request::index("POST","lang");

		$Database = new Database("georgia", array(
			"method"=>"select", 
			"cid"=>$regionId, 
			"lang"=>$lang, 
			"itemPerPage"=>100
		));
		if($lang=="ge"){
			$options = "<option value=\"\">ქალაქი</option>";
		}else{
			$options = "<option value=\"\">City</option>";
		}
		

		if($Database->getter()){
			foreach ($Database->getter() as $value) {
				$options .= sprintf(
					"<option value=\"%s\">%s</option>", 
					$value['idx'],
					$value['name']
				);
			}
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				),
				"Success"=> array(
					"Code"=>1, 
					"Text"=>"ოპერაცია წარმატებით დასრულდა !",
					"Details"=>"!", 
					"options"=>$options
				)
			);
		}


		return $this->out;
	}
}