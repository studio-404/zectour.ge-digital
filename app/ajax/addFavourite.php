<?php 
class addFavourite
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


		$lang = strip_tags(htmlentities(functions\request::index("POST","lang")));
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
					"Text"=>$l->translate("pleaselogin", $lang),
					"Details"=>"!"
				)
			);
		}else{

			$favourites = new Database("favourites", array(
				"method"=>"check", 
				"user"=>$_SESSION[Config::SESSION_PREFIX."web_username"],
				"tour_id"=>$tourid
			));

			if($favourites->getter()){
				$favouriteRemove = new Database("favourites", array(
					"method"=>"remove", 
					"user"=>$_SESSION[Config::SESSION_PREFIX."web_username"],
					"tour_id"=>$tourid
				));

				$this->out = array(
					"Success" => array(
						"Code"=>1, 
						"Text"=>$l->translate("errornull", $lang),
						"Status"=>"off",
						"StatusText"=>$l->translate("favourite", $lang), 
						"Details"=>"!"
					),
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					)
				);
			}else{

				$favouriteAdd = new Database("favourites", array(
					"method"=>"insertFavourite", 
					"user"=>$_SESSION[Config::SESSION_PREFIX."web_username"],
					"tour_id"=>$tourid
				));

				$this->out = array(
					"Success" => array(
						"Code"=>1, 
						"Text"=>$l->translate("errornull", $lang),
						"Status"=>"on",
						"StatusText"=>$l->translate("removefavourite", $lang), 
						"Details"=>"!"
					),
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					)
				);
			}

			
		}

		
		return $this->out;
	}
}