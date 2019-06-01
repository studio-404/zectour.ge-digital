<?php 
class subscribeToNewsletter
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


		$newsletterEmail = functions\request::index("POST","newsletterEmail");
		$token = functions\request::index("POST","token");
		$lang = htmlentities(strip_tags(functions\request::index("POST","lang")));

		if($newsletterEmail=="" || $token=="" || $lang=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>$l->translate("errorallfieldsrequire", $lang),
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if($token!=$_SESSION["newsletterToken"]){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>$l->translate("error", $lang),
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if (!filter_var($newsletterEmail, FILTER_VALIDATE_EMAIL)) {
  			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>$l->translate("erroremail", $lang),
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				)
			);
		}else{
			$newsletter = new Database('newsletter', array(
					'method'=>'check', 
					'email'=>$newsletterEmail
			));

			if($newsletter->getter()){
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>$l->translate("emailalreadyexists", $lang),
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>""
					)
				);
			}else{
				$insertEmail = new Database('newsletter', array(
					'method'=>'add', 
					'email'=>$newsletterEmail
				));

				if($insertEmail->getter()){
					$this->out = array(
						"Error" => array(
							"Code"=>0, 
							"Text"=>"",
							"Details"=>""
						),
						"Success"=>array(
							"Code"=>1, 
							"Text"=>$l->translate("errornull", $lang),
							"Details"=>""
						)
					);
				}else{
					$this->out = array(
						"Error" => array(
							"Code"=>1, 
							"Text"=>$l->translate("error", $lang),
							"Details"=>""
						),
						"Success"=>array(
							"Code"=>0, 
							"Text"=>"",
							"Details"=>""
						)
					);
				}
			}		
			
		}

		return $this->out;
	}
}