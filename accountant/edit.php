<?php 
session_start();
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: admin.php");
	exit(); 
}

if(!isset($_SESSION["adminx"])){ 
	header("Location: admin.php");
	exit(); 
}

$json = json_decode(file_get_contents("data.json"), true);
$lang = "ge";
$noLang = "ru";
if(isset($_GET["lang"]) && $_GET["lang"]=="ru"){
	$lang = "ru";
	$noLang = "ge";
}

if(
	isset($_POST["title"]) && 
	isset($_POST["subtitle"]) && 
	isset($_POST["subtitle2"]) && 
	isset($_POST["text"]) 
){
	$array[$lang]["title"] = $_POST["title"];
	$array[$lang]["subtitle"] = $_POST["subtitle"];
	$array[$lang]["subtitle2"] = $_POST["subtitle2"];
	$array[$lang]["text"] = $_POST["text"];
	$array[$lang]["phone"] = $_POST["phone"];

	$array[$noLang]["title"] = $json[$noLang]["title"];
	$array[$noLang]["subtitle"] = $json[$noLang]["subtitle"];
	$array[$noLang]["subtitle2"] = $json[$noLang]["subtitle2"];
	$array[$noLang]["text"] = $json[$noLang]["text"];
	$array[$noLang]["phone"] = $json[$noLang]["phone"];

	$makeJson = json_encode($array);

	$fp = fopen('data.json', 'w');
	fwrite($fp, $makeJson);
	fclose($fp);
}

$json = json_decode(file_get_contents("data.json"), true);

// echo "<pre>";
// print_r($json);
// echo "</pre>";


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Administrator</title>
	<style type="text/css">
		.links{ margin: 0; padding: 0; }
		.links a{ margin: 0; padding: 0 5px; color: #555; text-decoration: none; }
		.links a:hover{ text-decoration: underline; color: red; }
		form{ margin: 25px 0 0 0; padding: 20px; width: 550px; border: solid 1px #000; }
		form label{ margin: 0; padding: 0; width: 550px; font-size: 16px; line-height: 25px; }
		form input{ margin: 0; padding: 0 5px; width: 550px; font-size: 16px; line-height: 25px; border: solid 1px #ccc; }
		form textarea{ margin: 0; padding: 0 5px; width: 550px; height: 125px; font-size: 16px; line-height: 25px; border: solid 1px #ccc; }
		form button{ margin: 20px 0px; padding: 5px 10px; border:0; background-color: #000; color: white; font-size: 16px; text-align: center;  }
	</style>
</head>
<body>
	<div class="links">
		<a href="?lang=ge" <?=($lang=="ge") ? "style='color:red'" : ""?>>ქართული</a>
		<a href="?lang=ru" <?=($lang=="ru") ? "style='color:red'" : ""?>>რუსული</a>
		<a href="?logout">გასვლა</a>
	</div>

	<form action="" method="post">
		<label>ტელეფონი</label>
		<input type="text" name="phone" value="<?=htmlentities($json[$lang]["phone"])?>" />

		<label>სათაური</label>
		<input type="text" name="title" value="<?=htmlentities($json[$lang]["title"])?>" />

		<label>ქვე სათაური</label>
		<input type="text" name="subtitle" value="<?=htmlentities($json[$lang]["subtitle"])?>" />

		<label>ქვე სათაური 2</label>
		<input type="text" name="subtitle2" value="<?=htmlentities($json[$lang]["subtitle2"])?>" />

		<label>ტექსტი</label>
		<textarea name="text"><?=htmlentities($json[$lang]["text"])?></textarea>

		<button type="submit">განახლება</button>
	</form>
</body>
</html>