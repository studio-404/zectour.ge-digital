<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Admin Panel</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="<?=$data['header']['public']?>css/materialize.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data['header']['public']?>css/jquery-ui.min.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data['header']['public']?>css/manager-style.css" type="text/css" rel="stylesheet" />
	
	<link href="<?=$data["header"]["public"]?>font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

	<script src="<?=$data['header']['public']?>js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data['header']['public']?>js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data['header']['public']?>js/materialize.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data['header']['public']?>js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data['header']['public']?>js/manager-scripts.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?=$data['header']['public']?>elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['header']['public']?>elfinder/css/theme.css">
	<script src="<?=$data['header']['public']?>elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
			$('#elfinder').elfinder({
				url : '/public/elfinder/php/connector.minimal.php', 
				lang: 'ru' 
			});
		});
	</script>
</head>
<body>
<!-- MOdals START -->
	<div id="modal1" class="modal">
		<div class="modal-content">
		</div>
		<div class="modal-footer">
		</div>
	</div>
<!-- MOdals END-->
	<section class="mainContainer">

		<nav>
			<div class="nav-wrapper">
				<?=$data['nav']?>
			</div>
		</nav>

		<section class="body">
		<?php
		if(isset($data["type"]) && $data["type"]!=""){
			$pluginFile = "app/_plugins/".$data["type"]."/index.php"; 
			if(file_exists($pluginFile)){
				require_once($pluginFile);
			}
		}else{
		?>
		<table>
	        <thead>
	          <tr>
	              <th data-field="name">დასახელენა</th>
	              <th data-field="desc">მოკლე აღწერა</th>
	              <th data-field="action">მოქმედება</th>
	          </tr>
	        </thead>
	        <tbody>
			<?php 
			foreach ($data['scan'] as $value) {
				if($value=="." || $value==".."){ continue; }
				$manifest = Config::DIR."app/_plugins/".$value."/manifest404.json";
				
				if(file_exists($manifest)){
					$json_file = file_get_contents($manifest);
					$jfo = json_decode($json_file, true);
				?>
					<tr>
						<td><?=$jfo['name']?></td>
						<td><?=$jfo['desc']?></td>
						<td><a href="<?=Config::WEBSITE.$_SESSION['LANG']."/dashboard/plugins".$jfo['url']?>"><?=$jfo['urlText']?></a></td>
					</tr>
					
				<?php
				}
			}
			?> 
			</tbody>
		</table>
		<?php 
		}
		?>
		
			
		</section>

		<footer class="page-footer">
          <div class="container width-100-pr-20">
            <div class="row">
              <div class="col l6 s12">
                <h5>ადმინისტრირების პანელი</h5>
                <p class="text-lighten-4">პანელი დამზადებულია სტუდია 404-ის მიერ</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5>ბმულები</h5>
                <?=$data['footerNav']?>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container width-100-pr-20">
            <span class="black-text">© 2016 ყველა უფლება დაცულია !</span>
            <a class="black-text right" href="http://ww.404.ge" target="_blank">სტუდია 404</a>
            </div>
          </div>
        </footer>

	</section>
</body>
</html>