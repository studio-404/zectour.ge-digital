<?php 
class _news
{
	public $data; 

	public function index()
	{
		require_once("app/functions/string.php"); 
		require_once("app/functions/l.php"); 
		require_once("app/functions/strip_output.php");
		$month = array(
			"ge"=>array(
				"Jan"=>"იან",
				"Feb"=>"თებ",
				"Mar"=>"მარ",
				"Apr"=>"აპრ",
				"May"=>"მაი",
				"Jun"=>"ივნ",
				"Jul"=>"ივლ",
				"Aug"=>"აგვ",
				"Sep"=>"სექ",
				"Oct"=>"ოქტ",
				"Nov"=>"ნოე",
				"Dec"=>"დეკ"
			),
			"en"=>array(
				"Jan"=>"Jan",
				"Feb"=>"Feb",
				"Mar"=>"Mar",
				"Apr"=>"Apr",
				"May"=>"May",
				"Jun"=>"Jun",
				"Jul"=>"Jul",
				"Aug"=>"Aug",
				"Sep"=>"Sep",
				"Oct"=>"Oct",
				"Nov"=>"Nov",
				"Dec"=>"Dec"
			),
			"ru"=>array(
				"Jan"=>"янв",
				"Feb"=>"фев",
				"Mar"=>"мар",
				"Apr"=>"апр",
				"May"=>"май",
				"Jun"=>"июн",
				"Jul"=>"июл",
				"Aug"=>"авг",
				"Sep"=>"сен",
				"Oct"=>"окт",
				"Nov"=>"ноя",
				"Dec"=>"дек"
			)
		);
		$l = new functions\l(); 
		$sting = new functions\string();
		$out = "";
		if(count($this->data)){
			foreach($this->data as $value) {
				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>strip_output::index($value['lang']),  
					"type"=>strip_output::index($value['type'])
				));
				if($photos->getter()){
					$pic = $photos->getter();
					$image = sprintf(
						"%s%s/image/loadimage?f=%s%s&w=383&h=235",
						Config::WEBSITE,
						strip_output::index($_SESSION['LANG']),
						Config::WEBSITE_,
						strip_output::index($pic[0]['path'])
					);
				}else{
					$image = "/public/filemanager/noimage.png";
				}
				$title = strip_tags($value['title']);
				$titleUrl = str_replace(array(" "), "-", $title); 

				$out .= "<section class=\"col s12 m6 l6\">\n";
				$out .= "<section class=\"newsBox\">\n";
				$out .= sprintf(
					"<a href=\"%s%s/news/%s/%s\">\n",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					(int)$value['idx'],
					strip_output::index($titleUrl)
				);
				$out .= "<section class=\"imageBox\">\n";
				$out .= "<img src=\"".$image."\" width=\"100%\" alt=\"\" />\n";
				$out .= "</section>\n";
				$out .= "<section class=\"data\">\n";
				$out .= sprintf(
					"<p>%s</p>\n",
					$l->translate('singlenews')
				);
				$str = str_replace(date("M", (int)$value['date']), $month[strip_output::index($_SESSION['LANG'])][date("M", (int)$value['date'])], date("M d, Y", (int)$value['date']));
				$out .= sprintf(
					"<p>%s</p>\n",
					strip_output::index($str)
				);
				$out .= "</section>\n";
				$out .= "<section class=\"title\">".$sting->cut(strip_tags($title),60)."</section>\n";
				$out .= "<section class=\"text\">".$sting->cut(strip_tags($value['description']),160)."</section>\n";
				$out .= "</a>\n";
				$out .= "</section>\n";
				$out .= "</section>\n";
			}
		}		
		
		return $out; 
	}
}