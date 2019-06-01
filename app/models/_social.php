<?php 
class _social
{
	public $networks;

	public function index(){
		require_once("app/functions/strip_output.php");

		$out = '';
		if(count($this->networks)){
			$out .= "<ul>\n"; 
			foreach($this->networks as $value) {
				$out .= "<li>\n"; 
				$out .= sprintf(
					"<a href=\"%s\" target=\"_blank\">\n", 
					strip_output::index($value['url'])
				);

				$out .= sprintf(
					"<i class=\"%s transitions\" aria-hidden=\"true\"></i>",
					strip_output::index($value['classname'])
				);

				$out .= "</a>";
				$out .= "</li>\n"; 

			}	
			$out .= "</ul>\n"; 			
		}			
		
		return $out;
	}
}