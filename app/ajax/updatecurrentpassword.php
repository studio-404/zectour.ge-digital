<?php 
class updatecurrentpassword
{
	public $out; 

	public function __construct()
	{
		if(
			!isset($_SESSION[Config::SESSION_PREFIX."web_username"]) 
		)
		{
			require_once 'app/functions/redirect.php';
			functions\redirect::url(Config::WEBSITE.$_SESSION["LANG"]."/home");
		}
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
		$serialize = functions\request::index("POST","serialize");
		
		parse_str($serialize, $values);


		if(
			empty($values["cpoassword"]) ||
			empty($values["npassword"]) ||
			empty($values["cnpassword"])
		){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errorallfieldsrequire", $lang);
		}else if(preg_match('/\s/', $values["npassword"]) || strlen(trim($values["npassword"])) < 8){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errorpasswordwrong", $lang);
		}else if($values["npassword"] != $values["cnpassword"]){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errornomatchpasswords", $lang);
		}else{
			$checkpassword = new Database("user", array(
				"method"=>"checkpassword", 
				"current_password"=>$values["cpoassword"]
			));

			if($checkpassword->getter()){

				$updatepassword = new Database("user", array(
					"method"=>"updatepassword", 
					"password"=>$values["npassword"]
				));

				if($updatepassword->getter()){
					$error = 0;
					$Success = 1;
		  			$errorText = $l->translate("errornull", $lang);
	  			}else{
	  				$error = 1;
					$Success = 0;
	  				$errorText = $l->translate("error", $lang);
	  			}
	  			

			}else{
				$error = 1;
				$Success = 0;
	  			$errorText = $l->translate("erroroldpass", $lang);
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