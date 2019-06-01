<?php 
class searchComments
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

		$id = functions\request::index("POST","id");

		$comments = new Database('comments', array(
			'method'=>'selectById', 
			'id'=>$id
		));
		$getter = $comments->getter();

		$table = '<table class="striped"><tbody>';
		if(count($getter)) {
			foreach ($getter as $val) {
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
					'დამატების თარიღი: ',
					date("d/m/Y H:i:s", $val['date'])
				);
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td>%s</td>
					</tr>",
					'IP მისამართი: ',
					$val['ip']
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
					'ორგანიზაცია: ',
					$val['organization']
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
					'კომენტარი: ',
					$val['comment']
				);

				$file = new Database("file", array(
					"method"=>"selectFilesPathById",  
					"idx"=>$val['commentId'],  
					"type"=>"module",
					"lang"=>$val['lang'] 
				));
				$get = $file->getter(); 
				$link = Config::PUBLIC_FOLDER.$get; 
				$table .= sprintf("
					<tr>
					<td><strong>%s</strong></td>
					<td><a href=\"%s\" target=\"_blank\">ნახვა</a></td>
					</tr>",
					'ფაილი: ',
					$link
				);				
			}
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