<?php 
class updateColume
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
			), 
			"Success" => array(
				"Code"=>0,
				"Text"=>"",
				"Details"=>""
			)
		);
		$col = functions\request::index("POST","col");
		$pid = functions\request::index("POST","pid");
		$value = functions\request::index("POST","value");

		/**
		**	DO JOB
		*/
		if($col != "" && $pid != "")
		{
			$updatecolumne = new Database("statements", array(
				"method"=>"updatecolumne", 
				"col"=>$col,
				"personal_number"=>$pid,
				"value"=>$value
			));

			if($updatecolumne->getter())
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