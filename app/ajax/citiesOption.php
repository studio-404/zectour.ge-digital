<?php 
class citiesOption
{
	public $out; 
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			),
			"Success"=>array(
						"Code"=>1, 
						"Text"=>"ოპერაცია შესრულდა წარმატებით !",
						"Details"=>"",
						"html"=>""
			)
		);

		$selected = functions\request::index("POST","selected");
		
		

		if($selected != "")
		{
			$Database = new Database('cities', array(
					'method'=>'select'
			));
			$output = $Database->getter();
			$options = "";
			foreach ($output as $val) {
				$active = ($val['id'] == $selected) ? 'selected="selected"' : ''; 
				$options .= "<option value=\"".$val['id']."\" ".$active.">".$val['names']."</option>";
			}

			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>1, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>"",
					"html"=>$options 
				)
			);

		}

		return $this->out;
	}
}