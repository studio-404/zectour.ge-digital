<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
$l = new functions\l(); 
echo $data['headerModule']; 
echo $data['headertop']; 


?>

 <header>
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php
          if($data["slider"]["count"]>0){
             for ($x=0; $x<$data["slider"]["count"]; $x++) {
                $act = ($x==0) ? " class='active'" : "";
                printf(
                   "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"%d\"%s></li>\n",
                   $x,
                   $act
                );
             }
          }
          ?>
        </ol>

        <div class="carousel-inner" role="listbox">
          <?=$data["slider"]["list"]?>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </header>



<?=$data['footer']?>
<script>
  $('.carousel').carousel({
    interval: 2500,
    pause: false,
    ride: false
  })
  // setTimeout(function(){
  //   $('.carousel-control-next').click();
  // }, 3000);
  $(".navbar").css({"width":"100%", "margin-left":"0px"});
</script>

</body>
</html>