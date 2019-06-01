<?php 
class _top
{
	public  $data;

	public function index()
	{
		require_once("app/functions/l.php"); 

    	$out = "<div class=\"topline\"></div>\n";
    	$out .= "<nav class=\"navbar navbar-expand-lg navbar-dark fixed-top\">\n";
    	
    	$out .= "<div class=\"container\">\n";
    	
    	$out .= "<a class=\"navbar-brand\" href=\"/\" style=\"width:120px;\">\n";
      $out .= sprintf(
        "<img src=\"%simg/zec.svg\" width=\"100&#37;\" />\n",
        Config::PUBLIC_FOLDER
      );
		$out .= "</a>\n";
		
		$out .= "<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarResponsive\" aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">\n";
		$out .= "<span class=\"navbar-toggler-icon\"></span>\n";
		$out .= "</button>\n";

		$out .= "<div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">\n";
		$out .= $this->data["navigationModule"];
		$out .= "</div>\n";

		$out .= "</div>\n";
		$out .= "</nav>\n";

		if(!isset($_SESSION["currency"])){ $_SESSION["currency"]="gel"; }

		if(
			@$_SESSION["URL"][1]!="covetituristam" && 
			@$_SESSION["URL"][1]!="otzivi" && 
			@$_SESSION["URL"][1]!="book" && 
			@$_SESSION["URL"][1]!="aboutus"  
		){
			$out .= "<div class=\"g-currency-box\">\n";
			$out .= "<h6>Сменить валюту</h6>\n";
			$out .= sprintf(
				"<p><a href=\"javascript:void(0)\" class=\"%s\" data-cur=\"gel\">GEL</a></p>\n",
				(!isset($_SESSION["currency"]) || $_SESSION["currency"]=="gel") ? "active" : ""
			);
			$out .= sprintf(
				"<p><a href=\"javascript:void(0)\" class=\"%s\" data-cur=\"usd\">USD</a></p>\n",
				(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd") ? "active" : ""
			);
			$out .= sprintf(
				"<p><a href=\"javascript:void(0)\" class=\"%s\" data-cur=\"rub\">RUB</a></p>\n",
				(isset($_SESSION["currency"]) && $_SESSION["currency"]=="rub") ? "active" : ""
			);
			$out .= "</div>\n";
		}

		return $out;
	}
}