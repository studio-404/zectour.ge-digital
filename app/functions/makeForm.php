<?php 
namespace functions;

class makeForm
{

	public static function csrf(){
		$out = "<input type=\"hidden\" name=\"csrf\" value=\"".$_SESSION["CSRF"]."\" />";
		return $out;
	}

	public static function inputHidden($args){
		$out = "<input type=\"hidden\" id=\"".$args['id']."\" name=\"".$args['name']."\" value=\"".$args['value']."\" />";
		return $out;
	}

	public static function datepicker($args)
	{
		$out = "<input type=\"date\" class=\"datepicker\" id=\"".$args['id']."\" value=\"".$args['value']."\" />";
		return $out;	
	}

	public static function select($args)
	{
		$disabled = ($args["disabled"]=="true") ? "disabled" : "";
		$multiple = (isset($args["multiple"]) && $args["multiple"]=="true") ? " multiple" : "";
		$out = "<div class=\"input-field\">";
		$out .= "<select id=\"".$args['id']."\" ".$disabled.$multiple.">";
		if($args['selected']=="false"){
			$out .= "<option value=\"\" disabled selected>".$args['choose']."</option>";
		}else{
			$out .= "<option value=\"\" disabled>".$args['choose']."</option>";
		}
		foreach ($args["options"] as $key => $value) {
			$selected = ($key==$args['selected']) ? 'selected' : '';
			$out .= "<option value=\"".$key."\" ".$selected.">".$value."</option>";
		}

		$out .= "</select>";
		$out .= "</div>";
		return $out;
	}

	public static function open($args, $enctype = "application/x-www-form-urlencoded"){
		$class = (isset($args['class'])) ? $args['class'] : '';
		$out = "<form action=\"".$args['action']."\" method=\"".$args['method']."\" id=\"".$args['id']."\" class=\"".$class."\" enctype=\"".$enctype."\">"; 
		return $out;
	}

	public static function nameAndMsg($args){
		$out = "<h4>".$args['name']."</h4>";
		$out .= "<p class=\"msg\" id=\"".$args['id']."\"></p>";
		return $out;
	}



	public static function label($args){
		$require = ($args['require']=="true") ? '<font color="red">*</font>' : '';
		$out = "<label for=\"".$args['for']."\" style=\"margin:10px 0\">".$args['name'].": ".$require."</label>";
		return $out;
	}

	public static function inputText($args){
		$readyonly = (isset($args["readonly"]) && $args["readonly"]==true) ? " readonly='readonly'" : ""; 
		$out = "<div class=\"input-field\">";
		$out .= "<input type=\"text\" placeholder=\"".$args['placeholder']."\" autocomplete=\"off\" id=\"".$args['id']."\" name=\"".$args['name']."\" value=\"".htmlentities($args['value'])."\"".$readyonly." />";
		$out .= "</div>";

		return $out;
	}

	public static function inputPassword($args){
		$out = "<input type=\"password\" name=\"".$args['name']."\" id=\"".$args['id']."\" class=\"".$args['class']."\" value=\"".$args['value']."\" />";
		return $out;
	}

	public static function inputButton($args){
		$out = "<input type=\"button\" name=\"".$args['name']."\" id=\"".$args['id']."\" class=\"".$args['class']."\" value=\"".$args['value']."\" onclick=\"".$args['onclick']."\" />";
		return $out;
	}

	public static function inputSubmit($args){
		$out = "<input type=\"submit\" name=\"".$args['name']."\" id=\"".$args['id']."\" class=\"".$args['class']."\" value=\"".$args['value']."\" onclick=\"".$args['onclick']."\" />";
		return $out;
	}

	public static function textarea($args){
		$out = "<div class=\"textarea\">";
		$out .= "<textarea id=\"".$args["id"]."\" name=\"".$args["name"]."\" class=\"tinymceTextArea\" placeholder=\"".$args["placeholder"]."\">".$args['value']."</textarea><br />";
		$out .= "</div>";
		return $out;
	}

