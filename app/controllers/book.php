<?php 
class Book extends Controller
{
	public function __construct()
	{
		require_once 'app/functions/request.php';

		if(
		  !isset($_SESSION["_GEL_"]) || 
		  !isset($_SESSION["_RUB_"]) || 
		  !isset($_SESSION["_USD_"])  
		){
		  $currencymod = new Database('currencymod', array(
		    "method"=>"select"
		  ));
		  $fetchCur = $currencymod->getter();
		  $_SESSION["_GEL_"] = 1;
		  $_SESSION["_RUB_"] = $fetchCur[0]["value"] / 100;
		  $_SESSION["_USD_"] = $fetchCur[1]["value"] ;
		}

		if(!isset($_SESSION["token"]) || $_SESSION["token"]!=functions\request::index("GET","token")){
			die("Please try again !");
		}
	}

	public function index($name = "")
	{
		/* DATABASE */
		$db_langs = new Database("language", array(
			"method"=>"select"
		));
		
		$db_socials = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"social"
		));

		$db_navigation = new Database("page", array(
			"method"=>"select", 
			"cid"=>0, 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
		));

		$db_footerHelpNav = new Database("page", array(
			"method"=>"selecteByCid", 
			"cid"=>5, 
			"lang"=>$_SESSION['LANG']
		));

		$db_destinations = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"destination"
		));

		$db_tourtypes = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"tourtypes"
		));

		$s = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : Config::MAIN_CLASS;
		$db_pagedata = new Database("page", array(
			"method"=>"selecteBySlug", 
			"slug"=>$s,
			"lang"=>$_SESSION['LANG'], 
			"all"=>true
		));

		$idx = (functions\request::index("GET","id")) ? functions\request::index("GET","id") : 0;
		$db_products = new Database("products", array(
			"method"=>"selectById", 
			"idx"=>$idx,
			"lang"=>$_SESSION["LANG"]
		));


		/* HEDARE */
		$header = $this->model('_header');
		$header->public = Config::PUBLIC_FOLDER; 
		$header->lang = $_SESSION["LANG"]; 
		$header->pagedata = $db_pagedata; 

		/* SOCIAL */
		$social = $this->model('_social');
		$social->networks = $db_socials->getter(); 

		/* LANGUAGES */
		$languages = $this->model('_lang'); 
		$languages->langs = $db_langs->getter();

		/* NAVIGATION */
		$navigation = $this->model('_navigation');
		$navigation->data = $db_navigation->getter();

		
		/* header top */
		$headertop = $this->model('_top');
		$headertop->data["socialNetworksModule"] = $social->index();
		$headertop->data["languagesModule"] = $languages->index();
		$headertop->data["navigationModule"] = $navigation->index();

		/*footer */
		$footer = $this->model('_footer');
		$footer->data["socialNetworksModule"] = $social->index();
		$footer->data["footerHelpNav"] = $db_footerHelpNav->getter();

		/* view */
		$this->view('book/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"headerModule"=>$header->index(), 
			"headertop"=>$headertop->index(), 
			"pageData"=>$db_pagedata->getter(), 
			"productData"=>$db_products->getter(), 
			"footer"=>$footer->index() 
		]);
	}
}