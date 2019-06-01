<?php 
class editCatalog
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

		$idx = functions\request::index("POST","idx");
		$lang = functions\request::index("POST","lang");
		$random = functions\string2::random(25);

		if($idx == "" || $lang=="")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მოხდა შეცდომა !",
					"Details"=>"!"
				)
			);
		}else{
			$Database = new Database('products', array(
					'method'=>'selectById', 
					'idx'=>$idx, 
					'lang'=>$lang
			));
			$output = $Database->getter();

			$photos = new Database('photos', array(
				'method'=>'selectByParent', 
				'idx'=>$idx, 
				'lang'=>$lang, 
				'type'=>"products"
			));
			$pictures = $photos->getter();


			$form = functions\makeForm::open(array(
				"action"=>"?",
				"method"=>"post",
				"id"=>"",
				"id"=>"",
			));

			$form .= "<input type=\"hidden\" name=\"language\" id=\"language\" value=\"".$_SESSION['LANG']."\" />";

			$form .= functions\makeForm::label(array(
				"id"=>"dateLabel", 
				"for"=>"date", 
				"name"=>"დამატების თარიღი",
				"require"=>""
			));

			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"date", 
				"name"=>"date",
				"value"=>date("d-m-Y", $output["date"])
			));


			$form .= functions\makeForm::label(array(
				"id"=>"titleLabel", 
				"for"=>"title", 
				"name"=>"დასახელება",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"title", 
				"name"=>"title",
				"value"=>$output["title"]
			));

			////
			
			$touristCount["dynamic"] = "დინამიური";
			$touristCount["dynamic2"] = "დინამიური 2 საავტობუსო ექსკურსია";
			$touristCount["alcohol"] = "ალკოჰოლი";
			$touristCount["simcard"] = "სიმ კარტა";
			$touristCount["rentcar"] = "მანქანის გაქირავება";
			for($x=1;$x<=10;$x++){
				$touristCount[$x] = $x." ტურისტისთვის";
			}

			$form .= functions\makeForm::label(array(
				"id"=>"chooseTouristCountLabel", 
				"for"=>"chooseTouristCount", 
				"name"=>"კატალოგის ტიპი",
				"require"=>""
			));

			$form .= functions\makeForm::select(array(
				"id"=>"chooseTouristCount",
				"choose"=>"აირჩიეთ ტურისების რაოდენობა",
				"options"=>$touristCount,
				"selected"=>$output["tourist_points"],
				"disabled"=>"false",
				"multiple"=>"false"
			));
			////


			$form .= functions\makeForm::label(array(
				"id"=>"priceLabel", 
				"for"=>"price", 
				"name"=>"ღირებულება",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"price", 
				"name"=>"price",
				"value"=>$output["price"]
			));

			//
			$form .= functions\makeForm::label(array(
				"id"=>"price_childLabel", 
				"for"=>"price_child", 
				"name"=>"ღირებულება ბავშვი",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"price_child", 
				"name"=>"price_child",
				"value"=>$output["price_child"]
			));

			$form .= functions\makeForm::label(array(
				"id"=>"price_child512_Label", 
				"for"=>"price_child512", 
				"name"=>"ღირებულება ბავშვი 5-12",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"price_child512", 
				"name"=>"price_child512",
				"value"=>$output["price_child512"]
			));

			$form .= functions\makeForm::label(array(
				"id"=>"price_child1220_Label", 
				"for"=>"price_child1220", 
				"name"=>"ღირებულება ბავშვი 12-20",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"price_child1220", 
				"name"=>"price_child1220",
				"value"=>$output["price_child1220"]
			));

			$form .= functions\makeForm::label(array(
				"id"=>"min_liter_Label", 
				"for"=>"min_liter", 
				"name"=>"შეძენის მინიმალური რაოდენობა",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"min_liter", 
				"name"=>"min_liter",
				"value"=>$output["min_liter"]
			));

			$form .= "<input type=\"hidden\" name=\"sold\" value=\"\" />";
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"sold", 
				"name"=>"sold",
				"value"=>$output["sold"]
			));


			$form .= functions\makeForm::label(array(
				"id"=>"shortDescriptionLabel", 
				"for"=>"shortDescription", 
				"name"=>"მოკლე აღწერა",
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"shortDescription",
				"name"=>"shortDescription",
				"placeholder"=>"",
				"value"=>$output["short_description"]
			));

			$form .= functions\makeForm::label(array(
				"id"=>"longDescriptionLabel", 
				"for"=>"longDescription", 
				"name"=>"ვრცელი აღწერა",
				"require"=>""
			));

			$form .= functions\makeForm::textarea(array(
				"id"=>"longDescription",
				"name"=>"longDescription",
				"placeholder"=>"",
				"value"=>$output["description"]
			));

			$form .= functions\makeForm::label(array(
				"id"=>"locationsLabel", 
				"for"=>"locations", 
				"name"=>"ადგილმდებარეობა/ადგილმდებარეობები",
				"require"=>""
			));
			
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"locations", 
				"name"=>"locations",
				"readonly"=>true,
				"value"=>$output["location"]
			));

			$form .= "<script type=\"text/javascript\">
			window.onmessage = function(e){
			    console.log(e.data);
			    $(\"#locations\").val(e.data);
			};
			</script>";
			
			$_SESSION["token"] = $random;
			$form .= sprintf(
				"<iframe class=\"locationsMap\" src=\"%s?v=2&token=%s&l=%s\"></iframe>",
				Config::PUBLIC_FOLDER."googleMap/edit.php",
				$random,
				$output["location"]
			);

			
			$form .= functions\makeForm::label(array(
				"id"=>"hompagelist_Label", 
				"for"=>"hompagelist", 
				"name"=>"მთავარ გვერდზე გამოჩენა",
				"require"=>""
			));
		
			$form .= functions\makeForm::inputText(array(
				"placeholder"=>"", 
				"id"=>"hompagelist", 
				"name"=>"hompagelist",
				"value"=>$output["hompagelist"]
			));

			$options4 = array(
				1=>"დამალვა",
				2=>"გამოჩენა"
			);

			$form .= functions\makeForm::label(array(
				"id"=>"visibilitiTypeLabel", 
				"for"=>"choosevisibiliti", 
				"name"=>"ხილვადობა",
				"require"=>""
			));

			$form .= functions\makeForm::select(array(
				"id"=>"choosevisibiliti",
				"choose"=>"აირჩიეთ ხილვადობა",
				"options"=>$options4,
				"selected"=>1,
				"disabled"=>"false"
			));


			$form .= "<script type=\"text/javascript\">";
			$form .= sprintf(
				"$('#choosevisibiliti').find('option[value=\"%d\"]').prop('selected', true);",
				$output['showwebsite']
			);
			$form .= "$('#choosevisibiliti').material_select();";
			$form .= "$('#chooseTouristCount').material_select();";
			$form .= "</script>";

			$form .= "<div class=\"row\" id=\"photoUploaderBox\" style=\"margin:0 -10px\">";

			if(count($pictures)){
				$i = 2;
				
				foreach($pictures as $picture) {
					$form .= "<div class=\"col s4 imageItem\" id=\"img".$i."\">
						<div class=\"card\">
				    		<div class=\"card-image waves-effect waves-block waves-light\">
				    			<input type=\"hidden\" name=\"managerFiles[]\" class=\"managerFiles\" value=\"".$picture['path']."\" />
				      			<img class=\"activator\" src=\"".Config::WEBSITE.Config::MAIN_LANG."/image/loadimage?f=".Config::WEBSITE_.$picture["path"]."&w=215&h=173\" />
				    		</div>

				    		<div class=\"card-content\">
			                	<p>
			                		<a href=\"javascript:void(0)\" onclick=\"openFileManager('photoUploaderBox', 'img".$i."')\" class=\"large material-icons\">mode_edit</a>
			                		<a href=\"javascript:void(0)\" onclick=\"removePhotoItem('img".$i."')\" class=\"large material-icons\">delete</a>
			                	</p>
			              	</div>

			    		</div>
			  		</div>";
			  		$i++;
				}
			}

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

			$form .= functions\makeForm::close();

			
			$this->out = array(
				"Error" => array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				),
				"form" => $form,
				"attr" => "formCatalogEdit('".$idx."','".$lang."')"
			);	
		}

		

		return $this->out;
	}
}