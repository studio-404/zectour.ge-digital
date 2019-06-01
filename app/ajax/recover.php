<?php 
class recover
{
	public $out; 

	public function __construct()
	{

	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/l.php';
		require_once 'app/functions/sendEmail.php';
		require_once 'app/functions/string2.php';
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
			empty($values["email"]) 
		){
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("errorallfieldsrequire", $lang);
		}else if (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
			$error = 1;
			$Success = 0;
  			$errorText = $l->translate("erroremail", $lang);
		}else{
			$email = str_replace("%40", "@", $values["email"]);

			$check_user_exists = new Database("user", array(
				"method"=>"check_user_exists", 
				"username"=>$email,
			));

			if($check_user_exists->getter()){
				$error = 0;
				$Success = 1;
	  			$errorText = $l->translate("checkemail", $lang);
	  			
	  			/* update users recover password & send email */
	  			$md5sha1 = functions\string2::random(9);

	  			$db_update_recovery = new Database("user", array(
					"method"=>"updaterecover",
					"user"=>$email,
					"pass"=>$md5sha1
				));

				$body = sprintf(
					"%s: <strong>%s</strong>",
					$l->translate("yournewpasswordis", $lang),
					$md5sha1
				);

	  			$args = array(
	  				"sendTo"=>$email,
	  				"subject"=>Config::NAME,
	  				"body"=>$body
	  			);
	  			$sendEmail = new functions\sendEmail();
	  			$sendEmail->index($args);

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