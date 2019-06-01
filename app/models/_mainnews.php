<?php 
class _mainnews
{
	public $data;
	public $inside;

	public function index()
	{
		require_once("app/functions/strip_output.php");
		$out = "";
		if(count($this->data)){
			if(isset($this->inside) && $this->inside=="true"){
				$ourData = $this->data;
			}else{
				$ourData = $this->data[0];
			}
			$photos = new Database("photos",array(
				"method"=>"selectByParent", 
				"idx"=>(int)$ourData['idx'],  
				"lang"=>strip_output::index($_SESSION['LANG']),  
				"type"=>strip_output::index($ourData['type'])
			));
			if($photos->getter()){
				$pic = $photos->getter();
				$image = sprintf(
					"%s%s/image/loadimage?f=%s%s&w=350&h=218",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					Config::WEBSITE_,
					strip_output::index($pic[0]['path'])
				);
				$out .= sprintf(
					"<img src=\"%s\" alt=\"\" align=\"left\" style=\"margin: 0 10px 0px 0px\" id=\"mainImage\" />", 
					$image
				);
			}
			$out .= sprintf(
				"<section class=\"justTitle\">%s</section>", 
				strip_output::index($ourData['title'])
			);
			$out .= sprintf(
				"<section class=\"mainText\">%s</section>", 
				strip_output::index($ourData['description'])
			);
		}

		return $out;
	}
}