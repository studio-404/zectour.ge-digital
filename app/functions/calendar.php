<?php 
namespace functions;
 
class calendar
{
	public $geomonth; 
	public $engmonth; 
	public $rusmonth; 

	public $date;
	public $day;
	public $month;
	public $year;

	public $Cday;
	public $Cmonth;
	public $Cyear;

	public $getYear;
	public $getMonth;

	public function __construct()
	{
		$this->geomonth = array("January"=>"იანვარი", "February"=>"თებერვალი", "March"=>"მარტი", "April"=>"აპრილი", "May"=>"მაისი", "June"=>"ივნისი", "July"=>"ივლისი", "August"=>"აგვისტო", "September"=>"სექტემბერი", "October"=>"ოქტომბერი", "November"=>"ნოემბერი", "December"=>"დეკემბერი");
		$this->rusmonth = array("January"=>"январь", "February"=>"февраль", "March"=>"март", "April"=>"апрель", "May"=>"май", "June"=>"июнь", "July"=>"июль", "August"=>"август", "September"=>"сентябрь", "October"=>"октябрь", "November"=>"ноябрь", "December"=>"декабрь");

		$this->date = time();
		$this->day = date('d', $this->date); 
		$this->month = date('m', $this->date);
		$this->year = date('Y', $this->date);

		$this->Cday = date('d', $this->date);
		$this->Cmonth = date('m', $this->date);
		$this->Cyear = date('Y', $this->date);
	}

	public function index($lang)
	{
		if(!isset($this->month) || !isset($this->year) || $this->month=="" || $this->year==""){
			exit();
		}
		if(isset($this->getMonth)){ $this->month=$this->getMonth; }
		if(isset($this->getYear)){ $this->year=$this->getYear; }

		$this->first_day = mktime(0, 0, 0, $this->month, 1, $this->year);
		$this->title = date('F',$this->first_day);
		if($lang=="ge")
		{
			$this->title = $this->geomonth[$this->title]; 
			$this->weekDayNames = array("ორშ","სამ","ოთხ","ხუთ","პარ","შაბ","კვი");
		}
		else if($lang=="ru")
		{
			$this->title = $this->rusmonth[$this->title]; 	
			$this->weekDayNames = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
		}
		else
		{ 
			// english the same
			$this->weekDayNames = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
		}

		$this->day_of_week = date('D', $this->first_day);

		switch($this->day_of_week)
		{
			case "Mon": $this->blank=0; break;
			case "Tue": $this->blank=1; break;
			case "Wed": $this->blank=2; break;
			case "Thu": $this->blank=3; break;
			case "Fri": $this->blank=4; break;
			case "Sat": $this->blank=5; break;
			case "Sun": $this->blank=6; break;
			default: exit;
		}

		$this->days_in_month = cal_days_in_month(0, $this->month, $this->year);

		$this->out = "<table border=\"1\" cellspacing=\"10\" cellpadding=\"10\">\n";

		$this->out .= "<tr>\n";
		$this->out .= "<td colspan=\"7\" id=\"title-calendar\">\n";

		if($this->month!=1)
		{ 
			$this->yy_month = $this->month-1; 
			$this->yy_year = $this->year; 
		}
		else
		{ 
			$this->yy_month = 12; 
			$this->yy_year = $this->year-1; 
		}

		/* onclick="hashx('?month=<?=$yy_month?>&amp;year=<?=$yy_year?>&amp;lang=<?=$_GET[lang]?>')" */
		$this->out .= "<a href=\"javascript:void(0)\" onclick=\"loadCal('prev', '".$this->month."', '".$this->year."', '".$_SESSION['LANG']."')\">&nbsp;</a>";
		$this->out .= $this->title." ".$this->year;		
		/* onclick="hashx('?month=<?=$xx_month?>&amp;year=<?=$xx_year?>&amp;lang=<?=$_GET[lang]?>')" */
		$this->out .= "<a href=\"javascript:void(0)\" onclick=\"loadCal('next', '".$this->month."', '".$this->year."', '".$_SESSION['LANG']."')\">&nbsp;</a>";

		$this->out .= "</td>\n";
		$this->out .= "</tr>\n";


		// $this->out .= "<tr>\n";
		// $this->out .= "<td colspan=\"7\">&nbsp;";
		// $this->out .= "</td>\n";
		// $this->out .= "</tr>\n";

		$this->out .= "<tr style=\"margin:5px 0px\">\n";
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[0]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[1]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[2]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[3]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[4]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[5]);
		$this->out .= sprintf("<td class=\"weekDay\">%s</td>\n", $this->weekDayNames[6]);
		$this->out .= "</tr>\n";

		$this->day_count = 1;

		/* Dayes  */ 
		$this->out .= "<tr>";
		while($this->blank > 0)
		{
			$this->out .= "<td></td>";
			$this->blank = $this->blank-1;
			$this->day_count++;
		}
		
		$this->day_num = 1;

		while($this->day_num <= $this->days_in_month)
		{
			$this->d = $this->year . "/" . $this->month . "/" . $this->day_num;
			$this->to_time = strtotime($this->d);

			$Database = new \Database("modules", array(
					"method"=>"selectMonthEvents", 
					"day"=>$this->day_num,
					"month"=>$this->month,
					"year"=>$this->year, 
					"lang"=>$_SESSION['LANG']
			));
			$fetch = $Database->getter();

			// if($this->day_num == $this->day && $this->month == $this->Cmonth && $this->year == $this->Cyear)
			// {
			// 	$this->out .= "<td><div class=\"currentDay\">".$this->day_num."</div></td>";
			// }
			// else
			// {
				if($fetch){
					$titleUrl = str_replace(" ","-",strip_tags($fetch['title']));
					$link = \Config::WEBSITE.$_SESSION['LANG']."/event/".$fetch['idx']."/".$titleUrl;
					$this->out .= sprintf(
						"<td class='day_numbers'><div class=\"event_exists tooltipped\" data-position=\"left\" data-delay=\"50\" data-tooltip=\"%s\"><a href=\"%s\">%s</a></div></td>",
							htmlentities($fetch['title']), 
							$link, 
							$this->day_num 
						); 	
				}else{
					$this->out .= sprintf(
						"<td class='day_numbers'><div>%s</div></td>", 
						$this->day_num
					); 
				}
			// }
			$this->day_num++;
			$this->day_count++;
			
			if($this->day_count>7)
			{
				$this->out .= "</tr><tr>";
				$this->day_count = 1;
			}
		}

		while($this->day_count > 1 && $this->day_count <= 7)
		{
			$this->out .= "<td></td>";
			$this->day_count++;
		}
		
		// $this->out .= "<tr>\n";
		// $this->out .= "<td colspan=\"7\">&nbsp;";
		// $this->out .= "</td>\n";
		// $this->out .= "</tr>\n";


		$this->out .= "</table>\n";

		return $this->out;
	}
}