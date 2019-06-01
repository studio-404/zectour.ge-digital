<?php 
class modelesView
{
	public $data;
	public $string;

	public function index(){
		require_once("app/functions/strip_output.php");
		$RESTRICTED_MODULE_DELETE_IDX = explode("|", Config::RESTRICTED_MODULE_DELETE_IDX);
		$out = '';
		if(count($this->data)) : 
			foreach ($this->data as $val) {
				$visibility = ($val['visibility']==0) ? 'visibility' : 'visibility_off';
				$out .= sprintf("<tr>
					<td>%d</td>
					<td class=\"tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"%s\">%s</td>
					<td>
					<a href=\"javascript:void(0)\" onclick=\"changeModuleVisibility(%d,%d)\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ხილვადობის შეცვლა\">%s</i></a>

					<a href=\"javascript:void(0)\" onclick=\"editModules('%s','%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i></a>


					<a href=\"javascript:void(0)\" onclick=\"askRemoveModule('%s')\" style=\"%s\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i></a>
					</td>
					</tr>",
					(int)$val['idx'],
					strip_output::index($val['title']), 
					$this->string->cut(strip_tags($val['title']),45),
					strip_output::index($val['visibility']),
					(int)$val['idx'],
					strip_output::index($visibility),
					(int)$val['idx'],
					strip_output::index($val['lang']), 
					(int)$val['idx'],
					(in_array($val["idx"], $RESTRICTED_MODULE_DELETE_IDX)) ? "display:none" : ""
				);
			}
		endif;
		return $out;
	}
}