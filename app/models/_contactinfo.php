<?php 
class _contactinfo
{
	public $data;

	public function index()
	{
		require_once("app/functions/files.php"); 
		require_once("app/functions/strip_output.php");
		require_once("app/functions/l.php");
		$l = new functions\l();

		$out = "";
		
		if(isset($this->data[0]["description"]) && $this->data[0]["description"]!=""){
			$workinghours = strip_tags($this->data[0]["description"]);
			$out .= sprintf(
				"<p class=\"data\">%s: %s</p>",
				$l->translate("workinghours"), 
				$workinghours
			);
		}

		if(isset($this->data[1]["description"]) && $this->data[1]["description"]!=""){
			$mobile = strip_tags($this->data[1]["description"]);
			$out .= sprintf(
				"<p class=\"data\"><i class=\"fa fa-mobile\" aria-hidden=\"true\"></i> %s</p>",
				$mobile
			);
		}

		if(isset($this->data[2]["description"]) && $this->data[2]["description"]!=""){
			$email = strip_tags($this->data[2]["description"]);
			$out .= sprintf(
				"<p class=\"data\"><i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i> %s</p>",
				$email
			);
		}

		if(isset($this->data[3]["description"]) && $this->data[3]["description"]!=""){
			$address = strip_tags($this->data[3]["description"]);
			$out .= sprintf(
				"<p class=\"data\"><i class=\"fa fa-building-o\" aria-hidden=\"true\"></i> %s</p>",
				$address
			);
		}

		return $out;
	}
}