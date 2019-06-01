<?php 
namespace functions;

class dateFormat
{
	function validateMonthDayYear($date)
	{
	    $d = \DateTime::createFromFormat('m-d-Y', $date);
	    echo $d;
	    return $d && $d->format('m-d-Y') === $date;
	}
}