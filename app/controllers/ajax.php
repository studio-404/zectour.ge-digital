<?php
class ajax extends Controller
{
	public $out;

	public function index($lang = "", $name = "")
	{
		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომახხ !",
				"Details"=>"დამატებითი ინფო არ მოიძებნა..."
			)
		);
		 
		if(file_exists("app/ajax/" . $name . ".php")){
			require_once("app/ajax/" . $name . ".php");
			$object = new $name;
			$this->out = $object->index();
		}
		

		echo json_encode($this->out);
	}
}
?>