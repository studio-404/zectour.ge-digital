<?php 
class addcomment
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$commentId = filter_var(functions\request::index("POST","commentId"), FILTER_SANITIZE_NUMBER_INT);
		$firstname = strip_tags(functions\request::index("POST","firstname"));
		$organization = strip_tags(functions\request::index("POST","organization"));
		$email = strip_tags(functions\request::index("POST","email"));
		$comment = strip_tags(functions\request::index("POST","comment"));
		$csrf = strip_tags(functions\request::index("POST","csrf"));
		$lang = strip_tags(functions\request::index("POST","lang"));

		if($commentId=="" || $firstname=="" || $organization=="" || $email=="" || $comment=="" || $lang=="" || $csrf=="")
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
			$Database = new Database("comments", array(
				"method"=>"insert",
				"commentId"=>$commentId, 
				"firstname"=>$firstname, 
				"organization"=>$organization, 
				"email"=>$email, 
				"comment"=>$comment, 
				"lang"=>$lang  
			));
			if($Database->getter()){
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>""
					),
					"Success"=>array(
						"Code"=>1, 
						"Text"=>"ოპერაცია შესრულდა წარმატებით !",
						"Details"=>""
					)
				);
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"ოპერაციის შესრულებისას დაფიქსირდა შეცდომა !",
						"Details"=>""
					)
				);
			}
		}
		return $this->out;	
	}
}