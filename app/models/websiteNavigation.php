<?php 
class websiteNavigation
{
	public $navigation;

	public function index(){
		require_once 'app/core/Config.php';
		
		$nav = "";
		if(count($this->navigation))
		{
			foreach ($this->navigation as $val)
			{
				$slug = ($val['redirect']!="false") ? $val['redirect'] : Config::WEBSITE.Config::PAGE_PREFIX."/".$val['type']."/".$val['lang']."/".$val['idx']."/".$val['slug']; 
				
				$visibility = ($val['visibility']==1) ? "visibility_off" : "visibility";

				$usefull_url = ($val['usefull_type'] == "false") ? "javascript:void(0)" : "/".$_SESSION["LANG"]."/dashboard/modules/".$val['usefull_type'];
				$usefull_type = "<a href=\"".$usefull_url."\">";
				$usefull_type .= "<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"მოდულზე გადასვლა\">view_module</i>";
				$usefull_type .= "</a>";

				$catalog_list = "";

				if($val['type']=="catalog"){
					$cat_url = "/".$_SESSION["LANG"]."/dashboard/catalog/".$val['idx'];
					$catalog_list = "<a href=\"".$cat_url."\">";
					$catalog_list .= "<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"კატალოგი\">view_list</i>";
					$catalog_list .= "</a>";
				}				

				$nav .= sprintf("
					<div class=\"row level-0\" data-item=\"%d\" data-cid=\"%d\" style=\"position:relative\">
						<div class=\"cell roboto-font\">%d</div>
						<div class=\"cell roboto-font\">%d</div>
						<div class=\"cell\"><a href=\"%s\" target=\"_blank\">%s</a></div>
						<div class=\"cell roboto-font\">%s</div>
						<div class=\"cell\">
	
						<a href=\"javascript:void(0)\" onclick=\"changeVisibility('%s','%s')\">
							<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ხილვადობის შეცვლა\">%s</i>
					 	</a>

					 	<a href=\"javascript:void(0)\" onclick=\"add_page('%d')\">
					 		<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"დამატება\">note_add</i>
					 	</a>

					 	<a href=\"javascript:void(0)\" onclick=\"editPage('%s','%s')\">
					 		<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i>
					 	</a>
					 	%s%s
						<a href=\"javascript:void(0)\" onclick=\"askRemovePage('0','%s','%s','%s')\">
							<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i>
					 	</a>
						</div>

					</div>
				",
				$val['idx'], 
				$val['cid'],
				$val['idx'],
				$val['position'], 
				$slug, 
				$val['title'], 
				$val['type'], 
				$val['visibility'], 
				$val['idx'], 
				$visibility,
				$val['idx'], 
				$val['idx'], 
				$val['lang'], 
				$usefull_type, 
				$catalog_list,
				$val['position'], 
				$val['idx'], 
				$val['cid']
				);

				$subNavigation = new Database('page', array(
					"method"=>"select", 
					"cid"=>$val['idx'], 
					"nav_type"=>0, 
					"lang"=>$val['lang'], 
					"status"=>0
				));

				if($subNavigation->getter()){
					foreach ($subNavigation->getter() as $v) {
						$vis = ($v['visibility']==1) ? "visibility_off" : "visibility";


						$usefull_url2 = ($v['usefull_type'] == "false") ? "javascript:void(0)" : "/".$_SESSION["LANG"]."/dashboard/modules/".$v['usefull_type'];
						$usefull_type2 = "<a href=\"".$usefull_url2."\">";
						$usefull_type2 .= "<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"მოდულზე გადასვლა\">view_module</i>";
						$usefull_type2 .= "</a>";

						$catalog_list2 = "";

						if($v['type']=="catalog"){
							$cat_url = "/".$_SESSION["LANG"]."/dashboard/catalog/".$v['idx'];
							$catalog_list2 = "<a href=\"".$cat_url."\">";
							$catalog_list2 .= "<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"კატალოგი\">view_list</i>";
							$catalog_list2 .= "</a>";
						}	


						$nav .= "<div class=\"row level-2 sub-".$v['cid']."\" data-item=\"".$v['idx']."\" data-cid=\"".$v['cid']."\" style=\"background:#f2f2f2\">";
						$nav .= "<div class=\"cell roboto-font\">".$v['idx']."</div>";
						$nav .= "<div class=\"cell roboto-font\">".$v['position']."</div>";
						$nav .= "<div class=\"cell\"><a href=\"\" target=\"_blank\">".$v['title']."</a></div>";
						$nav .= "<div class=\"cell roboto-font\">".$v['type']."</div>";
						
						$nav .= "<div class=\"cell\">";
						$nav .= "<a href=\"javascript:void(0)\" onclick=\"changeVisibility('".$v["visibility"]."','".$v["idx"]."')\">
							<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ხილვადობის შეცვლა\">".$vis."</i>
					 	</a>";

					 	$nav .= "<a href=\"javascript:void(0)\" onclick=\"editPage('".$v["idx"]."','".$v["lang"]."')\">
					 		<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i>
					 	</a>";

					 	$nav .= $catalog_list2;

					 	$nav .= $usefull_type2;
					 	

					 	$nav .= "<a href=\"javascript:void(0)\" onclick=\"askRemovePage('0','".$v['position']."','".$v['idx']."', '".$v["cid"]."')\">
							<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i>
					 	</a>";

						$nav .= "</div>";
						
						$nav .= "</div>";	
					}				
				}
				 
			}

		}
		return $nav;
	}
}