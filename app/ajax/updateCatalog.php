<?php 
class updateCatalog
{
	public $out; 
	
	public function __construct()
	{
		
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			),
			"Success" => array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>"!"
			)
		);

		$idx = filter_var(functions\request::index("POST","idx"), FILTER_SANITIZE_NUMBER_INT);
		$date = functions\request::index("POST","date");
		$title = functions\request::index("POST","title");
		$chooseTouristCount = functions\request::index("POST","chooseTouristCount");
		$price = functions\request::index("POST","price");
		$price_child = functions\request::index("POST","price_child");

		$price_child512 = functions\request::index("POST","price_child512");			
		$price_child1220 = functions\request::index("POST","price_child1220");			
		$min_liter = functions\request::index("POST","min_liter");

		$sold = functions\request::index("POST","sold");
		$shortDescription = functions\request::index("POST","shortDescription");
		$longDescription = functions\request::index("POST","longDescription");
		$locations = functions\request::index("POST","locations");
		$showwebsite = functions\request::index("POST","choosevisibiliti");
		$hompagelist = functions\request::index("POST","hompagelist");
		$lang = functions\request::index("POST","lang");


		$serialPhotos = unserialize(functions\request::index("POST","serialPhotos"));

		$Database = new Database('products', array(
			'method'=>'edit', 
			'idx'=>$idx, 
			'date'=>$date, 
			'title'=>$title, 
			'chooseTouristCount'=>$chooseTouristCount, 
			'price'=>$price, 
			'price_child'=>$price_child, 
			'price_child512'=>$price_child512,
			'price_child1220'=>$price_child1220,
			'min_liter'=>$min_liter,
			'sold'=>$sold, 
			'shortDescription'=>$shortDescription, 
			'longDescription'=>$longDescription, 
			'locations'=>$locations, 
			'showwebsite'=>$showwebsite, 
			'hompagelist'=>$hompagelist, 
			'lang'=>$lang, 
			'serialPhotos'=>$serialPhotos 
		));

		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"",
				"Details"=>""
			),
			"Success"=>array(
				"Code"=>1, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			)
		);

		return $this->out;
	}
}