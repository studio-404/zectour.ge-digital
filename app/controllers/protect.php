<?php 
class Protect extends Controller
{
	public function __construct()
	{
		if(!isset($_SESSION['call'])){
			$_SESSION['call'] = 1;
		}else{
			$_SESSION['call'] = $_SESSION['call'] + 1;
		}

		if($_SESSION['call']>5000){
			die("Just Get Out !");
		}
	}

	public function index($name = "")
	{
		$name = Config::DIR.Config::PUBLIC_FOLDER_NAME."/img/s.png";
		$im = imagecreatefrompng($name);

		$im = imagecreate(100, 40);
		$string = (isset($_SESSION['protect_x'])) ? $_SESSION['protect_x'] : 123456;
		$bg = imagecolorallocate($im, 242, 243, 246);
		$red = imagecolorallocate($im, 51, 51, 51);
		$linecolor = imagecolorallocate($im, 0, 51, 153);
		for($i=0; $i < 6; $i++) {
		imagesetthickness($im, 1);
		imageline($im, 0, rand(0,30), 120, rand(0,30), $linecolor);
		}

		imagestring($im, 55, 30, 15, $string, $red);



		$filename = sha1("_".time().$_SERVER["REMOTE_ADDR"]).".png";
		$name = Config::PUBLIC_FOLDER_NAME."/_temporaty/".$filename;
		imagepng($im,$name,9);
		$dir    = Config::DIR.Config::PUBLIC_FOLDER_NAME.'/_temporaty/';
		$files = scandir($dir); 
		foreach($files as $file)
		{
			if($file!="." && $file!=".." && $file!=$filename)
			{
				$cerationTime = @filemtime($file);
				$now = time() - 3600;
				if($cerationTime<$now)
				{
					@unlink($dir.$file);
				}
			}
		}
		header("location: " . Config::WEBSITE.$name);
	}
}