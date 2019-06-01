<?php 
class registerEvent
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/send.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$input_event_id = functions\request::index("POST","evid");
		$input_event_name = strip_tags(functions\request::index("POST","evn"));
		$event_url = sprintf(
			"%s%s/event/%s/%s",
			Config::WEBSITE,
			Config::MAIN_LANG,
			$input_event_id,
			str_replace(" ", "-", $input_event_name)
		);
		$input_name = strip_tags(functions\request::index("POST","input_name"));
		$input_organization = strip_tags(functions\request::index("POST","input_organization"));
		$input_email = strip_tags(functions\request::index("POST","input_email"));
		$input_phone = strip_tags(functions\request::index("POST","input_phone"));
		$csrf = strip_tags(functions\request::index("POST","csrf"));

		if($input_name=="" || $input_organization=="" || $input_email=="" || $input_phone=="" || $csrf=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა, ყველა ველი სავალდებულოა !",
					"Details"=>"!"
				)
			);
		}else if($_SESSION['protect_x']!=$csrf)
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}else{
			$send = new functions\send(); 

			$a["sendTo"] = Config::RECIEVER_EMAIL; 
			$a["subject"] = "Register Event";
			$a["body"] = sprintf(
				"<strong>Event ID</strong>: %s<br />", 
				$input_event_id
			);
			$a["body"] .= sprintf(
				"<strong>Event Name</strong>: %s<br />", 
				$input_event_name
			);
			$a["body"] .= sprintf(
				"<strong>Event Url</strong>: <a href=\"%s\">Go To</a><br />", 
				$event_url
			);
			$a["body"] .= sprintf(
				"<strong>First Name</strong>: %s<br />", 
				$input_name
			);
			$a["body"] .= sprintf(
				"<strong>Organization</strong>: %s<br />", 
				$input_organization
			);
			$a["body"] .= sprintf(
				"<strong>Email</strong>: %s<br />", 
				$input_email
			);
			$a["body"] .= sprintf(
				"<strong>Phone</strong>: %s<br />", 
				$input_phone
			);

			$sended = $send->index($a);
			if($sended)
			{
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					),
					"Success" => array(
						"Code"=>1, 
						"Text"=>"ოპერაცია წარმატებით შესრულდა !",
						"Details"=>"!"
					)
				);
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"მოხდა შეცდომა !",
						"Details"=>"!"
					)
				);
			}
		}	
		return $this->out;		
	}
}