<?php 
namespace functions;
class selectedDestinations
{
	public function index($all, $selected){
		$out = array();
		$selected = explode(",", $selected);
		foreach ($all as $d) {
			if(in_array($d["idx"], $selected)){
				$out[] = $d["title"];
			}
		}
		$out = implode(", ", $out);
		return $out;
	}
}