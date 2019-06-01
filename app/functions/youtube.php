<?php
namespace functions;

class youtube
{
	public $out;
	public $url;
	public function index($string)
	{
		$this->out = "";
		if(!empty($string))
		{
			$string = strip_tags($string);
	        preg_match_all('/watch\?v=\w+/', $string, $matches, PREG_OFFSET_CAPTURE);
	        if(isset($matches[0][0][0])){
	        	$youtubeId = explode("watch?v=", $matches[0][0][0]);
	        	$this->url = sprintf("https://www.youtube.com/embed/%s", $youtubeId[1]);
	        	$this->out = $this->iframe($this->url);
	        }else{

	        	preg_match_all('/\/embed\/\w+/', $string, $matches2, PREG_OFFSET_CAPTURE);
	        	if(!empty($matches2[0])){
	        		$this->url = $string;
	        		$this->out = $this->iframe($this->url);
	        	}
	        } 
		}
		return $this->out;
	}

	private function iframe($url)
	{
		$out = "<iframe width=\"100%\" height=\"350\" src=\"".$url."\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>";
		return $out;
	}
}