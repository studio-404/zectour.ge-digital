<?php 
class recoverEmail
{
	public $out; 

	public function index()
	{
		require_once 'app/functions/request.php';
		require_once 'app/functions/string2.php';
		require_once "app/functions/sendEmail.php";

		$secure = functions\request::index("POST","secure");
		$email = functions\request::index("POST","email");

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			), 
			"Success" => array(
				"Code"=>0,
				"Text"=>"",
				"Details"=>""
			)
		);

		if($_SESSION['capex_secure'] == $secure){

			$args["sendTo"] = $email; 
			$args["subject"] = "პაროლის აღდგენა";

			$string = new functions\string2();
			$password = $string::random(10);

			$message = "<strong>პაროლის აღდგენა</strong>";
			$message .= "<p>თქვენი დროებითი პაროლია: {$password}</p>";

			$args["body"] = $message; 
			$sendEmail = new functions\sendEmail();

			$Database = new Database("statements", array(
				"method"=>"chnageRecover", 
				"email"=>$email, 
				"recover"=>$password
			));
			$output = $Database->getter();

			if($output && $sendEmail->index($args)){
				$this->out = array(
					"Error" => array(
						"Code"=>0, 
						"Text"=>"",
						"Details"=>"!"
					), 
					"Success" => array(
						"Code"=>1,
						"Text"=>"ოპერაცია წარმატებით შესრულდა, გადაამოწმეთ ელ-ფოსტა !",
						"Details"=>""
					)
				);
			}
		}
		return $this->out;
	}
}