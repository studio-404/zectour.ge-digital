<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Admin Panel</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="<?=$data["header"]["public"]?>css/materialize.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data["header"]["public"]?>css/jquery-ui.min.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data["header"]["public"]?>css/manager-style.css" type="text/css" rel="stylesheet" />
	
	<link href="<?=$data["header"]["public"]?>/css/web/font-awesome.css" type="text/css" rel="stylesheet" />

	<script src="<?=$data["header"]["public"]?>js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script> 
	<!--<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>-->

	<script src="<?=$data["header"]["public"]?>js/materialize.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/manager-scripts.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" type="text/css" href="<?=$data['header']['public']?>elfinder/css/elfinder.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$data['header']['public']?>elfinder/css/theme.css">
	<script src="<?=$data['header']['public']?>elfinder/js/elfinder.min.js"></script>
</head>
<body>
<!-- MOdals START -->
	<div id="modal1" class="materialize modal">
		<div class="modal-content">
		</div>
		<div class="modal-footer">
		</div>
	</div>
<!-- MOdals END-->
	<section class="materialize mainContainer">

		<nav>
			<div class="nav-wrapper">
				<?=$data['nav']?>
			</div>
		</nav>

		<section class="body">

			<div class="row" style="display: block;">
				<div class="col s12">
					<?php
					$catalogId = (isset($data['parsed_url'][3])) ? $data['parsed_url'][3] : 0;
					?>
					<a href="javascript:void(0)" onclick="add_catalog('<?=$catalogId?>', '<?=$_SESSION['LANG']?>')" class="waves-effect waves-light btn margin-bottom-20" ><i class="material-icons left">note_add</i>დამატება</a>

					<div style="float: right; margin: 0 0 10px 0; width: 250px;">
					<select class="language-chooser" id="language-chooser" onchange="changeLanguage('<?=$_SESSION["LANG"]?>')">
						<option value="" disabled selected>აირჩიეთ ენა</option>
						<option value="fr" <?=($_SESSION["LANG"]=="fr") ? "selected='selected'" : ""?>>ფრანგული</option>
						<option value="en" <?=($_SESSION["LANG"]=="en") ? "selected='selected'" : ""?>>ინგლისური</option>
						<option value="ru" <?=($_SESSION["LANG"]=="ru") ? "selected='selected'" : ""?>>რუსული</option>
					</select>
					</div>

					<table class="highlight">
						<thead>
							<tr>
								<th data-field="id" width="50">ს.კ</th>
								<th data-field="title" width="530">დასახელება</th>
								<th data-field="action">მოქმედება</th>
							</tr>
						</thead>

						<tbody>
							<?=$data['theProducts']?>					
						</tbody>
					</table>
					<?php 
					if(count($data['products'])) : 
							$total = $data['products'][0]['counted']; 
							$itemPerPage = $data['itemPerPage']; 
							$pagination = $data['pagination'];
							echo $pagination->index($total, $itemPerPage);
					endif;
					?>					
				</div>
			</div>


			
			
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