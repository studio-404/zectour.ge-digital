<?php 
class _othernews
{
	public $data; 
	public $startAt = 1; 
	public $count; 

	public function index()
	{
		require_once("app/functions/strip_output.php");
		$out = "";
		$this->count = count($this->data);
		if($this->count)
		{
			require_once("app/functions/string.php"); 
			$sting = new functions\string();
			require_once("app/functions/l.php"); 
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

			$slice = (isset($this->data[1])) ? array_slice($this->data, $this->startAt, 4) : $this->data;
			$out .= '<div class="othernews-box">';
			$i = 1;
			foreach ($slice as $value) {
				$photos = new Database("photos",array(
					"method"=>"selectByParent", 
					"idx"=>(int)$value['idx'],  
					"lang"=>strip_output::index($_SESSION['LANG']),  
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
				$theUrl = sprintf(
					"%s%s/news/%s/%s",
					Config::WEBSITE,
					strip_output::index($_SESSION['LANG']),
					(int)$value['idx'],
					strip_output::index($titleUrl)
				);

				$out .= "<section class=\"col s12 m12 l6 news-item\">";
				$out .= "<section class=\"newsBox\">";
				$out .= sprintf(
					"<a href=\"%s\">", 
					strip_output::index($theUrl)
				);
				$out .= "<section class=\"imageBox\">";
				$out .= sprintf(
					"<img src=\"%s\" width=\"%s\" alt=\"\" />", 
					$image,
					"100%"
				);
				$out .= "</section>";
				$out .= "<section class=\"data\">";
				$out .= sprintf(
					"<p>%s</p>\n",
					$l->translate('singlenews')
				);
				$str = str_replace(date("M", (int)$value['date']), $month[strip_output::index($_SESSION['LANG'])][date("M", (int)$value['date'])], date("M d, Y", (int)$value['date']));
				$out .= sprintf(
					"<p>%s</p>\n",
					strip_output::index($str)
				);
				$out .= "</section>";
				$out .= sprintf(
					"<section class=\"title\">%s</section>", 
					$sting->cut(strip_tags($title),60)
				);
				$out .= sprintf(
					"<section class=\"text\">%s</section>", 
					$sting->cut(strip_tags($value['description']),160)
				);
				$out .= "</a>";
				$out .= "</section>";
				$out .= "</section>";
				if(($i%2) == 0){
					$out .= "<div style=\"clear:both\"></div>";
				}
				$i++;
			}
			$out .= '</div>';
			if($this->startAt==0){
				$out .= '<input type="hidden" name="counterVals" id="counterVals" value="4" />';
			}else{
				$out .= sprintf(
					'<input type="hidden" name="counterVals" id="counterVals" value="%s" />',
					htmlspecialchars($this->count)
				);	
			}
			
			$out .= "<section class=\"col s12 m12 l12 loadergif\" style=\"text-align: center; margin-top: 30px; display:none\"><img src=\"/public/img/ajax-loader.gif\" style=\"width:40px;\" align=\"center\" /></section>";
		}
		return $out;
	}
}