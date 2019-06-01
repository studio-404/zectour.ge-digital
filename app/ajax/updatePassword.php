<?php 
class updatePassword
{
	public $out; 
	
	public function index(){
		require_once 'app/functions/request.php';
		require_once 'app/functions/password.php';

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
			(!isset($params['oldPassword']) || $params['oldPassword']=="") || 
			(!isset($params['newPassword']) || $params['newPassword']=="") || 
			(!isset($params['repeatPassword']) || $params['repeatPassword']=="") 
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
			$checkOldPassword = new Database('statements', array(
				'method'=>'checkOldPassword',
				'user'=>$_SESSION["capex_user"],
				'old'=>$params['oldPassword']
			));	
			$output = $checkOldPassword->getter(); 
			if($output)
			{
				$pwd = functions\password::index($params['newPassword']);
		
				if($params['newPassword']!=$params['repeatPassword'])
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
				}else if(!$pwd){
					$this->out = array(
						"Error" => array(
							"Code"=>1, 
							"Text"=>"პაროლი უნდა შედგებოდეს მინიმუმ 8 სიმბოლოსგან, იგი უნდა შეიცავდეს 1 დიდ და 1 პატარა ასოს, აგრეთვე მინიმუმ 1 ციფრს !",
							"Details"=>"!"
						), 
						"Success" => array(
							"Code"=>0,
							"Text"=>"",
							"Details"=>""
						)
					);
				}else{
					$Database = new Database('statements', array(
						'method'=>'updateUserPassword', 
						'user'=>$_SESSION["capex_user"], 
						'newpassword'=>$params['newPassword']
					));
					$output2 = $Database->getter();
					if($output2)
					{
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
								"Text"=>"ოპერაციის შესრულებისას მოხდა შეცდომა",
								"Details"=>""
							),
							"Success"=>array(
								"Code"=>0, 
								"Text"=>"",
								"Details"=>""
							)
						);
					}
				}

				
			}else{
				$this->out = array(
					"Error" => array(
						"Code"=>1, 
						"Text"=>"ძველი პაროლი არასწორია !",
						"Details"=>"!"
					), 
					"Success" => array(
						"Code"=>0,
						"Text"=>"",
						"Details"=>""
					)
				);
			}			

			
		}


		return $this->out;
	}
}