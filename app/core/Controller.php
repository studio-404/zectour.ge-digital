<?php
class Controller{
	
	public function model($model)
	{
		$include = 'app/models/'. $model . '.php';
		if(file_exists($include)){
			require_once $include;
			return new $model();
		}
	}

	public function view($view, $data = [])
	{
		require_once 'app/views/' . $view . '.php';
	}

}
?>