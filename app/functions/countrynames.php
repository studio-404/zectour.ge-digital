<?php
namespace functions;

class countrynames
{
	public function __construct()
	{

	}

	public function options($lang)
	{
		$Database = new \Database('countries', array(
				'method'=>'select', 
				'lang'=>$lang
		));
		$fetch = $Database->getter();

		$option = "";
		foreach ($fetch as $op) {
			$option .= sprintf(
				"<option value=\"%d\">%s</option>",
				$op['idx'],
				$op['name']
			);
		}

		return $option;
	}
}

