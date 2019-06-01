<?php 
class loadCalendar
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/calendar.php';



		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$type = functions\request::index("POST","type");
		$currentMonth = functions\request::index("POST","currentMonth");
		$currentYear = functions\request::index("POST","currentYear");
		$lang = functions\request::index("POST","lang");

		$calendar = new functions\calendar();

		if($type=="next")
		{
			if($currentMonth>=12)
			{
				$calendar->getYear = $currentYear + 1;
				$calendar->getMonth = 1;
			}
			else
			{
				$calendar->getYear = $currentYear;
				$calendar->getMonth = $currentMonth + 1;
			}
		}
		else
		{// prev
			if($currentMonth<=1)
			{
				$calendar->getYear = $currentYear - 1;
				$calendar->getMonth = 12;
			}
			else
			{
				$calendar->getYear = $currentYear;
				$calendar->getMonth = $currentMonth - 1;
			}
		}

		

		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>""
			),
			"Success"=>array(
				"Code"=>1, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით ! ".$calendar->getYear." ".$calendar->getMonth,
				"Html"=>$calendar->index($lang),
				"Details"=>""
			)
		);


		return $this->out;
	}
}