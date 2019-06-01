<?php 
class changeCurrency
{
	public $out;

	public function index()
	{
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$cur = functions\request::index("POST","cur");

		if(empty($cur)){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა",
					"Details"=>""
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				)
			);
		}else{
			$_SESSION['currency'] = $cur;
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
		}


		return $this->out;
	}
}