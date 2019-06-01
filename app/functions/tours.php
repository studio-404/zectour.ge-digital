<?php 
namespace functions;
class tours{
	public function countToursByDestinations($args)
	{
		$Database = new \Database("products", array(
			"method"=>"countByDestination",
			"numberx"=>$args["numberx"],
			"lang"=>$_SESSION["LANG"]
		));

		return $Database->getter();
	}
}