<?php
class bookFinalStep
{
	public $out; 
	
	public function __construct()
	{

	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/l.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/sendEmail.php';
		require_once 'app/functions/server.php';

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
		$l = new functions\l();
		$bookid = functions\request::index("POST","bookid");
		$formtype = functions\request::index("POST","formtype");

		$liter = functions\request::index("POST","liter");
		$shtuk = functions\request::index("POST","shtuk");
		$sutka = functions\request::index("POST","sutka");
		$booktitle = functions\request::index("POST","booktitle");
		$tourist_points = functions\request::index("POST","tourist_points");
		$token = functions\request::index("POST","token");
		$date = functions\request::index("POST","date");
		$time = functions\request::index("POST","time");
		$adult = functions\request::index("POST","adult");
		$child = functions\request::index("POST","child");

		$dynamic2adults = functions\request::index("POST","dynamic2adults");
		$dynamic2child5 = functions\request::index("POST","dynamic2child5");
		$dynamic2child12 = functions\request::index("POST","dynamic2child12");
		$dynamic2child16 = functions\request::index("POST","dynamic2child16");


		$firstname = functions\request::index("POST","firstname");
		$tp = functions\request::index("POST","tp");
		$mobile = functions\request::index("POST","mobile");

		$email = functions\request::index("POST","email");
		$address = functions\request::index("POST","address");
		// $questions = functions\request::index("POST","questions");

		if($_SESSION["booktoken"]!=$token)
		{
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
		}else if(
			(is_numeric($formtype) || $formtype=="dynamic") && 
			(
				$bookid=="" || 
				$date=="" || 
				$time=="" ||
				$adult=="" || 
				$child=="" || 				 
				$firstname=="" || 
				$mobile==""
			) 
		){
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
		}else if(
			$formtype=="alcohol" && 
			(
				$bookid=="" || 
				$date=="" || 
				$time=="" || 				 
				$liter=="" || 				 
				$firstname=="" || 
				$mobile==""
			)

		){
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

			$body .= sprintf("<strong>Какова числа за вами заехать?</strong>: %s<br />", $date);
			$body .= sprintf("<strong>В каком часу заехать за вами?</strong>: %s<br />", $time);
			switch ($formtype) {
				case 'dynamic2':
					$body .= sprintf("<a href=\"%sru/view/?id=%s\" target=\"_blank\" style=\"font-size: 22px; text-decoration:none\">%s</a><br />", Config::WEBSITE, $bookid, $booktitle);
					$body .= sprintf("<strong>Количество взрослых?</strong>: %s<br />", $dynamic2adults);
					$body .= sprintf("<strong>Количество дети до 5 лет?</strong>: %s<br />", $dynamic2child5);
					$body .= sprintf("<strong>Количество дети до 12 лет?</strong>: %s<br />", $dynamic2child12);
					$body .= sprintf("<strong>Количество дети старше 12 лет?</strong>: %s<br />", $dynamic2child16);
					break;
				case 'alcohol':
					$body .= sprintf("<a href=\"%sru/view/?id=%s\" target=\"_blank\" style=\"font-size: 22px; text-decoration:none\">%s</a><br />", Config::WEBSITE, $bookid, $booktitle);
					$body .= sprintf("<strong>Сколко литров желаете?</strong>: %s<br />", $liter);
					break;
				case 'simcard':
					$body .= sprintf("<a href=\"%sru/view/?id=%s\" target=\"_blank\" style=\"font-size: 22px; text-decoration:none\">%s</a><br />", Config::WEBSITE, $bookid, $booktitle);
					$body .= sprintf("<strong>Сколко штук желаете ?</strong>: %s<br />", $shtuk);
					break;
				case 'rentcar':
					$body .= sprintf("<a href=\"%sru/view/?id=%s\" target=\"_blank\" style=\"font-size: 22px; text-decoration:none\">%s</a><br />", Config::WEBSITE, $bookid, $booktitle);
					$body .= sprintf("<strong>Сколко сутох желаете ?</strong>: %s<br />", $sutka);
					break;				
				default:
					$forText = ($tourist_points!="dynamic") ? sprintf("(%s %s)", $l->translate("for"), $tourist_points) : "";

					$body .= sprintf("<a href=\"%sru/view/?id=%s\" target=\"_blank\" style=\"font-size: 22px; text-decoration:none\">%s %s</a><br />", Config::WEBSITE, $bookid, $booktitle, $forText);
					$body .= sprintf("<strong>Количество взрослых?</strong>: %s<br />", $adult);
					if($tourist_points=="dynamic"){
						$body .= sprintf("<strong>Количество детей?</strong>: %s<br />", $child);
					}
					break;
			}

			$body .= sprintf("<strong>Ваше имя?</strong>: %s<br />", $firstname);
			$body .= sprintf("<strong>Ваш мобильный (Viber и WhatsApp)?</strong>: %s<br />", $mobile);
			$body .= sprintf("<strong>Ваша электронная почта?</strong>: %s<br />", $email);
			$body .= sprintf("<strong>Адрес, куда подьехать?</strong>:<br />%s<br /><br />", $address);
			$body .= sprintf("<strong>Общая цена:</strong>:%s %s<br /><br />", $tp, $_SESSION['currency']);
			
			$subject = sprintf("zectour.ge - %s %s", $date, $time);
			$sendEmail->index(array(
				"sendTo"=>Config::RECIEVER_EMAIL, // 
				"subject"=>$subject,
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
					"Text"=>"Ваша заявка принята в ближайшее время я свяжусь с вами !",
					"Details"=>""
				)
			);
			
		}

		return $this->out;
	}
}