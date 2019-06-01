<?php 
class loadStory
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/calendar.php'; 
		require_once 'app/functions/string2.php'; 

		$string = new functions\string2();

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			),
			"Success"=>array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>"!"
			)
		);

		$loadFrom = functions\request::index("POST","loadFrom");
		$loadTo = functions\request::index("POST","loadTo");
		$loadRegion = functions\request::index("POST","loadRegion");
		$loadCity = functions\request::index("POST","loadCity");
		$loadAge = functions\request::index("POST","loadAge");
		$loadGender = functions\request::index("POST","loadGender");
		$lang = functions\request::index("POST","lang");

		$Database = new Database("products", array(
			"method"=>"selectFromTo", 
			"loadFrom"=>$loadFrom, 
			"loadTo"=>$loadTo, 
			"loadRegion"=>$loadRegion, 
			"loadCity"=>$loadCity, 
			"loadAge"=>$loadAge, 
			"loadGender"=>$loadGender, 
			"lang"=>$lang 
		));

		if($Database->getter()){
			$html = "";
			foreach ($Database->getter() as $value) {
				$DB = new Database("georgia", array(
					"method"=>"selectById", 
					"idx"=>(int)$value['region'],
					"lang"=>$value['lang']
				));
				$region = $DB->getter();

				$DB2 = new Database("georgia", array(
					"method"=>"selectById", 
					"idx"=>(int)$value['city'],
					"lang"=>$value['lang']
				));
				$city = $DB2->getter();

				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>$value['lang'],  
					"type"=>"products"
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=360&h=280",
						Config::WEBSITE,
						$value['lang'],
						Config::WEBSITE_,
						$pic[0]['path']
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}
				$name = strip_tags($value['name']);
				$titleUrl = str_replace(array(" "), "-", $name); 

				$html .= sprintf(
					"<a href=\"%s%s/story/%s/%s\" class=\"stories-item\">\n",
					Config::WEBSITE,
					$value['lang'],
					(int)$value['idx'],
					$titleUrl
				);

				$html .= "<div class=\"stories-item_img-wrap\">";
				$html .= sprintf(
					"<img src=\"%s\" alt=\"image\" class=\"stories-item_img\" />",
					$image
				);
				$html .= "</div>";

				$html .= sprintf(
					"<h2 class=\"stories-item_title\">%s %s, <span>%s, %s </span></h2>", 
					$name, 
					$value['age'], 
					$region['name'], 
					$city['name']  
				);

				$html .= sprintf(
					"<p class=\"stories-item_text\">%s</p>", 
					$string->cut(strip_tags($value['about']),100)
				);
				$html .= "</a>\n";
			}

			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				),
				"Success"=>array(
					"Code"=>1, 
					"Text"=>"ოპერაცია წარმატებით დასრულდა !",
					"Html"=>$html,
					"Details"=>"!"
				)
			);
		}


		return $this->out;
	}
}