	public static function checkbox($args){
		$checked = (!empty($args['checked']) && $args['checked']=="true") ? " checked='checked'" : "";
		$out = "<p class=\"materializeCheckBox\">";
      	$out .= "<input type=\"checkbox\" name=\"".$args["name"]."\" id=\"".$args["id"]."\" value=\"".$args["value"]."\" ".$checked."/>";
      	$out .= "<label for=\"".$args["id"]."\">".$args['chackboxTitle']."</label>";
    	$out .= "</p>";

		return $out;
	}	

	public static function range($args){
		$autocomplete[0] = (!empty($args[0]['autocomplete']) && $args[0]['autocomplete']=="off") ? " autocomplete='off'" : "";
		$out = "<section class=\"range\">";
		$out .= "<input type=\"text\" name=\"".$args[0]['name']."\" id=\"".$args[0]['id']."\" class=\"".$args[0]['class']."\" value=\"".$args[0]['value']."\" placeholder=\"".$args[0]['placeholder']."\" ".$autocomplete[0]." />";

		$autocomplete[1] = (!empty($args[1]['autocomplete']) && $args[1]['autocomplete']=="off") ? " autocomplete='off'" : "";
		$out .= "<input type=\"text\" name=\"".$args[1]['name']."\" id=\"".$args[1]['id']."\" class=\"".$args[1]['class']."\" value=\"".$args[1]['value']."\" placeholder=\"".$args[1]['placeholder']."\" ".$autocomplete[1]." />";
		
		$out .= "</section>"; 
		return $out;
	}

	public static function roundCheckboxes($args, $activeNum){
		$out = "<input type=\"hidden\" name=\"".$args["name"]."\" id=\"".$args["id"]."\" value=\"".$activeNum."\" />";
		$x = 1;
		$time = time();
		foreach ($args['items'] as $value) {
			$active = ($activeNum==$value["baseid"]) ? "active" : "";
			$unique = "r".$x.$time;
			$out .= "<section class=\"checkboxes-rounded ".$args["mainClass"]." ".$active."\" id=\"".$unique."\" onclick=\"website.checkboxCheckRounded('".$args["mainClass"]."','".$unique."', '".$args["id"]."')\">
						<section class=\"b\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></section>
						<section class=\"t\" data-baseid=\"".$value["baseid"]."\">".$value["title"]."</section>
					</section>";
			$x++;
		}
		return $out;
	}

	public static function cornerCheckboxes($args, $activeNum){
		$out = "<input type=\"hidden\" name=\"".$args["name"]."\" id=\"".$args["id"]."\" value=\"".$activeNum."\" />";
		$x = 1;
		$time = time();
		foreach ($args['items'] as $value) {
			$active = ($activeNum==$value["baseid"]) ? "active" : "";
			$unique = "c".$x.$time;
			$out .= "<section class=\"checkboxes ".$args["mainClass"]." ".$active."\" id=\"".$unique."\" onclick=\"website.checkboxCheck('".$unique."', '".$args["id"]."')\">
						<section class=\"b\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></section>
						<section class=\"t\" data-baseid=\"".$value["baseid"]."\">".$value["title"]."</section>
					</section>";
			$x++;
		}
		return $out;
	}

	public static function fileUpload($args){
    	$out = '<div class="file-field input-field">';
    	$out .= '<div class="btn">';
    	$out .= '<span>'.$args['label'].'</span>';
    	$out .= '<input type="file">';
    	$out .= '</div>';
    	$out .= '<div class="file-path-wrapper">';
    	$out .= '<input class="file-path validate" id="'.$args['id'].'" type="text" />';
    	$out .= '</div>';
    	$out .= '</div>';
    	return $out;
	}

	public static function close(){
		$out = "</form>"; 
		return $out;	
	}
}