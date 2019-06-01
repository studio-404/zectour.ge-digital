<?php 
class userview
{
	public $data;
	public $string;

	public function index(){
		require_once("app/functions/strip_output.php"); 
		$out = '';
		if(count($this->data)) : 
			foreach ($this->data as $val) {
				$out .= sprintf("<tr>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>

						<td>
							<a href=\"javascript:void(0)\" onclick=\"viewUser('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"ნახვა\">pageview</i></a>

							<a href=\"javascript:void(0)\" onclick=\"askDeleteUser('%s')\"><i class=\"material-icons tooltipped\" data-position=\"bottom\" data-delay=\"50\" data-tooltip=\"წაშლა\">delete</i></a>
						</td>
					</tr>",
					date("d/m/Y g:i:s", (int)$val['register_date']), 
					strip_output::index($val['email']),
					strip_output::index($val['firstname']),
					strip_output::index($val['lastname']),
					$val['email'], 
					$val['email']
				);
			}
		endif;
		return $out;
	}
}