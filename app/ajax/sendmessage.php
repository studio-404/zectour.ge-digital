<?php 
class sendmessage
{
	public $out; 

	public function __construct()
	{

	}
	
	public function index(){
		require_once 'app/functions/server.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/sendEmail.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"Произошла ошибка !",
				"Details"=>"!"
			),
			"Success"=>array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>""
			)
		);

		$contacttoken = functions\request::index("POST","contacttoken");
		$firstname = functions\request::index("POST","firstname");
		$email = functions\request::index("POST","email");
		$message = functions\request::index("POST","message");

		if($_SESSION["contacttoken"]!=$contacttoken){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"Произошла фатальная ошибка !",
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if($firstname=="" || $email=="" || $message==""){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"Пожалуйста, заполните обязательные поля !",
					"Details"=>"!"
				), 
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				)
			);
		}else{
			$sendEmail = new functions\sendEmail();
			$server = new functions\server();
			
			$body = "";
			$body .= sprintf("<strong>IP адрес</strong>: %s<br />", $server->ip());
			$body .= sprintf("<strong>Имя</strong>: %s<br />", $firstname);
			$body .= sprintf("<strong>Эл. адрес</strong>: %s<br /><br />", $email);
			$body .= sprintf("<strong>Сообщение</strong>:<br /> %s", $message);
			
			$sendEmail->index(array(
				"sendTo"=>Config::RECIEVER_EMAIL,
				"subject"=>"Сообщение - ZEC TOUR",
				"body"=>$body,
			));
			
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"",
					"Details"=>""
				),
				"Success"=>array(
					"Code"=>1, 
					"Text"=>"Операция прошла успешно !",
					"Details"=>""
				)
			);
		}



		return $this->out;
	}
}