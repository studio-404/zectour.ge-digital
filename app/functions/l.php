<?php 
namespace functions;
class l
{
	public function translate($word, $l = "")
	{
		$LANG = ($l=="") ? $_SESSION['LANG'] : $l;
		$Database = new \Database("modules", array(
			"method"=>"translate", 
			"word"=>$word, 
			"lang"=>$LANG
		));

		if($Database->getter()){
			return $Database->getter();
		}else{
			return "E";
		}
	}
}