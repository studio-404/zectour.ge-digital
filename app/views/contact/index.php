<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string.php"); 
$l = new functions\l(); 
echo $data['headerModule']; 
echo $data['headertop']; 

$photo = (isset($data["pageData"]["photo"])) ? Config::WEBSITE_.$data["pageData"]["photo"] : "";
?>
<div class="modal fade" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document" style="width: 340px;">
<div class="modal-content">
<div class="modal-header">
  <h4 class="modal-title theTitle" style="font-size: 22px; font-family: 'Nino';">Сообщение</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

</div>
<div class="modal-body theMessage" style="font-size: 18px; font-family: 'Nino';">
</div>
</div>
</div>
</div>

<header class="service-header">
      <h1><span><?=(isset($data["pageData"]["title"])) ? $data["pageData"]["title"] : ""?></span></h1>
    </header>

    <main class="contact-page">
      <?=$data["contactinfo"]?>

      <form action="" method="post" id="contactForm">
		<?php $_SESSION["contacttoken"] = functions\string::random(9); ?>
		<input type="hidden" id="contacttoken" name="contacttoken" value="<?=$_SESSION["contacttoken"]?>" />
        <div class="input-group">
          <label for="firstname"><?=$l->translate("firstname")?>: <font color="#bf360c">*</font></label>
          <input type="text" id="firstname" name="firstname" class="form-control" aria-label="">
        </div>
        <div class="input-group">
          <label for="email"><?=$l->translate("email")?>: <font color="#bf360c">*</font></label>
          <input type="text" id="email" name="email" class="form-control" aria-label="">
        </div>
        <div class="input-group">
          <label for="message"><?=$l->translate("message")?>: <font color="#bf360c">*</font></label>
          <textarea class="form-control" id="message" name="message"></textarea>
        </div>

        <a href="#" class="btn btn-primary sendMessage" role="button"><?=$l->translate("send")?></a> 
        <section style="clear:both"></section>
      </form>
    </main>


<?=$data['footer']?>
<script type="text/javascript">
$(".fixed-top").css({"position":"static", "background-color":"#000000"});
</script>
</body>
</html>