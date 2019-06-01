$chart = new Database("chart", array(
	"method"=>"select", 
	"cid"=>0,
	"type"=>"coord1"
));
$query1 = $chart->getter();

foreach ($query1 as $v) {
	?>
	<div class="ChartBox" onclick="edit_chart('<?=$v['id']?>', '<?=$_SESSION['LANG']?>')">
		<p><?=$v['title']?></p>
		<p><?=$v['text']?></p>
	</div>
	<?php
	$chart2 = new Database("chart", array(
		"method"=>"select", 
		"cid"=>$v['idx'],
		"type"=>"coord1"
	));
	$query2 = $chart2->getter();
	foreach ($query2 as $v2) {
		?>
		<div class="ChartBox" style="background-color: #dddddd" onclick="edit_chart('<?=$v2['id']?>', '<?=$_SESSION['LANG']?>')">
			<p><?=$v2['title']?></p>
			<p><?=$v2['text']?></p>
		</div>
		<?php
		$chart3 = new Database("chart", array(
			"method"=>"select", 
			"cid"=>$v2['idx'],
			"type"=>"coord1"
		));
		$query3 = $chart3->getter();

		foreach ($query3 as $v3) {
			?>
			<div class="ChartBox" style="background-color: #cccccc" onclick="edit_chart('<?=$v3['id']?>', '<?=$_SESSION['LANG']?>')">
				<p><?=$v3['title']?></p>
				<p><?=$v3['text']?></p>
			</div>
			<?php
		}

	}
}