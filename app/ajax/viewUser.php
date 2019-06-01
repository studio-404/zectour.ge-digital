<?php 
class viewUser
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
		require_once 'app/functions/request.php';

		$this->out = array(
			"Error" => array(
				"Code"=>1, 
				"Text"=>"მოხდა შეცდომა !",
				"Details"=>"!"
			)
		);

		$email = functions\request::index("POST","email");

		$user = new Database('user', array(
			'method'=>'select', 
			'email'=>$email
		));
		$getter = $user->getter();

		// echo "<pre>";
		// print_r($getter);
		// echo "</pre>";

		$table = '<table class="striped"><tbody>';
		if(count($getter)) {
			$val = $getter;
			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'ს.კ.: ',
				$val['id']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'რეგისტრაციის თარიღი: (დ/თ/წ)',
				date("d/m/Y H:i:s", $val['register_date'])
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'IP მისამართი: ',
				$val['register_ip']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'ელ-ფოსტა: ',
				$val['email']
			);
			
			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'სახელი: ',
				$val['firstname']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'გვარი: ',
				$val['lastname']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'დაბადების თარიღი: (დ/თ/წ)',
				date("d/m/Y", (int)strtotime($val['dob']))
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'სქესი: ',
				($val['gender']==1) ? "მამრობითი" : "მდედრობითი" 
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'ქვეყანა: ',
				$val['country']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'ქალაქი: ',
				$val['city']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'საკ. ნომერი: ',
				$val['phone']
			);

			$table .= sprintf("
				<tr>
				<td><strong>%s</strong></td>
				<td>%s</td>
				</tr>",
				'საფოსტო კოდი: ',
				$val['postcode']
			);

		}else{
			$table .= sprintf("
					<tr>
					<td colspan=\"2\">%s</td>
					</tr>",
					'მონაცემი ვერ მოიძებნა !'
			);
		}
		$table .= '</table></tbody>';

		$this->out = array(
			"Error" => array(
				"Code"=>0, 
				"Text"=>"ოპერაცია შესრულდა წარმატებით !",
				"Details"=>""
			),
			"table" => $table
		);	

		return $this->out;
	}
}