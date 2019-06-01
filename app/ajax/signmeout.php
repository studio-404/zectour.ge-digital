<?php 
class signmeout
{
	public $out; 

	public function __construct()
	{
		require_once 'app/core/Config.php';
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/l.php';
		$l = new functions\l();

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$lang = functions\request::index("POST","lang");


		unset($_SESSION[Config::SESSION_PREFIX."web_username"]);

		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"empty",
				"Details"=>""
			),
			"Success"=>array(
				"Code"=>1, 
				"Text"=>"Success",
				"GoToUrl"=>Config::WEBSITE.$lang."/".Config::MAIN_CLASS,
				"Details"=>""
			)
		);

		return $this->out;
	}
}