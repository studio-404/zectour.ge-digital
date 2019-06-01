<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string2.php"); 
require_once 'app/functions/request.php';
require_once 'app/functions/pagination.php';
require_once 'app/functions/youtube.php';

$l = new functions\l(); 
$pagination = new functions\pagination(); 
$youtube = new functions\youtube(); 
echo $data['headerModule']; 
echo $data['headertop']; 
?>

<header class="service-header">
      <h1><span><?=(isset($data["pageData"]["title"])) ? $data["pageData"]["title"] : ""?></span></h1>
    </header>

    <main>
      <section class="container">
      	 <secrion class="row">
            <?php 
            $youtubex = false;
            if(!empty($youtube->index($data["pageData"]["description"]))): 
            $youtubex = true;
            ?>
            <section class="col-lg-6 col-lg-push-6">
                <?php  
                echo $youtube->index($data["pageData"]["description"]);
                ?>
            </section>
            <?php endif; ?>
            
            <section class="col-lg-<?=($youtubex) ? "6" : "12"?> col-lg-pull-6" style="font-size: 22px;     color: white;">
               <?=$data["pageData"]["text"]?>
            </section>
         </section>
      </section>
    </main>


<?=$data['footer']?>
<script type="text/javascript">
$(".fixed-top").css({"position":"static"});
</script>

</body>
</html>