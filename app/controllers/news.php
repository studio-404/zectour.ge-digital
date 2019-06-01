<?php 
class News extends Controller
{
	
	public function __construct()
	{
		
	}

	public function index($lang = '', $newsId = '')
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

		$s = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : Config::MAIN_CLASS;
		$db_pagedata = new Database("page", array(
			"method"=>"selecteBySlug", 
			"slug"=>$s,
			"lang"=>$_SESSION['LANG'], 
			"all"=>true
		));
		$db_footer = new Database("modules", array(
			"method"=>"selectById", 
			"idx"=>18,
			"lang"=>$_SESSION['LANG']
		));

		$db_publicationss = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"publications",
			"from"=>0, 
			"num"=>4
		));

		/* HEDARE */
		$header = $this->model('_header');
		$header->public = Config::PUBLIC_FOLDER; 
		$header->lang = $_SESSION["LANG"]; 
		

		/* SOCIAL */
		$social = $this->model('_social');
		$social->networks = $db_socials->getter(); 

		/* LANGUAGES */
		$languages = $this->model('_lang'); 
		$languages->langs = $db_langs->getter();

		/* NAVIGATION */
		$navigation = $this->model('_navigation');
		$navigation->data = $db_navigation->getter();

		/* publications */
		$publications = $this->model('_publications');
		$publications->data = $db_publicationss->getter(); 

		/* header top */
		$headertop = $this->model('_top');
		$headertop->data["socialNetworksModule"] = $social->index();
		$headertop->data["languagesModule"] = $languages->index();
		$headertop->data["navigationModule"] = $navigation->index();

		/*footer */
		$footer = $this->model('_footer');
		$footer->data = $db_footer->getter(); 

		if(!isset($newsId) || !is_numeric($newsId)){
			$header->pagedata = $db_pagedata; 
			$db_news = new Database("modules", array(
				"method"=>"selectModuleByType", 
				"type"=>"news", 
				"from"=>0, 
				"num"=>5
			));
			/* MAIN NEWS */
			$mainnews = $this->model('_mainnews');
			$mainnews->data = $db_news->getter();
			/* OTHER NEWS */
			$othernews = $this->model('_othernews');
			$othernews->data = $db_news->getter();
			/* view */
			$this->view('news/index', [
				"header"=>array(
					"website"=>Config::WEBSITE,
					"public"=>Config::PUBLIC_FOLDER
				),
				"headerModule"=>$header->index(), 
				"pageData"=>$db_pagedata->getter(), 
				"mainnews"=>$mainnews->index(), 
				"othernews"=>$othernews->index(), 
				"publications"=>$publications->index(), 
				"headertop"=>$headertop->index(), 
				"footer"=>$footer->index() 
			]);
		}else{
			$db_news = new Database("modules", array(
				"method"=>"selectById", 
				"lang"=>$_SESSION['LANG'],  
				"idx"=>$newsId 
			));
			$header->pagedata = $db_news; 


			$db_news2 = new Database("modules", array(
				"method"=>"selectModuleByType", 
				"type"=>"news", 
				"from"=>0, 
				"num"=>5
			));
			/* MAIN NEWS */
			$mainnews = $this->model('_mainnews');
			$mainnews->data = $db_news->getter();

			/* OTHER NEWS */
			$othernews = $this->model('_othernews');
			$othernews->data = $db_news2->getter();
			$othernews->startAt = 0;

			$mainnews->inside = "true";
			/* view */
			$this->view('news/index', [
				"header"=>array(
					"website"=>Config::WEBSITE,
					"public"=>Config::PUBLIC_FOLDER
				),
				"headerModule"=>$header->index(), 
				"pageData"=>$db_pagedata->getter(), 
				"mainnews"=>$mainnews->index(), 
				"publications"=>$publications->index(), 
				"othernews"=>$othernews->index(), 
				"headertop"=>$headertop->index(), 
				"footer"=>$footer->index() 
			]);
		}
	}

}