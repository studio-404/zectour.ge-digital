<?php 
class signin
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

		$lang = htmlentities(strip_tags(functions\request::index("POST","lang")));
		$serialize = functions\request::index("POST","serialize");
		
		parse_str($serialize, $values);


		if(
			empty($values["email"]) OR 
			empty($values["password"]) 
		){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errorallfieldsrequire", $lang);
		}else if (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("erroremail", $lang);
		}else{
			$user_exists = new Database("user", array(
				"method"=>"check", 
				"user"=>$values["email"],
				"pass"=>$values["password"]
			));

			if($user_exists->getter()){
				$error = 0;
				$Success = 1;
	  			$errorText = $l->translate("errornull", $lang);
	  			$_SESSION[Config::SESSION_PREFIX."web_username"] = $values["email"];
			}else{
				$error = 1;
				$Success = 0;
	  			$errorText = $l->translate("errornosignin", $lang);
			}
		}

		$this->out = array(
			"Error" => array(
				"Code"=>$error, 
				"Text"=>$errorText,
				"Details"=>""
			),
			"Success"=>array(
				"Code"=>$Success, 
				"Text"=>$errorText,
				"GoToUrl"=>Config::WEBSITE.$lang."/myaccount/?view=profile",
				"Details"=>""
			)
		);

		return $this->out;
	}
}