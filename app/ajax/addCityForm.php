<?php
class addCityForm
{
	public $out; 

	public function __construct()
	{
		require_once 'app/core/Config.php';
		if(!isset($_SESSION[Config::SESSION_PREFIX."username"]))
		{
			exit();
		}
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$slug = functions\request::index("POST","slug");
		$lang = functions\request::index("POST","lang");
		

		$form = functions\makeForm::open(array(
			"action"=>"?",
			"method"=>"post",
			"class"=>"materialize",
			"id"=>"",
		));

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"დასახელება", 
			"id"=>"name", 
			"name"=>"name",
			"value"=>""
		));

		$form .= functions\makeForm::close();

		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"form" => $form,
			"attr" => "add_city('".$slug."', '".$lang."')"
		);



		return $this->out;
	}
}