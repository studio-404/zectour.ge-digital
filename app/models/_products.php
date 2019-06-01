<?php  
class _products
{
	public $data; 

	public function index()
	{
		require_once("app/functions/string.php"); 
		require_once("app/functions/l.php"); 
		require_once("app/functions/strip_output.php");

		$l = new functions\l(); 
		$sting = new functions\string();
		$out = "";
		if(count($this->data)){
			foreach($this->data as $value) {
				$DB = new Database("georgia", array(
					"method"=>"selectById", 
					"idx"=>(int)$value['region'],
					"lang"=>$_SESSION['LANG']
				));
				$region = $DB->getter();

				$DB2 = new Database("georgia", array(
					"method"=>"selectById", 
					"idx"=>(int)$value['city'],
					"lang"=>$_SESSION['LANG']
				));
				$city = $DB2->getter();

				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>$_SESSION['LANG'],  
					"type"=>"products"
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=360&h=280",
						Config::WEBSITE,
						strip_output::index($_SESSION['LANG']),
						Config::WEBSITE_,
						strip_output::index($pic[0]['path'])
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}
				$name = strip_tags($value['name']);
				$titleUrl = str_replace(array(" "), "-", $name); 

				$out .= sprintf(
					"<a href=\"%s%s/story/%s/%s\" class=\"stories-item\">\n",
					Config::WEBSITE,
					$_SESSION['LANG'],
					(int)$value['idx'],
					strip_output::index($titleUrl)
				);

				$out .= "<div class=\"stories-item_img-wrap\">";
				$out .= sprintf(
					"<img src=\"%s\" alt=\"image\" class=\"stories-item_img\" />",
					$image
				);
				$out .= "</div>";

				$out .= sprintf(
					"<h2 class=\"stories-item_title\">%s %s, <span>%s, %s </span></h2>", 
					$name, 
					$value['age'], 
					$region['name'], 
					$city['name']  
				);

				$out .= sprintf(
					"<p class=\"stories-item_text\">%s</p>", 
					$sting->cut(strip_tags($value['about']),100)
				);

				

				$out .= "</a>\n";
			}
		}		
		
		return $out; 
	}
}