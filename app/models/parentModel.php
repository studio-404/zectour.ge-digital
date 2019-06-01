<?php 
class parentModel
{
	public $use_mod;

	public  function index()
	{
		require_once 'app/functions/url.php';
		require_once 'app/functions/strip_output.php';
		$url = new functions\url();
		$getUrl = explode("/", $url->getUrl());
		$out = "<div class=\"collection moduleList\" style=\"margin-top:0px;\">";
		if(count($this->use_mod)):
			$x = 1;
			foreach ($this->use_mod as $val) {
				$active = (isset($getUrl[3]) && $val['type']==$getUrl[3]) ? " active" : "";
				$out .= sprintf(
					"<a href=\"/%s/dashboard/modules/%s\" class=\"collection-item%s\">%s</a>",
					strip_output::index($_SESSION["LANG"]),
					strip_output::index($val['type']),
					strip_output::index($active),
					strip_output::index($val['title'])
				);
				$x++;
			}			
		endif;
		$out .= "</div>";
		return $out;
	}
}