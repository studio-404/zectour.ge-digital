<?php 
class _leftnav
{
	public $data;

	public function index()
	{
		require_once("app/functions/strip_output.php");
		if(count($this->data)){
			$out = "<ul>";	
			foreach($this->data as $value) {
				$active = (isset($_SESSION['URL'][2]) && $_SESSION['URL'][2]==$value['slug']) ? " class='active'" : '';
				$link = sprintf(
					"%s%s/dcfta-for-businness/%s",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					strip_output::index($value['slug'])
				); 
				$out .= sprintf(
					"<li><a href=\"%s\"%s>%s</a></li>", 
					htmlspecialchars($link), 
					htmlspecialchars($active), 
					strip_tags($value['title'])
				);
			}
			$out .= "</ul>";
		}
		
		return $out;	
	}
}