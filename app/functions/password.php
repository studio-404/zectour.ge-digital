<?php 
namespace functions;

class password
{
	public static function index($pwd) 
	{
	   	if (strlen($pwd) < 8) {
	        $errors[] = "პაროლი უნდა შედგებოდეს მინიმუმ 8 სიმბოლოსგან !";
	        return false;
	    }

	    if (!preg_match("#[0-9]+#", $pwd)) {
	        $errors[] = "პაროლი უნდა შეიცავდეს მინიმუმ ერთ ციფრს !";
	        return false;
	    }

	    if (!preg_match("#[a-z]+#", $pwd)) {
	        $errors[] = "პაროლი უნდა შეიცავდეს მინიმუმ ერთ პატარა ასოს !";
	        return false;
	    }

	    if (!preg_match("#[A-Z]+#", $pwd)) {
	        $errors[] = "პაროლი უნდა შეიცავდეს მინიმუმ ერთ დიდ ასოს !";
	        return false;
	    }    

		return true;
	}
}