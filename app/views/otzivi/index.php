<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string2.php"); 
require_once 'app/functions/request.php';

$l = new functions\l(); 
echo $data['headerModule']; 
echo $data['headertop']; 
?>

<header class="service-header">
      <h1><span><?=(isset($data["pageData"]["title"])) ? $data["pageData"]["title"] : ""?></span></h1>
    </header>

    <main>
      <section class="container">
      	 	<section class="form">
      	 		<form action="<?=Config::WEBSITE . $_SESSION["LANG"]?>/otzivi" method="post" enctype="multipart/form-data">
      	 			<?php $_SESSION["csrf-token"] = base64_encode(sha1(md5(time()))); ?>
      	 			<input type="hidden" name="csrf-token" value="<?=$_SESSION["csrf-token"]?>">
      	 			<div class="msg"><?=$data["message"]?></div>
	      	 		<label>Ваше имя: </label>
	      	 		<div class="input-group">
					  	<input type="text" class="form-control" name="imia"  />
					</div>

					<label>Фотография на память: </label>
					<div class="input-group fileUpload">
					  	<input type="file" class="form-control" name="foto" accept="image/*" />
					</div>					

					<label>Отзыв:</label>
					<textarea name="otziv"></textarea>

					<button type="submit">Отправить</button>				
				</form>
      	 	</section>	


         	<?=$data["otzivi"]?>
      </section>
    </main>


<?=$data['footer']?>
<script type="text/javascript">
$(".fixed-top").css({"position":"static", "background-color":"rgb(18,115,185)"});
</script>


</body>
</html>