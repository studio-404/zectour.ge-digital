<?php 
namespace functions;
class timeleft
{
	public static function index($todate)
	{
		$diff = $todate - time();
		$days = floor($diff/(60*60*24));
		$hours = round(($diff-$days*60*60*24)/(60*60));
		if($_SESSION['LANG']=="ge"){
			$out = sprintf(
				"დარჩა %s დღე და %s საათი",
				$days, 
				$hours
			);	
		}else if($_SESSION['LANG']=="ru"){
			$out = sprintf(
				"Останавливался в течение %s дней и %s часов",
				$days, 
				$hours
			);	
		}else{
			$out = sprintf(
				"%s days %s hours remain",
				$days, 
				$hours
			);
		}
		return $out;
	}
}