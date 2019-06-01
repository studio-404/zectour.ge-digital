<?php 
class _lang
{
	public $langs;

	public function index(){
		require_once("app/functions/strip_output.php");
		$out = "";
		if(count($this->langs)){
			foreach($this->langs as $value) {
				if($value['title']==$_SESSION['LANG']){
					continue;
				}
				$out .= sprintf(
					"<li><a href=\"#\" onclick=\"changeLanguage('%s','%s')\" class=\"languageSlide\" id=\"%s\">%s</a></li>\n", 
					strip_tags($value['title']), 
					strip_output::index($_SESSION['LANG']), 
					htmlspecialchars($value['title']),
					htmlspecialchars($value['name'])
				);
			}				
		}			
		
		return $out;
	}
}