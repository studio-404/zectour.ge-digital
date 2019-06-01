<?php 
class editStatement
{
	public $out; 
	
	public function index(){
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
				"Details"=>""
			)
		);
		$formData = functions\request::index("POST","formData");
		
		$params = array();
		parse_str($formData, $params);
		
		if(
			(!isset($params['loan-name']) || $params['loan-name']=="") || 
			(!isset($params['loan-surname']) || $params['loan-surname']=="") || 
			(!isset($params['loan-dob']) || $params['loan-dob']=="") || 
			(!isset($params['loan-faddress']) || $params['loan-faddress']=="") || 
			(!isset($params['loan-city']) || $params['loan-city']=="") || 
			(!isset($params['loan-mobile']) || $params['loan-mobile']=="") || 
			(!isset($params['loan-email']) || $params['loan-email']=="") || 
			(!isset($params['loan-jobTitle']) || $params['loan-jobTitle']=="") || 
			(!isset($params['loan-income']) || $params['loan-income']=="") || 
			(!isset($params['loan-contactPerson']) || $params['loan-contactPerson']=="") || 
			(!isset($params['loan-contactPersonNumber']) || $params['loan-contactPersonNumber']=="")  
		)
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"გთხოვთ შეავსოთ * ( ფიფქით ) აღნიშნული სავალდებულო ველები !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}
		else
		{
			
			$Database = new Database('statements', array(
				'method'=>'edit', 
				'name'=>$params['loan-name'], 
				'surname'=>$params['loan-surname'], 
				'pid'=>$_SESSION["capex_user"], 
				'dob'=>$params['loan-dob'], 
				'faddress'=>$params['loan-faddress'], 
				'city'=>$params['loan-city'], 
				'mobile'=>$params['loan-mobile'], 
				'email'=>$params['loan-email'], 
				'jobTitle'=>$params['loan-jobTitle'], 
				'income'=>$params['loan-income'], 
				'position'=>$params['loan-position'], 
				'jobphone'=>$params['loan-jobphone'], 
				'contactPerson'=>$params['loan-contactPerson'], 
				'contactPersonNumber'=>$params['loan-contactPersonNumber']
			));
			$output = $Database->getter();

			if($output){
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
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"ოპერაციის შესრულებისას მოხდა შეცდომა !",
						"Details"=>""
					)
				);	
			}
			

			
		}


		return $this->out;
	}
}