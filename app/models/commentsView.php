<?php 
class commentsView
{
	public $data;
	public $string;

	public function index(){
		require_once("app/functions/strip_output.php"); 
		$out = '';
		if(count($this->data)) : 
			foreach ($this->data as $val) {
				$read = ($val['read']==0) ? 'style="background-color:#f2f2f2"' : '';
				$out .= sprintf("<tr %s>
						<td>%d</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>
							<a href=\"javascript:void(0)\" onclick=\"searchComments('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"სრულად ნახვა\">pageview</i></a>

							<a href=\"javascript:void(0)\" onclick=\"askRemoveComments('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i></a>
						</td>
					</tr>",
					strip_output::index($read), 
					(int)$val['id'],
					date("d/m/Y g:i:s", (int)$val['date']), 
					strip_output::index($val['firstname']),
					strip_output::index($val['organization']),
					strip_output::index($val['email']),
					(int)$val['id'], 
					(int)$val['id']
				);
			}
		endif;
		return $out;
	}
}