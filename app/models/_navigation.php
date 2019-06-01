<?php 
class _navigation
{
	public $data;

	public function index(){
		require_once("app/functions/strip_output.php");
		$out = "<ul class=\"navbar-nav ml-auto\">\n";
		$f=1;
		if(count($this->data)){

			foreach($this->data as $value) {
				if($f==1){
					$f=2;
					continue;
				}
				$subNavigation = new Database('page', array(
					"method"=>"select", 
					"cid"=>(int)$value['idx'], 
					"nav_type"=>0, 
					"lang"=>strip_output::index($value['lang']), 
					"status"=>0
				));
				$active = (isset($_SESSION["URL"][1]) && $_SESSION["URL"][1]==$value['slug']) ? " active" : "";
				if(!isset($_SESSION["URL"][1]) && $value['slug']=="home"){
					$active = "active";
				}
				if($subNavigation->getter()){				
					
					if(isset($value['redirect']) && $value['redirect']!=""){
						$out .= sprintf(
							"<li class=\"nav-item dropdown %s\">\n<a href=\"%s\" class=\"nav-link\"><span>%s</span></a>\n",
							strip_output::index($active), 
							$value['redirect'], 
							strip_output::index($value['title'])
						);
					}else{
						$out .= sprintf(
							"<li class=\"nav-item dropdown %s\">\n<a href=\"#\" class=\"nav-link dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"true\">%s</a>\n",
							strip_output::index($active), 
							strip_output::index($value['title'])
						);
					}

					$out .= "<ul class=\"dropdown-menu\">\n";

					foreach ($subNavigation->getter() as $val) {
						$active2 = (isset($_SESSION["URL"][1]) && $_SESSION["URL"][1]==$val['slug']) ? " active" : "";
						
						if(isset($val['redirect']) && $val['redirect']!=""){
							$out .= sprintf(
								"<li class=\"%s\"><a href=\"%s\"><span>%s</span></a></li>\n",
								$active2,
								$val['redirect'], 
								strip_output::index($val['title'])  
							);	
						}else{
							$out .= sprintf(
								"<li class=\"%s\"><a href=\"%s%s/%s\"><span>%s</span></a></li>\n",
								$active2,
								Config::WEBSITE,
								strip_output::index($_SESSION['LANG']),
								$val['slug'], 
								strip_output::index($val['title'])  
							);	
						}
					}
					$out .= "</ul>\n";

					$out .= "</li>\n";
				}else{
					$active = (isset($_SESSION["URL"][1]) && $_SESSION["URL"][1]==$value['slug']) ? " active" : "";
					if(isset($value['redirect']) && $value['redirect']!=""){
						//$value['redirect']
						//$active = (isset($_SESSION["URL"][1]) && ($_SESSION["URL"][1]=="stories-on-map" || $_SESSION["URL"][1]=="stories" || $_SESSION["URL"][1]=="story")) ? " active" : "";
						$out .= sprintf(
							"<li class=\"nav-item %s\"><a href=\"%s\" class=\"nav-link\">%s</a></li>\n",
							$active,
							strip_output::index($value['redirect']),
							strip_output::index($value['title'])
						);
					}else{
						$out .= sprintf(
							"<li class=\"nav-item %s\"><a href=\"%s%s/%s\" class=\"nav-link\">%s</a></li>\n",
							$active, 
							Config::WEBSITE,
							strip_output::index($_SESSION['LANG']),
							strip_output::index($value['slug']), 
							strip_output::index($value['title'])
						);	
					}
				}
				
			}				
		}			
		$out .= "</ul>\n";
		
		return $out;
	}
}