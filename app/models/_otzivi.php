<?php 
class _otzivi
{
	public $data;

	public function index()
	{
		require_once("app/functions/files.php"); 
		require_once("app/functions/strip_output.php");
		require_once("app/functions/l.php");
		$l = new functions\l();

		$out = "";
		
		foreach ($this->data as $value) {
			$photos = new Database("photos",array(
				"method"=>"selectByParent", 
				"idx"=>(int)$value['idx'],  
				"lang"=>strip_output::index($_SESSION['LANG']),  
				"type"=>strip_output::index($value['type'])
			));
			$outImage = "";
			if($photos->getter()){
				$pic = $photos->getter();
				$image = sprintf(
					"%s%s/image/loadimage?f=%s%s&w=350&h=238",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					Config::WEBSITE_,
					strip_output::index($pic[0]['path'])
				);

				$outImage = sprintf(
					"<img src=\"%s\" alt=\"%s\" class=\"profilephoto\" />", 
					$image,
					strip_tags($value["title"])
				);
			}

			
			$out .= "<div class=\"row\">";
			
			$out .= "<div class=\"col-sm-3\">";
			$out .= $outImage;
			$out .= "</div>";

			$out .= "<div class=\"col-sm-9\">";
			$out .= sprintf("<h4 style=\"color: white\">%s</h4>", strip_tags($value["title"]));	
			$out .= sprintf("<p style=\"color: white\">%s</p>", strip_tags($value["description"]));	
			$out .= "</div>";	

			$out .= "</div>";

		}

		return $out;
	}
}