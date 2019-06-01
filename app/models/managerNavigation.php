<?php
class managerNavigation
{
	public $navigation;
	public $getUrl;

	public function __construct()
	{
		require_once 'app/functions/url.php';
		require_once 'app/functions/strip_output.php';
		$url = new functions\url();
		$this->getUrl = strip_output::index($url->getUrl());
	}

	public function index(){
		require_once("app/functions/strip_output.php"); 
		$nav = sprintf("<ul id=\"nav-mobile\" class=\"right hide-on-med-and-down\">");
		$getUrl = explode("/", $this->getUrl);
		if(isset($getUrl[1]) && isset($getUrl[2])){
			$slug = $getUrl[1]."/".$getUrl[2];
		}else{
			$slug = "";
		}
		
		foreach ($this->navigation as $key => $value) {
			$ex = explode("/", $key);
			$kk = $ex[1]."/".$ex[2];
			$active = ($kk==$slug) ? "class='active'" : "";
			$nav .= sprintf(
				"<li %s><a href=\"/%s\">%s</a></li>",
				strip_output::index($active),
				strip_output::index($key),
				strip_output::index($value)
			);
		}
		$nav .= sprintf("</ul>");

		return ($nav);
	}

	public function footer()
	{
		require_once("app/functions/strip_output.php"); 
		$nav = sprintf("<ul>");
		$getUrl = explode("/", $this->getUrl);
		if(isset($getUrl[1]) && isset($getUrl[2])){
			$slug = $getUrl[1]."/".$getUrl[2];	
		}else{
			$slug = "";
		}
		
		foreach ($this->navigation as $key => $value) {
			$active = ($key==$slug) ? "class='active'" : "";
			$nav .= sprintf(
				"<li %s><a href=\"/%s\">%s</a></li>",
				strip_output::index($active),
				strip_output::index($key),
				strip_output::index($value)
			);
		}
		$nav .= sprintf("</ul>");

		return ($nav);
	}
}