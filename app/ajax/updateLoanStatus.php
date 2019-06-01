<?php 
class updateLoanStatus
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
	
	public function index()
	{
		// require_once 'app/core/Config.php';
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

		$loanStatus = functions\request::index("POST","loanStatus");
		$spid = functions\request::index("POST","spid");

		$loanStatus2 = functions\request::index("POST","loanStatus2");
		$spid2 = functions\request::index("POST","spid2");

		if(!empty($loanStatus) && !empty($spid))
		{
			$Database = new Database("statements", array(
				"method"=>"updateLoanStatus", 
				"pid"=>$spid,
				"status"=>$loanStatus
			));
			if($Database->getter())
			{
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					), 
					"Success" => array(
						"Code"=>1,
						"Text"=>"ოპერაცია წარმატებით შესრულდა !",
						"Details"=>""
					)
				);
			}
		}

		if(!empty($loanStatus2) && !empty($spid2))
		{
			$Database = new Database("statements", array(
				"method"=>"updateLoanStatus", 
				"pid2"=>$spid2,
				"status2"=>$loanStatus2
			));
			if($Database->getter())
			{
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
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