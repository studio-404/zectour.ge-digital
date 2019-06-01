<?php 
class loadcreateaccountform
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/l.php';
		require_once 'app/functions/countrynames.php';

		$l = new functions\l();

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);
		$html = "";

		$lang = strip_tags(functions\request::index("POST","lang"));

		$html .= "<form action=\"javascript:void(0)\" method=\"post\" id=\"createAccountForm\" name=\"createAccountForm\">";
		
		$html .= "<section class=\"alert alert-warning register-error-message\" style=\"display: none\"></section>";
		$html .= "<div class=\"input-group\">";
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

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"password\" class=\"form-control\" name=\"comfirmpassword\" autocomplete=\"off\" placeholder=\"%s\" />",
 			$l->translate("comfirmpassword", $lang)
 		);
		$html .= "</div>"; 

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control\" name=\"firstname\" autocomplete=\"off\" placeholder=\"%s\" />",
 			$l->translate("firstname", $lang)
 		);
		$html .= "</div>"; 

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control\" name=\"lastname\" autocomplete=\"off\" placeholder=\"%s\" />",
 			$l->translate("lastname", $lang)
 		);
		$html .= "</div>"; 

		$html .= "<section class=\"dateBox\">";
		$html .= sprintf(
			"<input type=\"text\" class=\"form-control date\" name=\"dob\" autocomplete=\"off\" value=\"\" placeholder=\"%s\" readonly=\"readonly\" />",
			$l->translate("dob", $lang)
		);
		$html .= "</section>";

		$html .= "<input type=\"hidden\" name=\"gender\" id=\"gender\" value=\"\" />";
		$html .= "<select class=\"selectpicker gend\" data-live-search=\"true\">";
		$html .= sprintf(
			"<option value=\"\">%s</option>",
			$l->translate("gender", $lang)
		);
		$html .= sprintf(
			"<option value=\"1\">%s</option>",
			$l->translate("male", $lang)
		);

		$html .= sprintf(
			"<option value=\"2\">%s</option>",
			$l->translate("female", $lang)
		);
		
		$html .= "</select>";

		/* Countries Start */
		// $Database = new Database('countries', array(
		// 		'method'=>'select', 
		// 		'lang'=>$lang
		// ));
		// $output = $Database->getter();

		
		$html .= "<input type=\"hidden\" name=\"country\" id=\"country\" value=\"\" />";
		$html .= "<select class=\"selectpicker coun\" data-live-search=\"true\" >";
		$html .= sprintf(
			"<option value=\"\">%s</option>",
			$l->translate("country", $lang)
		);
		
		$countryNames = new functions\countrynames();
		$html .= $countryNames->options($lang);

		$html .= "</select>";
		/* Countries End */

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control\" placeholder=\"%s\" autocomplete=\"off\" name=\"city\" />",
 			$l->translate("city", $lang) 
 		);
		$html .= "</div>"; 

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control\" placeholder=\"%s\" autocomplete=\"off\" name=\"phone\" />",
 			$l->translate("phone", $lang)
 		);
		$html .= "</div>"; 

		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control\" placeholder=\"%s\" autocomplete=\"off\" name=\"postcode\" />",
 			$l->translate("postcode", $lang)
 		);
		$html .= "</div>"; 

		$html .= sprintf(
			"<button class=\"createAccountButton\">%s</button>",
			$l->translate("createaccount", $lang)
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