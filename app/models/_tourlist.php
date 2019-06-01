<?php 
class _tourlist
{
	public $data;

	public function index()
	{
		require_once("app/functions/string2.php");
		require_once("app/functions/l.php");
		$l = new functions\l();
		
		$out = "";

		if(count($this->data)){
			
			foreach($this->data as $value) {
				$realprice = 0;
				$realprice2 = 0;
				$realprice3 = 0;
				$realprice4 = 0;
				$curname = "";

				if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="gel"){
					$realprice = (int)$value["price"];
					$realprice2 = (int)$value["price_child"];
					$realprice3 = (int)$value["price_child512"];
					$realprice4 = (int)$value["price_child1220"];
					$curname = "GEL";
				}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
					$realprice = (int)round($value["price"]/$_SESSION["_USD_"]);
					$realprice2 = (int)round($value["price_child"]/$_SESSION["_USD_"]);
					$realprice3 = (int)round($value["price_child512"]/$_SESSION["_USD_"]);
					$realprice4 = (int)round($value["price_child1220"]/$_SESSION["_USD_"]);
					$curname = "USD";
				}else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="rub"){
					$realprice = (int)round($value["price"]/$_SESSION["_RUB_"]);
					$realprice2 = (int)round($value["price_child"]/$_SESSION["_RUB_"]);
					$realprice3 = (int)round($value["price_child512"]/$_SESSION["_RUB_"]);
					$realprice4 = (int)round($value["price_child1220"]/$_SESSION["_RUB_"]);
					$curname = "RUB";
				}


				$out .= sprintf(
					"<a href=\"%s%s/view/%s/?id=%d\" class=\"col-sm-6 col-md-4 column\">\n",
					Config::WEBSITE,
					$_SESSION["LANG"],
					str_replace(array(" ", "'", "%"), "-", strip_tags($value["title"])),
					(int)$value["idx"]
				);

				$out .= "<section class=\"thumbnail\">\n";
				$out .= sprintf(
					"<section class=\"image\" style=\"background-image: url('%s%s/image/loadimage?f=%s%s&w=480&h=400')\">\n",
					Config::WEBSITE, 
					$_SESSION["LANG"],
					Config::WEBSITE_,
					$value["photo"]
				);


				$out .= sprintf(
					"<img src=\"%s%s/image/loadimage?f=%s%s&w=280&h=200\" style=\"position: absolute; opacity:0; top:0; left:0;\" alt=\"%s\" />\n",
					Config::WEBSITE, 
					$_SESSION["LANG"],
					Config::WEBSITE_,
					$value["photo"],
					strip_tags($value["title"])
				);
				
				$style = ($value["tourist_points"]=="dynamic2") ? "style='padding:5px; font-size:18px; line-height:20px'" : "";
				$out .= "<section class=\"price\" ". $style .">\n";
				if($value["tourist_points"]=="dynamic"){
					$out .= sprintf(
						"%s: %s %s %s: %s %s\n",
						$l->translate("adults"),
						$realprice,
						$curname,
						$l->translate("children"),
						$realprice2, 
						$curname
					);
				}else if($value["tourist_points"]=="dynamic2"){
					$out .= sprintf(
						"
						Взрослые: %s %s<br>
						Дети до 5 лет: %s %s<br>
						Дети до 12 лет: %s %s<br>
						Дети старше 12 лет: %s %s<br>
						",
						$realprice,
						$curname,
						$realprice2,
						$curname,
						$realprice3,
						$curname,
						$realprice4,
						$curname
					);
				}else if($value["tourist_points"]=="alcohol"){
					$out .= sprintf(
						"Цена за 1 литр: %s %s",
						$realprice,
						$curname
					);
				}else if($value["tourist_points"]=="simcard"){
					$out .= sprintf(
						"Цена за 1 штук: %s %s",
						$realprice,
						$curname
					);
				}else if($value["tourist_points"]=="rentcar"){
					$out .= sprintf(
						"Цена за сутки: %s %s",
						$realprice,
						$curname
					);
				}else{
					$out .= sprintf(
						"%s %s (%s %s)\n",
						$realprice,
						$curname,
						$l->translate("for"),
						$value["tourist_points"]
					);
				}
				

				// if($value["tourist_points"]!="dynamic"){
				// 	$out .= sprintf(
				// 		"%s %s (%s %s)\n",
				// 		$realprice,
				// 		$curname,
				// 		$l->translate("for"),
				// 		$value["tourist_points"]
				// 	);
				// }else{
				// 	$out .= sprintf(
				// 		"%s: %s %s %s: %s %s\n",
				// 		$l->translate("adults"),
				// 		$realprice,
				// 		$curname,
				// 		$l->translate("children"),
				// 		$value["price_child"], 
				// 		$curname
				// 	);
				// }

				$out .= "</section>\n";

				$out .= "</section>\n";

				$out .= "<section class=\"caption\">\n";
				$out .= sprintf(
					"<h3>%s, %s</h3>\n",
					strip_tags($value["title"]),
					strip_tags(functions\string2::cutstatic($value["short_description"], 30))
				);

				// $out .= sprintf(
				// 	"<h3>%s - #%d</h3>\n",
				// 	strip_tags($value["title"]),
				// 	$value["idx"]
				// );

				// $out .= sprintf(
				// 	"<p>%s</p>\n",
				// 	functions\string::cutstatic($value["short_description"], 20)
				// );

				// $out .= sprintf(
				// 	"<p class=\"sold\">%s <span>%s</span></p>",
				// 	$l->translate("sold"),
				// 	strip_tags($value["sold"])
				// );

				$out .= "</section>\n";
				$out .= "</section>\n";

				$out .= "</a>\n";
			}

		}else{
					  
			$out = sprintf(
				"<section class=\"alert alert-warning\" role=\"alert\">
				<i class=\"fa fa-exclamation-circle\" aria-hidden=\"true\"></i> %s 
				</section>
				", 
				$l->translate("nodata")
			);
		}
		return $out;
	}
}