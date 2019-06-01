<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Admin Panel</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="<?=$data["header"]["public"]?>css/materialize.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data["header"]["public"]?>css/jquery-ui.min.css" type="text/css" rel="stylesheet" />
	<link href="<?=$data["header"]["public"]?>css/manager-style.css" type="text/css" rel="stylesheet" />
	<script src="<?=$data["header"]["public"]?>js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/materialize.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?=$data["header"]["public"]?>js/manager-scripts.js?time=<?=time()?>" type="text/javascript" charset="utf-8"></script>
</head> 
<body>

<section class="materialize sign-in-box">
	<form class="col s12">
			<input type="hidden" name="lang" id="lang" class="lang" value="<?=$_SESSION["LANG"]?>" />
			<h5>სისტემაში შესვლა</h5>
			 <blockquote class="error-msg hide-me">
		      მოხდა შეცდომა მომხმარებელი აღნიშნული სახელით და პაროლით არ არსებობს !
		    </blockquote>
			<div class="input-field">
				<input id="username" type="text" autocomplete="off" />
				<label for="username">მომხმარებლის სახელი</label>
			</div>

			<div class="input-field">
				<input id="password" type="password" autocomplete="off" />
				<label for="password">პაროლი</label>
			</div>

			<div class="login-button">
				<a class="waves-effect waves-light btn-large" href="javascript:void(0)" onclick="sign_in_try()">შესვლა</a>
			</div>

		</form>
</section>

</body>
</html>