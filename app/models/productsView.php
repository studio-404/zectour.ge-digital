<?php 
class productsView
{
	public $data;
	public $string;

	public function index(){
		require_once("app/functions/strip_output.php");
		$out = '';
		if(count($this->data)) : 
			foreach ($this->data as $val) {
				$titleUrl = str_replace(array(" ", "'"), "-", strip_output::index($val['title']));
				$style = ($val['showwebsite']==2) ? "black" : "red";
				$url = Config::WEBSITE.$_SESSION["LANG"]."/view/".$titleUrl."/?id=".(int)$val['idx'];
				$out .= sprintf("<tr>
					<td>%d</td>
					<td class=\"tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"%s\">
						<a href=\"%s\" target=\"_blank\" style=\"color: %s\">%s</a>
					</td>
					<td>
					<a href=\"javascript:void(0)\" onclick=\"editCatalog('%s','%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"რედაქტირება\">mode_edit</i></a>


					<a href=\"javascript:void(0)\" onclick=\"askRemoveCatalog('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i></a>
					</td>
					</tr>",
					(int)$val['idx'],
					strip_output::index($val['title']), 
					$url,
					$style,
					$this->string->cut(strip_tags($val['title']),45), 
					(int)$val['idx'],
					$_SESSION['LANG'], 
					(int)$val['idx']
				);
			}
		endif;
		return $out;
	}
}