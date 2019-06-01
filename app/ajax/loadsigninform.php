<?php 
class loadsigninform
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

		$html = "<form action=\"javascript:void(0)\" method=\"post\" id=\"signinForm\" name=\"signinForm\">";
		$html .= "<section class=\"alert alert-warning signin-error-message\" style=\"display: none\"></section>";
		$html .=	"<div class=\"input-group\">";
		$html .= sprintf(
			"<input type=\"text\" class=\"form-control\" name=\"email\" autocomplete=\"off\" placeholder=\"%s\" />",
			$l->translate("email", $lang)
		);
		$html .= "</div>"; 

		$html .= "<div class=\"input-group\">"; 
 		$html .= sprintf(
 			"<input type=\"password\" class=\"form-control\" name=\"password\" autocomplete=\"off\" placeholder=\"%s\" />",
 			$l->translate("password", $lang)
 		);
		$html .= "</div>"; 
		$html .= sprintf(
			"<button class=\"signinbutton\">%s</button>",
			$l->translate("signin", $lang)
		); 
		$html .= "</form>";

		$html .= "<p>";
		$html .= sprintf(
			"<a href=\"javascript:void(0)\" class=\"recoverPassword\" data-boxtitle=\"%s\">%s</a> / ",
			$l->translate("recoverpassword", $lang),
			$l->translate("recoverpassword", $lang)
		);
		$html .= sprintf(
			"<a href=\"javascript:void(0)\"  class=\"createAccount\" data-boxtitle=\"%s\">%s</a>",
			$l->translate("createnewaccount", $lang),
			$l->translate("createnewaccount", $lang)
		);
		$html .= "</p>"; 


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