<!-- <a href="javascript:void(0)" onclick="" class="waves-effect waves-light btn margin-bottom-20" ><i class="material-icons left">note_add</i>დამატება</a> -->
<?php
require_once 'app/functions/url.php';
require_once 'app/functions/pagination.php';

$pagination = new functions\pagination();
//$pagination->index($counted, $itemPerPage);
$url = new functions\url();
$getUrl = explode("/", $url->getUrl());
?>

<div class="row" style="display: block;">
	
	<div class="col s3">
		<div class="collection moduleList" style="margin-top:0px;">
			<?php
			$Database = new Database("georgia", array(
				"method"=>"select",
				"cid"=>0,
				"lang"=>$_SESSION["LANG"], 
				"orderby"=>" ORDER BY `idx` ASC",
				"itemPerPage"=>15, 
				"zeroPage"=>"true"
			));

			foreach ($Database->getter() as $value) :
				$active = (isset($getUrl[4]) && $getUrl[4]==$value['idx']) ? " active" : "";
			?>
				<a href="/<?=$_SESSION["LANG"]?>/dashboard/plugins/cities/<?=$value['idx']?>" class="collection-item<?=$active?>"><?=$value['name']?></a>
			<?php
			endforeach;
			?>
		</div>
	</div>
	
	<div class="col s9">
		<a href="javascript:void(0)" onclick="add_city_Form('<?=$getUrl[4]?>', 'ge')" class="waves-effect waves-light btn margin-bottom-20"><i class="material-icons left">note_add</i>დამატება</a>
		<div style="float: right; margin: 0 0 10px 0; width: 250px;">
		<select class="language-chooser" id="language-chooser" onchange="changeLanguage('<?=$_SESSION["LANG"]?>')">
			<option value="" disabled selected>აირჩიეთ ენა</option>
			<option value="ge" <?=($_SESSION["LANG"]=="ge") ? "selected='selected'" : ""?>>ქართული</option>
			<option value="en" <?=($_SESSION["LANG"]=="en") ? "selected='selected'" : ""?>>ინგლისური</option>
			<option value="ru" <?=($_SESSION["LANG"]=="ru") ? "selected='selected'" : ""?>>რუსული</option>
		</select>
		</div>
		<div style="clear:both;"></div>
		<?php
		$cities = new Database("georgia", array(
			"method"=>"select",
			"cid"=>$getUrl[4],
			"lang"=>$_SESSION["LANG"], 
			"orderby"=>" ORDER BY `idx` ASC",
			"itemPerPage"=>10
		));
		$getter = $cities->getter();
		?>
		<table class="highlight">
			<thead>
				<tr>
					<th data-field="id" width="50">ს.კ</th>
					<th data-field="name" width="530">დასახელება</th>
					<th data-field="action">მოქმედება</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($getter as $v) :	?>
				<tr>
					<td><?=$v['idx']?></td>
					<td class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="<?=$v['name']?>"><?=$v['name']?></td>
					<td>
						<a href="javascript:void(0)"><i class="material-icons tooltipped" onclick="editCity('<?=$v['idx']?>','<?=$_SESSION['LANG']?>')" data-position="bottom" data-delay="50">mode_edit</i></a>


						<a href="javascript:void(0)"><i class="material-icons tooltipped" onclick="askRemoveCity(<?=$v['idx']?>)" data-position="bottom" data-delay="50" data-tooltip="წაშლა">delete</i></a>
					</td>
				</tr>
				<?php endforeach; ?>				
			</tbody>
		</table>
		<?php 
		if(count($getter)) : 
			$total = $getter[0]['counted']; 
			$itemPerPage = 10; 
			echo $pagination->index($total, $itemPerPage);
		endif;
		?>
	</div>


</div>