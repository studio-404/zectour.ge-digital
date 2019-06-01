<?php 
class mycart
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/l.php';

		$l = new functions\l();

		$lang = functions\request::index("POST","lang");

		if(isset($_SESSION[Config::SESSION_PREFIX."web_username"])){
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>"!"
				),
				"Success" => array(
					"Code"=>1, 
					"Text"=>"",
					"Details"=>"!",
					"GoToUrl"=>Config::WEBSITE.$lang."/myaccount/?view=purchases"
				)
			);
		}else{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>$l->translate("pleaselogin", $lang),
					"Details"=>"!"
				),
				"Success" => array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>"!"
				)
			);
		}

		return $this->out;
	}
}