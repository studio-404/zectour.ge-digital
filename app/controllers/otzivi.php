<?php  
class Otzivi extends Controller
{
	public $message = "";

	public function __construct()
	{
		if(
			isset($_POST["imia"])
		){
			//isset($_FILES["foto"]["name"])
			if(
				!isset($_POST["imia"]) || 
				empty($_POST["imia"]) ||
				!isset($_POST["otziv"]) || 
				empty($_POST["otziv"]) || 
				!isset($_FILES["foto"]["name"]) || 
				empty($_FILES["foto"]["name"])  
			){
				$this->message = "Все поля обязательны для заполнения.";
			}else if(
				!isset($_SESSION["csrf-token"]) || 
				$_SESSION["csrf-token"] != $_POST["csrf-token"]
			){
				$this->message = "Фатальная ошибка.";	
			}else{
				$check = getimagesize($_FILES["foto"]["tmp_name"]);

				$ext = explode(".", $_FILES["foto"]["name"]);
				$imageFileType = strtolower(end($ext));
				
				if(!$check){
					$this->message = "Файл не является изображением.";
				}else if($_FILES["foto"]["size"] > 2000000) {
					$this->message = "Извините, ваш файл слишком большой.";
				}else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif"){
					$this->message = "{$imageFileType} - К сожалению, разрешены только файлы JPG, JPEG, PNG и GIF.";
				}else{
					$filename = md5(time()). "." . $imageFileType;
					$target_file = Config::DIR . "public/filemanager/otzivi/" . $filename;
					$target_file_path[] = "/public/filemanager/otzivi/" . $filename;
					if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
						new Database("modules", array(
							"method"=>"add",
							"visibility"=>"1",
							"date"=>date("d-m-Y"),
							"moduleSlug"=>"otziviotturistam",
							"title"=>strip_tags(str_replace(array("'",'"',"$"),"",$_POST["imia"])),
							"pageText"=>strip_tags(str_replace(array("'",'"',"$"),"",$_POST["otziv"])),
							"serialPhotos"=>$target_file_path,
							"serialFiles"=>array()
						));

				        $this->message = "Операция прошла успешно. Отзыв будет добавлена ​​после модерации администратором";
				    } else {
				        $this->message = "Произошла ошибка.";
				    }
				}
			}

		}
	}

	public function index($name = "")
	{
		/* DATABASE */
		$db_langs = new Database("language", array(
			"method"=>"select"
		));

		$db_navigation = new Database("page", array(
			"method"=>"select", 
			"cid"=>0, 
			"nav_type"=>0,
			"lang"=>$_SESSION['LANG'],
			"status"=>0 
		));

		$db_otzivi = new Database("modules", array(
			"method"=>"selectModuleByType", 
			"type"=>"otziviotturistam"
		));
	

		$s = (isset($_SESSION["URL"][1])) ? $_SESSION["URL"][1] : Config::MAIN_CLASS;
		$db_pagedata = new Database("page", array(
			"method"=>"selecteBySlug", 
			"slug"=>$s,
			"lang"=>$_SESSION['LANG'], 
			"all"=>true
		));

		/* HEDARE */
		$header = $this->model('_header');
		$header->public = Config::PUBLIC_FOLDER; 
		$header->lang = $_SESSION["LANG"]; 
		$header->pagedata = $db_pagedata; 

		/* LANGUAGES */
		$languages = $this->model('_lang'); 
		$languages->langs = $db_langs->getter();

		/* NAVIGATION */
		$navigation = $this->model('_navigation');
		$navigation->data = $db_navigation->getter();

		/* otzivi */
		$otzivi = $this->model('_otzivi');
		$otzivi->data = $db_otzivi->getter();

		/* header top */
		$headertop = $this->model('_top');
		$headertop->data["languagesModule"] = $languages->index();
		$headertop->data["navigationModule"] = $navigation->index();

		/*footer */
		$footer = $this->model('_footer');

		/* view */
		$this->view('otzivi/index', [
			"header"=>array(
				"website"=>Config::WEBSITE,
				"public"=>Config::PUBLIC_FOLDER
			),
			"headerModule"=>$header->index(), 
			"headertop"=>$headertop->index(), 
			"otzivi"=>$otzivi->index(), 
			"message"=>$this->message, 
			"pageData"=>$db_pagedata->getter(), 
			"footer"=>$footer->index() 
		]);
	}
}
?>