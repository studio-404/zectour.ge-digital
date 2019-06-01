<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string2.php"); 
require_once 'app/functions/request.php';
require_once 'app/functions/pagination.php';

$l = new functions\l(); 
$pagination = new functions\pagination(); 
echo $data['headerModule']; 
echo $data['headertop']; 
// $photo = (isset($data["pageData"]["photo"])) ? Config::WEBSITE_.$data["pageData"]["photo"] : "";

$db_contactnumber = new Database("modules", array(
  "method"=>"selectById", 
  "idx"=>21,
  "lang"=>$_SESSION["LANG"]
));
$contactNumber = $db_contactnumber->getter();
$MOBILE = strip_tags($contactNumber['description']);
?>
    <div class="callme">
      <div class="numbertocall">
        <p id="numbertocall"><a href="tel:<?=htmlentities($MOBILE)?>"><?=$MOBILE?></a></p>
    <p>Viber и WhatsApp</p>
      </div>
      <div class="imgicon"></div>
    </div>
    <div class="clearer"></div>
    <header class="service-header">
      <h1><span><?=(isset($data["pageData"]["title"])) ? $data["pageData"]["title"] : ""?></span></h1>
    </header>

    <main>
      <section class="container">
      	<section class="row">
        	<?=$data["tourlist"]?>
      	</section>
        <section class="clearer"></section>
		    <?=$pagination->web($data["countTours"], $data["itemPerPage"])?>
      </section>
    </main>


<?=$data['footer']?>
<script type="text/javascript">
$(".fixed-top").css({"position":"static", "background-color":"rgb(18,115,185)"});
</script>

</body>
</html>