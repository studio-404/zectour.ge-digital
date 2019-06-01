<?php 
class websiteAdditionalNavigation
{
	public $navigation;

	public function index(){
		require_once 'app/core/Config.php';
		$nav = "";
		if(count($this->navigation)){
			foreach ($this->navigation as $val) {
				$slug = ($val['redirect']!="false") ? $val['redirect'] : Config::WEBSITE.Config::PAGE_PREFIX."/".$val['type']."/".$val['lang']."/".$val['idx']."/".$val['slug']; 
				$visibility = ($val['visibility']==1) ? "visibility_off" : "visibility";
				$nav .= sprintf(
					"
					<tr data-item=\"%d\" data-cid=\"".$val['cid']."\" class=\"level2-0\">
					<td class=\"roboto-font\">%d</td>
					<td class=\"roboto-font\">%d</td>
					<td><a href=\"%s\" target=\"_blank\">%s</a></td>
					<td class=\"roboto-font\">%s</td>
					<td>
					<a href=\"javascript:void(0)\" onclick=\"changeVisibility('%s','%s')\">
						<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ხილვადობის შეცვლა\">%s</i>
					</a>

					<a href=\"javascript:void(0)\" onclick=\"editPage('%s','%s')\">
						<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i>
					</a>
					<a href=\"javascript:void(0)\" onclick=\"askRemovePage('1','%s','%s','%s')\">
						<i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i>
					</a>
					</td>
					</tr>
					",
					$val['idx'],
					$val['idx'],
					$val['position'],
					$slug,				
					$val['title'],
					$val['type'],
					$val['visibility'],
					$val['idx'],
					$visibility,
					$val['idx'],
					$val['lang'],
					$val['position'],
					$val['idx'], 
					$val['cid'] 
				);
			}
		}
		return $nav;
	}
}