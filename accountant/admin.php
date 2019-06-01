<?php 
session_start();
$message = "";
// echo @$_POST["username"]." _ ".@$_POST["password"];
if(isset($_POST["token"]) && $_SESSION["token"]==$_POST["token"]){
	if(
		isset($_POST["username"]) && 
		isset($_POST["password"]) && 
		$_POST["username"]=="admin" && 
		$_POST["password"]=="bugalteri" 
	){
		$_SESSION["adminx"] = "we are in";
		header("Location: http://accountant.zectour.ge/edit.php");
		exit();
	}else{
		$message = "მომხმარებლის სახელი ან პაროლი არასწორია!";
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Administrator</title>
	<style type="text/css">
		form{ margin: 25px 0 0 0; padding: 20px; width: 550px; border: solid 1px #000; }
		form label{ margin: 0; padding: 0; width: 550px; font-size: 16px; line-height: 25px; }
		form input{ margin: 0; padding: 0 5px; width: 550px; font-size: 16px; line-height: 25px; border: solid 1px #ccc; }
		form button{ margin: 20px 0px; padding: 5px 10px; border:0; background-color: #000; color: white; font-size: 16px; text-align: center;  }
	</style>
</head>
<body>
<form action="" method="post">
	<strong><?=$message?></strong><br>
	<?php $_SESSION["token"] = md5(sha1(time())); ?>
	<input type="hidden" name="token" value="<?=$_SESSION["token"]?>" />

	<label>მომხმარებლის სახელი</label>
	<input type="text" name="username" value="" />

	<label>პაროლი</label>
	<input type="password" name="password" value="" />

	<button type="submit">შესვლა</button>
</form>
</body>
</html>