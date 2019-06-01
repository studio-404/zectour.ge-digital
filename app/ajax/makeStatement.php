<?php 
class makeStatement
{
	public $out; 
	
	public function index(){
		require_once 'app/functions/request.php';
		require_once 'app/functions/password.php';
		require_once 'app/functions/checkUserExists.php';

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
		$checkUserExists = new functions\checkUserExists();
		
		$params = array();
		parse_str($formData, $params);
		
		if(!isset($params['loanMoney']) || !isset($params['loanMonth']) || $params['loanMoney']<=0 || $params['loanMonth']<=0)
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"გთხოვთ აირჩიოთ სასურველი თანხა და თვე !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if(
			(!isset($params['loan-name']) || $params['loan-name']=="") || 
			(!isset($params['loan-surname']) || $params['loan-surname']=="") || 
			(!isset($params['loan-pid']) || $params['loan-pid']=="") || 
			(!isset($params['loan-dob']) || $params['loan-dob']=="") || 
			(!isset($params['loan-faddress']) || $params['loan-faddress']=="") || 
			(!isset($params['loan-city']) || $params['loan-city']=="") || 
			(!isset($params['loan-mobile']) || $params['loan-mobile']=="") || 
			(!isset($params['loan-email']) || $params['loan-email']=="") || 
			(!isset($params['loan-jobTitle']) || $params['loan-jobTitle']=="") || 
			(!isset($params['loan-income']) || $params['loan-income']=="") || 
			(!isset($params['loan-contactPerson']) || $params['loan-contactPerson']=="") || 
			(!isset($params['loan-contactPersonNumber']) || $params['loan-contactPersonNumber']=="") || 
			(!isset($params['loan-password']) || $params['loan-password']=="") || 
			(!isset($params['loan-repassword']) || $params['loan-repassword']=="") 
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
		}else if($checkUserExists->index($params['loan-pid'], $params['loan-email'])){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"მომხმარებლის პირადი ნომერი ან ელ-ფოსტა უკვე გამოყენებულია !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if( !isset($params['checkbox1']) || $params['checkbox1'] != "on")
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"გთხოვთ დაეთანხმოთ წესებს და ისტორიის გადამოწმებას სს კრედიტინფო საქართველოს მონაცემთა ბაზაში !",
					"Details"=>"!"
				), 
				"Success" => array(
					"Code"=>0,
					"Text"=>"",
					"Details"=>""
				)
			);
		}else if($params['loan-password']!=$params['loan-repassword'])
		{
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"პაროლები არ ემთხვევა ერთმანეთს !",
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
			$pwd = functions\password::index($params['loan-password']);
			if($pwd){
				$Database = new Database('statements', array(
					'method'=>'insert', 
					'name'=>$params['loan-name'], 
					'surname'=>$params['loan-surname'], 
					'pid'=>$params['loan-pid'], 
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
					'contactPersonNumber'=>$params['loan-contactPersonNumber'], 
					'password'=>$params['loan-password'], 
					'loanMoney'=>$params['loanMoney'], 
					'loanMonth'=>$params['loanMonth'] 
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
							"Text"=>"ოპერაცია შესრულდა წარმატებით, პასუხს მიიღებთ SMS შეტყობინებით 15 წუთის განმავლობაში !",
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
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"პაროლი უნდა შედგებოდეს მინიმუმ 8 სიმბოლოსგან, იგი უნდა შეიცავდეს 1 დიდ და 1 პატარა ასოს, აგრეთვე მინიმუმ 1 ციფრს !",
						"Details"=>$pwd
					)
				);	
			}
			

			
		}


		return $this->out;
	}
}