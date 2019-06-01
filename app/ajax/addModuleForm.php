<?php 
class addModuleForm
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

		$moduleSlug = functions\request::index("POST","moduleSlug");
		$lang = functions\request::index("POST","lang");
		$random = functions\string2::random(25);

		$form = functions\makeForm::open(array(
			"action"=>"?",
			"method"=>"post",
			"id"=>"",
			"id"=>"",
		));

		$form .= functions\makeForm::label(array(
			"id"=>"dateLabel", 
			"for"=>"date", 
			"name"=>"თარიღი: ( დღე-თვე-წელი )",
			"require"=>""
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"დღე/თვე/წელი", 
			"id"=>"date", 
			"name"=>"date",
			"value"=>date("d-m-Y")
		));

		$form .= "<script type=\"text/javascript\"> $(\"#date\").datepicker({ dateFormat: \"dd-mm-yy\"}).attr(\"readonly\",\"readonly\");</script>";

	
		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"დასახელება", 
			"id"=>"title", 
			"name"=>"title",
			"value"=>""
		));


		$form .= functions\makeForm::label(array(
			"id"=>"longDescription", 
			"for"=>"pageText", 
			"name"=>"აღწერა",
			"require"=>""
		));

		$form .= functions\makeForm::textarea(array(
			"id"=>"pageText",
			"name"=>"pageText",
			"placeholder"=>"აღწერა",
			"value"=>""
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"კლასი", 
			"id"=>"classname", 
			"name"=>"classname",
			"value"=>""
		));

		$form .= functions\makeForm::inputText(array(
			"placeholder"=>"ბმული", 
			"id"=>"link", 
			"name"=>"link",
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

  		$form .= sprintf(
  			"<input type=\"hidden\" name=\"random\" id=\"random\" value=\"%s\" />",
  			$random
  		);
  		$form .= "<input type=\"hidden\" name=\"file_attach_type\" id=\"file_attach_type\" value=\"module\" />";
  		$form .= "<ul class=\"collection with-header\" id=\"sortableFiles-box\">";


      	$form .= "</ul>";

		$form .= functions\makeForm::close();

		
		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"form" => $form,
			"attr" => "formModuleAdd('".$moduleSlug."', '".$lang."')"
		);



		return $this->out;
	}
}