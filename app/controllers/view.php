<?php 
class View extends Controller
{
	public $productGetter; 

	public function __construct()
	{
		require_once("app/functions/request.php");
		require_once 'app/functions/redirect.php';


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


		if(!functions\request::index("GET", "id")){
			functions\redirect::url(Config::WEBSITE.$_SESSION["LANG"]."/".Config::MAIN_CLASS);
		}

		$db_products = new Database("products", array(
			"method"=>"selectById", 
			"idx"=>(int)(functions\request::index("GET", "id")),
			"increament"=>true,
			"lang"=>$_SESSION["LANG"]
		));
		$this->productGetter = $db_products->getter();

		if(!$this->productGetter){
			functions\redirect::url(Config::WEBSITE.$_SESSION["LANG"]."/".Config::MAIN_CLASS);
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

		
		$db_photos = new Database("photos", array(
			"method"=>"selectByParent", 
			"idx"=>$this->productGetter["idx"],
			"type"=>"products",
			"lang"=>$_SESSION["LANG"]
		));

		$s = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : Config::MAIN_CLASS;
		$db_pagedata = new Database("page", array(
			"method"=>"selecteBySlug", 
			"slug"=>$s,
			"lang"=>$_SESSION['LANG'], 
			"all"=>true
		));

		$fav = false;
		if(isset($_SESSION[Config::SESSION_PREFIX."web_username"])){
			$db_favourites = new Database("favourites", array(
				"method"=>"check", 
				"user"=>$_SESSION[Config::SESSION_PREFIX."web_username"],
				"tour_id"=>$this->productGetter["idx"]
			));
			$fav = $db_favourites->getter();
		}

		/* HEDARE */
		$header = $this->model('_header');
		$header->public = Config::PUBLIC_FOLDER; 
		$header->lang = $_SESSION["LANG"]; 
		$header->pagedata = $db_pagedata; 
		$header->product = $this->productGetter; 

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
		$this->view('view/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"headerModule"=>$header->index(), 
			"headertop"=>$headertop->index(), 
			"pageData"=>$db_pagedata->getter(), 
			"productGetter"=>$this->productGetter, 
			"photos"=>$db_photos->getter(), 
			"fav"=>$fav, 
			"footer"=>$footer->index() 
		]);
	}
}