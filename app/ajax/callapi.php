<?php 
class callapi
{
	public $out;

	public function index()
	{
		require_once 'app/core/Config.php';
		require_once 'app/functions/request.php';

		$user = functions\request::index("POST","user");
		$pass = functions\request::index("POST","pass");

		if(empty($user) || empty($pass)){
			$this->out = array(
				"Error" => array(
					"Code"=>1, 
					"Text"=>"ყველა ველი სავალდებულოა",
					"Details"=>""
				),
				"Success"=>array(
					"Code"=>0, 
					"Text"=>"ოპერაცია შესრულდა წარმატებით !",
					"Details"=>""
				)
			);
		}else{
			$Database = new Database('statements', array(
					'method'=>'checkUser', 
					'user'=>$user, 
					'pass'=>$pass 
			));
			$output = $Database->getter();
			if($output)
			{
				$_SESSION['capex_user'] = $user;
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
						"Text"=>"მომხმარებლის სახელი ან პაროლი არასწორია !",
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


		return $this->out;
	}
}