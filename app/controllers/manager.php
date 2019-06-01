<?php 
class manager extends Controller{
	
	public function index($name = '')
	{
		session_destroy();

		/* view */
		$this->view('manager/index', [
			"header" => array(
				"website" => Config::WEBSITE,
				"public" => Config::PUBLIC_FOLDER
			),
			"name" => $name
		]);
	}

}