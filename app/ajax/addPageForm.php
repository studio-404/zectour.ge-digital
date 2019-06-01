<?php
class addPageForm 
{
	public $out; 

	public function __construct()
	{
		require_once 'app/core/Config.php';
		if(!isset($_SESSION[Config::SESSION_PREFIX."username"]))
		{
			exit();
		}
	}
	
	public function index(){
		require_once 'app/core/Config.php';
		require_once 'app/functions/makeForm.php';
		require_once 'app/functions/request.php';
		require_once 'app/functions/string2.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$call = functions\request::index("POST","call");
		$lang = functions\request::index("POST","lang");
		$random = functions\string2::random(25);

		$form = functions\makeForm::open(array(
			"action"=>"?",
			"method"=>"post",
			"id"=>"",
			"id"=>"",
		));

		$form .= functions\makeForm::inputHidden(array(
			"name"=>"input_cid",
			"id"=>"input_cid",
			"value"=>"0"
		));

		$form .= functions\makeForm::inputHidden(array(
			"name"=>"lang",
			"id"=>"lang",
			"value"=>$lang
		));

		$form .= functions\makeForm::select(array(
			"id"=>"chooseNavType",
			"choose"=>"აირჩიეთ ნავიგაციის ტიპი",
			"options"=>array("მთავარი", "დამატებითი"),
			"selected"=>"false",
			"disabled"=>"false"
		));

		$form .= functions\makeForm::select(array(
			"id"=>"choosePageType",
			"choose"=>"აირჩიეთ გვერდის ტიპი",
			"options"=>array(
				"text"=>"ტექსტური",
				"news"=>"სიახლეები", 
				"plugin"=>"პლაგინი",
				"catalog"=>"კატალოგი"
			),
			"selected"=>"false",
			"disabled"=>"false"
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"დასახელება", 
			"id"=>"title", 
			"name"=>"title",
			"value"=>""
		));


		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"ბმული", 
			"id"=>"slug", 
			"name"=>"slug",
			"value"=>""
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"კლასი", 
			"id"=>"cssClass", 
			"name"=>"cssClass",
			"value"=>""
		));

		$parentModuleOptions = new Database('modules', array(
			'method'=>'parentModuleOptions', 
			'lang'=>'ge'
		));

		$form .= functions\makeForm::select(array(
			"id"=>"attachModule",
			"choose"=>"მიამაგრე მოდული",
			"options"=>$parentModuleOptions->getter(),
			"selected"=>"false",
			"disabled"=>"false"
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"გადამისამართება", 
			"id"=>"redirect", 
			"name"=>"redirect",
			"value"=>"" 
		));

		$form .= functions\makeForm::label(array(
			"id"=>"shortDescription", 
			"for"=>"pageDescription", 
			"name"=>"მოკლე აღწერა",
			"require"=>""
		));

		$form .= functions\makeForm::textarea(array(
			"id"=>"pageDescription",
			"name"=>"pageDescription",
			"placeholder"=>"მოკლე აღწერა",
			"value"=>""
		));

		$form .= functions\makeForm::label(array(
			"id"=>"longDescription", 
			"for"=>"pageText", 
			"name"=>"ვრცელი აღწერა",
			"require"=>""
		));

		$form .= functions\makeForm::textarea(array(
			"id"=>"pageText",
			"name"=>"pageText",
			"placeholder"=>"ვრცელი აღწერა",
			"value"=>""
		));

		$form .= "<div class=\"row\" id=\"photoUploaderBox\" style=\"margin:0 -10px\">";
		
		$form .= "<div class=\"col s4 imageItem\" id=\"img1\">
			<div class=\"card\">
	    
	    		<div class=\"card-image waves-effect waves-block waves-light\">
	    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"\" />
	      			<img class=\"activator\" src=\"/public/img/noimage.png\" />
	    		</div>

	    		<div class=\"card-content\">
                	<p>
                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img1')\" class=\"large material-icons\">mode_edit</a>
                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img1')\" class=\"large material-icons\">delete</a>
                	</p>
              	</div>

    		</div>
  		</div>";				

  		$form .= "</div>";
  		
  		$form .= "<div style=\"clear:both\"></div>";

  		$form .= "<div class=\"input-field\">
            <label>ფაილის მიმაგრება: </label>
          </div>";

        $form .= "<div style=\"clear:both\"></div>";

        $form .= "<a href=\"javascript:void(0)\" class=\"waves-effect waves-light btn margin-bottom-20\" style=\"clear:both; margin-top: 40px;\" onclick=\"openFileManagerForFiles('attachfiles')\"><i class=\"material-icons left\">note_add</i>ატვირთვა</a>";

  		$form .= "<input type=\"hidden\" name=\"random\" id=\"random\" value=\"".$random."\" />";
  		$form .= "<input type=\"hidden\" name=\"file_attach_type\" id=\"file_attach_type\" value=\"page\" />";
  		$form .= "<ul class=\"collection with-header\" id=\"sortableFiles-box\">";


      	$form .= "</ul>";
  		
  	


		$form .= functions\makeForm::close();

		if($call == "true"){
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				),
				"form" => $form,
				"attr" => "formPageAdd()"
			);	
		}

		return $this->out;
	}

}
?>