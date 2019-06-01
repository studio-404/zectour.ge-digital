<?php 
class removeFavourite
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

		$tourid = filter_var(functions\request::index("POST","tourid"), FILTER_SANITIZE_NUMBER_INT);
		
		if(!isset($_SESSION[Config::SESSION_PREFIX."web_username"]))
		{
			$this->out = array(
				"Success" => array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>"!"
				),
				"Error" => array(
					"Code"=>1, 
					"Text"=>$l->translate("pleaselogin"),
					"Details"=>"!"
				)
			);
		}else{

			$favourites = new Database("favourites", array(
				"method"=>"remove", 
				"user"=>$_SESSION[Config::SESSION_PREFIX."web_username"],
				"tour_id"=>$tourid
			));

			if($favourites->getter()){
				$this->out = array(
					"Success" => array(
						"Code"=>1, 
						"Text"=>$l->translate("errornull"),
						"Details"=>"!"
					),
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					)
				);
			}else{
				$this->out = array(
					"Success" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					),
					"Error" => array(
						"Code"=>1, 
						"Text"=>$l->translate("error"),
						"Details"=>"!"
					)
				);
			}			
		}

		
		return $this->out;
	}
}