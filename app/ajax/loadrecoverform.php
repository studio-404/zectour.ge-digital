<?php 
class loadrecoverform
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

		$lang = strip_tags(functions\request::index("POST","lang"));


		$html =	"<form action=\"javascript:void(0)\" method=\"post\" id=\"recoverPasswordForm\">";
		$html .= "<section class=\"alert alert-warning recover-error-message\" style=\"display: none\"></section>";
		$html .= "<div class=\"input-group\">";
		$html .= sprintf(
			"<input type=\"text\" class=\"form-control\" autocomplete=\"off\" name=\"email\" placeholder=\"%s\" />",
			$l->translate("email", $lang)
		);
		$html .= "</div>"; 

		
		$html .= sprintf(
			"<button class=\"recoverbutton\">%s</button>",
			$l->translate("recover", $lang)
		); 
		$html .= "</form>"; 
		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>""
			),
			"Success"=>array(
				"Code"=>1, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"form"=>$html,
				"Details"=>""
			)
		);

		return $this->out;
	}
}