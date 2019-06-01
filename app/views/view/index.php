<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string2.php"); 
require_once 'app/functions/request.php';
require_once 'app/functions/selectedDestinations.php';

$l = new functions\l(); 
echo $data['headerModule']; 
echo $data['headertop']; 
$photo = (isset($data["pageData"]["photo"])) ? Config::WEBSITE_.$data["pageData"]["photo"] : "";

$db_contactnumber = new Database("modules", array(
  "method"=>"selectById", 
  "idx"=>21,
  "lang"=>$_SESSION["LANG"]
));
$contactNumber = $db_contactnumber->getter();
$MOBILE = strip_tags($contactNumber['description']);

?>
<div class="callme mobileversion">
  <div class="numbertocall">
    <p id="numbertocall"><a href="tel:<?=htmlentities($MOBILE)?>"><?=$MOBILE?></a></p>
    <p>Viber и WhatsApp</p>
  </div>
  <div class="imgicon"></div>
</div>
<div class="clearer"></div>
<header class="service-header">
      <h1><span><?=$data["productGetter"]["title"]?> - #<?=$data["productGetter"]["idx"]?></span></h1>
    </header>

    <main>
      <section class="container">
        <section class="row">
          <section class="col-md-6">
            
           
           <section class="slider">
            <div class="flexslider">
              <ul class="slides">
              	<?php 
        				$x = 1;
        		  		foreach ($data["photos"] as $photo):
        		  			$active = ($x==1) ? "active" : "";
        			  		$picture = sprintf(
        			  			"%s%s/image/loadimage?f=%s%s&w=480&h=400",
        			  			Config::WEBSITE,
        			  			$_SESSION["LANG"],
        			  			Config::WEBSITE_,
        			  			$photo["path"]
        			  		);
        		  		?>
        	                <li data-thumb="<?=$picture?>" class="<?=$active?>">
        	                  <img src="<?=$picture?>" alt="<?=htmlentities($data["productGetter"]["title"])?>" />
        	                </li>
                       <?php 
        				$x=2;
        				endforeach;
        				?>
              </ul>
            </div>
          </section>
          <?php
          if(
            isset($data["productGetter"]["location"]) && 
            $data["productGetter"]["location"]!="" && 
            $data["productGetter"]["tourist_points"]!="alcohol"
          ):
          $locations = explode(",", $data["productGetter"]["location"]);
          if(is_array($locations)):
          ?>
          <section class="google-map" id="google-map"></section>
          <script type="text/javascript">
          var map;
          function initMap() {
            var mapOptions = {
              zoom: 6,
            };
            map = new google.maps.Map(document.getElementById('google-map'), mapOptions);

            var locations = [
              <?php foreach($locations as $location) : $loc = explode(":", $location); ?>
              ['', <?=$loc[0]?>,<?=$loc[1]?>, '<?=Config::PUBLIC_FOLDER?>img/marker.png'],
              <?php endforeach; ?>
            ];
            var bounds = new google.maps.LatLngBounds();
            var marker, i;

              for (i = 0; i < locations.length; i++) {  
                marker = new google.maps.Marker({
                  position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                  map: map,
                  animation: google.maps.Animation.DROP,
                  title: locations[i][0],
                  icon: locations[i][3]
                });

                bounds.extend(marker.position);
              }
              map.fitBounds(bounds);

              setTimeout(function(){
                map.setZoom(6);

                var mapx = map.getDiv();
                if($(window).width()<1024)
                {
                  $("#google-map").remove();
                  $("#google-map2").append(mapx);
                }
              }, 1000);


          }
          </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=Config::GOOGLE_MAP_KEY?>&amp;callback=initMap" type="text/javascript"></script>
          <?php endif; ?>
          <?php endif; ?>


          </section>

          <section class="col-md-6 desc">
          	 
            <?php 
            $realprice = 0;
            $curname = "";

            if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="gel"){
              $realprice = (int)$data["productGetter"]["price"];
              $realprice2 = (int)$data["productGetter"]["price_child"];
              $realprice3 = (int)$data["productGetter"]["price_child512"];
              $realprice4 = (int)$data["productGetter"]["price_child1220"];
              $curname = "GEL";
            }else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
              $realprice = (int)round($data["productGetter"]["price"]/$_SESSION["_USD_"]);
              $realprice2 = (int)round($data["productGetter"]["price_child"]/$_SESSION["_USD_"]);
              $realprice3 = (int)round($data["productGetter"]["price_child512"]/$_SESSION["_USD_"]);
              $realprice4 = (int)round($data["productGetter"]["price_child1220"]/$_SESSION["_USD_"]);
              $realpriceChild = (int)round($data["productGetter"]["price_child"]/$_SESSION["_USD_"]);
              $curname = "USD";
            }else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="rub"){
              $realprice = (int)round($data["productGetter"]["price"]/$_SESSION["_RUB_"]);
              $realprice2 = (int)round($data["productGetter"]["price_child"]/$_SESSION["_RUB_"]);
              $realprice3 = (int)round($data["productGetter"]["price_child512"]/$_SESSION["_RUB_"]);
              $realprice4 = (int)round($data["productGetter"]["price_child1220"]/$_SESSION["_RUB_"]);
              
              $curname = "RUB";
            }



            if($data["productGetter"]["tourist_points"]=="dynamic"){
              printf(
                "<p class=\"data\"><strong>%s (%s)</strong>: %s %s</p>", 
                $l->translate("price"), 
                $l->translate("adults"),
                $realprice,
                $curname              
              );

              printf(
                "<p class=\"data\"><strong>%s (%s)</strong>: %s %s</p>", 
                $l->translate("price"), 
                $l->translate("children"),
                $realprice2,
                $curname
              );
            }else if($data["productGetter"]["tourist_points"]=="dynamic2"){
                printf(
                  "
                  <p class=\"data\">Взрослые: %s %s</p>
                  <p class=\"data\">Дети до 5 лет: %s %s</p>
                  <p class=\"data\">Дети до 12 лет: %s %s</p>
                  <p class=\"data\">Дети старше 12 лет: %s %s</p>
                  ",
                  $realprice,
                  $curname,
                  $realprice2,
                  $curname,
                  $realprice3,
                  $curname,
                  $realprice4,
                  $curname
                );
            }else if($data["productGetter"]["tourist_points"]=="simcard"){
                printf(
                  "<p class=\"data\"><strong>Цена за 1 штук:</strong> %s %s</p>
                  <p class=\"data\">Минимальная покупка %s штук</p>",
                  $realprice,
                  $curname,
                  $data["productGetter"]["min_liter"]
                ); 
            }else if($data["productGetter"]["tourist_points"]=="rentcar"){
                printf(
                  "<p class=\"data\"><strong>Цена за сутки:</strong> %s %s</p>
                  <p class=\"data\">Минимальная аренда %s сутки</p>",
                  $realprice,
                  $curname,
                  $data["productGetter"]["min_liter"]
                ); 
            }else if($data["productGetter"]["tourist_points"]=="alcohol"){
              printf(
                "<p class=\"data\"><strong>Цена за 1 литр:</strong> %s %s</p>
                <p class=\"data\">Минимальная покупка %s литров</p>",
                $realprice,
                $curname,
                $data["productGetter"]["min_liter"]
              ); 
            }else{
              printf(
                "<p class=\"data\"><strong>%s</strong>: %s %s (%s %s)</p>", 
                $l->translate("price"), 
                $realprice,
                $curname,
                $l->translate("for"), 
                $data["productGetter"]["tourist_points"]
              );
            }
            ?>
            
            <p>
            	<?php $_SESSION["token"] = functions\string2::random(9); ?>
              <a href="<?=Config::WEBSITE.$_SESSION["LANG"]?>/book/?id=<?=$data["productGetter"]["idx"]?>&amp;token=<?=$_SESSION["token"]?>" class="btn btn-primary" role="button"><?=($data["productGetter"]["tourist_points"]=="alcohol") ? "Заказать" : $l->translate("booking")?></a> 
            </p>
            <section class="long-description">
             <?=strip_tags($data["productGetter"]["description"], "<p><strong><ul><li><a>")?>
            </section>
            <div class="clearer"></div>
            <div class="callme2 showonmobile">
              <div class="numbertocall">
                <p id="numbertocall2"><a href="tel:<?=htmlentities($MOBILE)?>" style="color: white"><?=$MOBILE?></a></p>
                <p style="color: white">Viber и WhatsApp</p>
              </div>
              <div class="imgicon"></div>
            </div>
            <div class="clearer"></div>

            <section class="google-map2" id="google-map2"></section>
          </section>
        </section>
      </section>
    </main>



<?=$data['footer']?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/jquery.flexslider-min.js"></script>
<script type="text/javascript">
$(".fixed-top").css({"position":"static"});
$('.flexslider').flexslider({
	animation: "slide",
  slideshowSpeed: 2000,
  animationSpeed: 1500, 
	controlNav: "thumbnails",
	start: function(slider){
	$('body').removeClass('loading');
}
});
</script>

</body>
</html>