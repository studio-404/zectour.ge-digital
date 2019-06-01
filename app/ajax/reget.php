<?php 
class reget
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
			"Success" => array(
				"Code"=>0,
				"Text"=>"",
				"Details"=>""
			)
		);
		$personal_number = $_SESSION["capex_user"];
		$money = functions\request::index("POST","money");
		$month = functions\request::index("POST","month");

		/**
		**	DO JOB
		*/
		$history = new Database("statements", array(
			"method"=>"history", 
			"personal_number"=>$personal_number
		));
		if($history->getter())
		{
			$regetMoney = new Database("statements", array(
				"method"=>"regetMoney", 
				"money"=>$money,
				"month"=>$month,
				"personal_number"=>$personal_number
			));

			if($regetMoney->getter())
			{
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"" 
					), 
					"Success" => array(
						"Code"=>1,
						"Text"=>"ოპერაცია წარმატებით შესრულდა !",
						"Details"=>""
					)
				);
			}

			
		}


		
		return $this->out;
	}
}