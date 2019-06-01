<?php
class loadsearchform
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

		// title
		$html =	"<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"text\" class=\"form-control pop-title\" placeholder=\"%s\" value=\"\" />",
 			$l->translate("typetourtitle", $lang)
 		);
		$html .= "</div>"; 

		// destination select from database
		$html .= "<input type=\"hidden\" class=\"pop-destination\" value=\"\" />";
		$html .= "<select class=\"selectpicker pop-dest\" data-live-search=\"true\">";
		$html .= sprintf(
			"<option value=\"\">%s</option>",
			$l->translate("destination", $lang)
		);
		$db_destinations = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"destination",
			"lang"=>$lang
		));
		foreach ($db_destinations->getter() as $value) {
			$html .= sprintf(
				"<option value=\"%d\">%s</option>",
				$value["idx"],
				$value["title"]
			);
		}
		$html .= "</select>";

		// advanture type Select from database
		$html .= "<input type=\"hidden\" class=\"pop-tourtypes\" value=\"\" />";
		$html .= "<select class=\"selectpicker pop-tour\" data-live-search=\"true\">";
		$html .= sprintf(
			"<option value=\"\">%s</option>",
			$l->translate("advanturetype", $lang)
		);
		$db_tourtypes = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"tourtypes",
			"lang"=>$lang
		));
		foreach ($db_tourtypes->getter() as $value) {
			$html .= sprintf(
				"<option value=\"%d\">%s</option>",
				$value["idx"],
				$value["title"]
			);
		}
		$html .= "</select>";


		$html .= "<section class=\"dateBox\">";
		$html .= sprintf(
			"<input type=\"text\" class=\"form-control date pop-arrival\" value=\"\" placeholder=\"%s\" readonly=\"readonly\" />",
			$l->translate("arrival", $lang)
		);
		$html .= "</section>";
	
		$html .= "<section class=\"dateBox\">";
		$html .= sprintf(
			"<input type=\"text\" class=\"form-control date pop-departure\" value=\"\" placeholder=\"%s\" readonly=\"readonly\" />",
			$l->translate("departure", $lang)
		);
		$html .= "</section>";


		$html .= "<div class=\"input-group\">";
 		$html .= sprintf(
 			"<input type=\"number\" class=\"form-control pop-guests\" placeholder=\"%s\" min=\"0\" />", 
 			$l->translate("guests", $lang)
 		);
		$html .= "</div>"; 

		$html .= sprintf(
			"<button class=\"popupSearchbutton\">%s</button>",
			$l->translate("search", $lang)
		); 

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