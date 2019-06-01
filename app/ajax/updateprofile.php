<?php 
class updateprofile
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
			empty($values["firstname"]) ||
			empty($values["lastname"]) ||
			empty($values["dob"]) ||
			empty($values["gender"]) ||
			empty($values["country"]) ||
			empty($values["city"]) ||
			empty($values["phone"]) ||
			empty($values["postcode"]) 
		){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errorallfieldsrequire", $lang);
		}else{
			$dob = explode("/", $values["dob"]); // mm / dd / yyyy
			$dob = sprintf("%s-%s-%s", $dob[2], $dob[0], $dob[1]);

			$user_exists = new Database("user", array(
				"method"=>"update", 
				"firstname"=>$values["firstname"], 
				"lastname"=>$values["lastname"], 
				"dob"=>$dob, 
				"gender"=>$values["gender"], 
				"country"=>$values["country"], 
				"city"=>$values["city"], 
				"phone"=>$values["phone"], 
				"postcode"=>$values["postcode"] 
			));

			if($user_exists->getter()){
				$error = 0;
				$Success = 1;
	  			$errorText = $l->translate("errornull", $lang);
	  		}else{
	  			$error = 1;
				$Success = 0;
	  			$errorText = $l->translate("error", $lang);
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
				"Details"=>""
			)
		);

		return $this->out;
	}
}