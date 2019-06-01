<?php 
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php"); 
require_once("app/functions/string2.php"); 
require_once("app/functions/request.php"); 
$l = new functions\l(); 
echo $data['headerModule']; 
echo $data['headertop']; 
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
<?php
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
      <h1><span><?=$data["pageData"]["title"]?></span></h1>
    </header>

    <main>
     <section class="container">
        <section class="row">
          <section class="col-md-6">
            <?php 
            $picture = sprintf(
              "%s%s/image/loadimage?f=%s%s&w=480&h=400",
              Config::WEBSITE,
              $_SESSION["LANG"],
              Config::WEBSITE_,
              $data["productData"]["photo"]
            );
            ?>
            <img src="<?=$picture?>" width="100%" />
          </section>

          <section class="col-md-6 desc">
            <?php 
            $realprice = 0;
            $realprice2 = 0;
            $realprice3 = 0;
            $realprice4 = 0;
            $curname = "";

            if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="gel"){
              $realprice = (int)$data["productData"]["price"];
              $realprice2 = (int)$data["productData"]["price_child"];
              $realprice3 = (int)$data["productData"]["price_child512"];
              $realprice4 = (int)$data["productData"]["price_child1220"];

              $curname = "GEL";
            }else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="usd"){
              $realprice = (int)round($data["productData"]["price"]/$_SESSION["_USD_"]);
              $realprice2 = (int)round($data["productData"]["price_child"]/$_SESSION["_USD_"]);
              $realprice3 = (int)round($data["productData"]["price_child512"]/$_SESSION["_USD_"]);
              $realprice4 = (int)round($data["productData"]["price_child1220"]/$_SESSION["_USD_"]);
              $curname = "USD";
            }else if(isset($_SESSION["currency"]) && $_SESSION["currency"]=="rub"){
              $realprice = (int)($data["productData"]["price"]/$_SESSION["_RUB_"]);
              $realprice2 = (int)($data["productData"]["price_child"]/$_SESSION["_RUB_"]);
              $realprice3 = (int)($data["productData"]["price_child512"]/$_SESSION["_RUB_"]);
              $realprice4 = (int)($data["productData"]["price_child1220"]/$_SESSION["_RUB_"]);
              $curname = "RUB";
            }
            ?>
            <form action="" method="" class="bookForm" id="bookForm">
              <input type="hidden" name="bookadult" id="bookadult" value="<?=($data["productData"]["tourist_points"]=="dynamic") ? 1 : $data["productData"]["tourist_points"]?>" />
              <input type="hidden" name="bookchild" id="bookchild" value="0" />
              <input type="hidden" name="bookpriceadult" id="bookpriceadult" value="<?=$realprice?>" />
              <input type="hidden" name="bookpricechild" id="bookpricechild" value="<?=$realprice2?>" />
              <input type="hidden" name="bookpricechild512" id="bookpricechild512" value="<?=$realprice3?>" />
              <input type="hidden" name="bookpricechild1220" id="bookpricechild1220" value="<?=$realprice4?>" />
            </form>


            <p class="data"><strong><?=strip_tags($data["productData"]["title"])?></strong></p>
            
            <section class="long-description">
              <?php 
              if($data["productData"]["tourist_points"]=="dynamic"){
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
              }else if($data["productData"]["tourist_points"]=="dynamic2"){
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
              }else if($data["productData"]["tourist_points"]=="alcohol"){
                printf(
                  "<p class=\"data\"><strong>Цена за 1 литр:</strong> %s %s</p>
                  <p class=\"data\" style=\"text-decoration:underline\">Минимальная покупка %s литров</p>",
                  $realprice,
                  $curname,
                  $data["productData"]["min_liter"]
                );
              }else if($data["productData"]["tourist_points"]=="simcard"){
                printf(
                  "<p class=\"data\"><strong>Цена за 1 штук:</strong> %s %s</p>
                  <p class=\"data\" style=\"text-decoration:underline\">Минимальная покупка %s штук</p>",
                  $realprice,
                  $curname,
                  $data["productData"]["min_liter"]
                );
              }else if($data["productData"]["tourist_points"]=="rentcar"){
                printf(
                  "<p class=\"data\"><strong>Цена за сутки:</strong> %s %s</p>
                  <p class=\"data\" style=\"text-decoration:underline\">Минимальная аренда %s сутки</p>",
                  $realprice,
                  $curname,
                  $data["productData"]["min_liter"]
                );
              }else{// no dynamic guest number
                printf(
                  "<p class=\"data\"><strong>%s</strong>: %s %s (%s %s)</p>", 
                  $l->translate("price"), 
                  $realprice,
                  $curname,
                  $l->translate("for"), 
                  $data["productData"]["tourist_points"]
                );
              }
              ?>
              <section style="clear:both"></section>
              <form action="" method="post">
                <?php $_SESSION["booktoken"] = functions\string2::random(9); ?>
                <input type="hidden" name="formtype" id="formtype" value="<?=$data["productData"]["tourist_points"]?>" />
                <input type="hidden" name="bookid" id="bookid" value="<?=functions\request::index("GET", "id")?>" />
                <input type="hidden" name="booktitle" id="booktitle" value="<?=htmlentities($data["productData"]["title"])?>" />
                <input type="hidden" name="tourist_points" id="tourist_points" value="<?=htmlentities($data["productData"]["tourist_points"])?>" />
                <input type="hidden" class="form-control" name="token" id="token" value="<?=$_SESSION["booktoken"]?>" /> 
              <label>Какова числа за вами заехать?:  <font color="#ffffff">*</font></label>
              <section class="dateBox">
                <input type="text" class="form-control date" name="date" autocomplete="off" value="<?=date("m/d/Y")?>"> 
                <section class="cal" onclick="$('.date').focus()"><i class="fa fa-calendar" aria-hidden="true"></i></section>
              </section>

              <label>В каком часу заехать за вами?: <font color="#ffffff">*</font></label>
              <select class="form-control time">
                <?php 
                for($i=8; $i<=20; $i++):
                  $num = sprintf('%02d', $i);
                ?>
                  <option value="<?=$num?>:00"><?=$num?>:00</option>
                  <?php if($num<20): ?>
                  <option value="<?=$num?>:30"><?=$num?>:30</option>
                  <?php endif;?>
                <?php
                endfor;
                ?>
              </select>

              <?php if($data["productData"]["tourist_points"]=="dynamic") { ?>
              <label>Количество взрослых?: <font color="#ffffff">*</font></label>
              <input type="number" class="form-control" name="adult" id="adult" autocomplete="off" value="1" min="1" />
              
              <label>Количество детей?:</label>
              <input type="number" class="form-control" name="child" id="child" autocomplete="off" value="0" min="0" />
             
              <?php }else if($data["productData"]["tourist_points"]=="dynamic2"){ ?>
              
              <label>Количество взрослых?:</label>
              <input type="number" class="form-control" name="dynamic2adults" id="dynamic2adults" autocomplete="off" value="0" min="0" />

              <label>Количество дети до 5 лет?:</label>
              <input type="number" class="form-control" name="dynamic2child5" id="dynamic2child5" autocomplete="off" value="0" min="0" />

              <label>Количество дети до 12 лет?:</label>
              <input type="number" class="form-control" name="dynamic2child12" id="dynamic2child12" autocomplete="off" value="0" min="0" />

              <label>Количество дети старше 12 лет?:</label>
              <input type="number" class="form-control" name="dynamic2child16" id="dynamic2child16" autocomplete="off" value="0" min="0" />

              <?php }else if($data["productData"]["tourist_points"]=="alcohol"){ ?>
              <label>Сколко литров желаете?: <font color="#ffffff">*</font></label>
              <input type="number" class="form-control" name="liter" id="liter" autocomplete="off" value="<?=$data["productData"]["min_liter"]?>" min="<?=$data["productData"]["min_liter"]?>" />
              <?php }else if($data["productData"]["tourist_points"]=="simcard"){ ?>
              <label>Сколко штук желаете?: <font color="#ffffff">*</font></label>
              <input type="number" class="form-control" name="shtuk" id="shtuk" autocomplete="off" value="<?=$data["productData"]["min_liter"]?>" min="<?=$data["productData"]["min_liter"]?>" />
               <?php }else if($data["productData"]["tourist_points"]=="rentcar"){ ?>
              <label>Сколко сутох желаете?: <font color="#ffffff">*</font></label>
              <input type="number" class="form-control" name="sutka" id="sutka" autocomplete="off" value="<?=$data["productData"]["min_liter"]?>" min="<?=$data["productData"]["min_liter"]?>" />
              <?php }else{ ?>
              <label>Количество взрослых?: <font color="#ffffff">*</font></label>
              <input type="number" class="form-control" name="adult" id="adult" autocomplete="off" value="<?=$data["productData"]["tourist_points"]?>" readonly="readonly" />
               <input type="hidden" class="form-control" name="child" id="child" autocomplete="off" value="0" min="0" readonly="readonly" />
              <?php } ?>

              <label>Ваше имя?: <font color="#ffffff">*</font></label>
              <input type="text" class="form-control" name="firstname" id="firstname" autocomplete="off" value="" />

              <label>Ваш мобильный (Viber и WhatsApp)?: <font color="#ffffff">*</font></label>
              <input type="text" class="form-control" name="mobile" id="mobile" autocomplete="off" value="" />

              <label>Ваша электронная почта?:</label>
              <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="" />

              <label>Адрес, куда подьехать?:</label>
              <textarea class="form-control" name="address" id="address"></textarea>

              <?php 
              if($data["productData"]["tourist_points"]=="dynamic"){
                printf("
                  <p class=\"data totalPrice\">
                  <strong>%s</strong>: 
                  <font color=\"#ffffff\" style=\"font-weight: bolder\">%s</font> 
                  %s
                  </p>",
                  $l->translate("totalprice"),
                  strip_tags($realprice),
                  $curname
                );
              }else if($data["productData"]["tourist_points"]=="dynamic2"){
                printf("
                  <p class=\"data totalPrice\">
                  <strong>%s</strong>: 
                  <font color=\"#ffffff\" style=\"font-weight: bolder\">%s</font> 
                  %s
                  </p>",
                  $l->translate("totalprice"),
                  0,
                  $curname
                );
              }else if($data["productData"]["tourist_points"]=="alcohol"){
                $min = ((int)$data["productData"]["min_liter"]<=0) ? 1 : (int)$data["productData"]["min_liter"];
                printf("
                  <p class=\"data totalPrice\">
                  <strong>%s</strong>: 
                  <font color=\"#ffffff\" style=\"font-weight: bolder\">%s</font> 
                  %s
                  </p>",
                  $l->translate("totalprice"),
                  strip_tags($realprice) * $min,
                  $curname
                );
              }else if($data["productData"]["tourist_points"]=="simcard"){
                $min = ((int)$data["productData"]["min_liter"]<=0) ? 1 : (int)$data["productData"]["min_liter"];
                printf("
                  <p class=\"data totalPrice\">
                  <strong>%s</strong>: 
                  <font color=\"#ffffff\" style=\"font-weight: bolder\">%s</font> 
                  %s
                  </p>",
                  $l->translate("totalprice"),
                  strip_tags($realprice) * $min,
                  $curname
                );
              }else if($data["productData"]["tourist_points"]=="rentcar"){
                $min = ((int)$data["productData"]["min_liter"]<=0) ? 1 : (int)$data["productData"]["min_liter"];
                printf("
                  <p class=\"data totalPrice\">
                  <strong>%s</strong>: 
                  <font color=\"#ffffff\" style=\"font-weight: bolder\">%s</font> 
                  %s
                  </p>",
                  $l->translate("totalprice"),
                  strip_tags($realprice) * $min,
                  $curname
                );
              }
              ?>

             
              <p>
                <a href="javascript:void(0)" class="btn btn-primary bookFinalStep" role="button">
                  <?php 
                  if($data["productData"]["tourist_points"]=="alcohol"){
                    echo "Заказать";
                  }else{
                    echo $l->translate("booknow"); 
                  }
                  ?></a> 
              </p>
            </form>
            </section>
            

          </section>
        </section>
      </section>
    </main>

<?=$data['footer']?>
<script src="<?=Config::WEBSITE?>public/js/web/bootstrap.datepicker.js"></script>
<script type="text/javascript">
$(".fixed-top").css({"position":"static"});
$(".date").datepicker();
$(document).on("keyup mouseup", "#adult", function(){
  var adult = parseInt($(this).val());
  var child = parseInt($("#child").val());
  var bookpriceadult = parseFloat($("#bookpriceadult").val());
  var bookpricechild = parseFloat($("#bookpricechild").val());

  var totalPrice = 0;
  totalPrice += adult * bookpriceadult; 
  totalPrice += child * bookpricechild; 

  $(".totalPrice font").html(totalPrice);
});

$(document).on("keyup mouseup", "#child", function(){
  var adult = parseInt($("#adult").val());
  var child = parseInt($(this).val());
  var bookpriceadult = parseFloat($("#bookpriceadult").val());
  var bookpricechild = parseFloat($("#bookpricechild").val());

  var totalPrice = 0;
  totalPrice += adult * bookpriceadult; 
  totalPrice += child * bookpricechild; 

  $(".totalPrice font").html(totalPrice);
});

$(document).on("change", "#liter", function(){
  let oneLiterPrice = parseInt($("#bookpriceadult").val());
  let liter = parseInt($(this).val());
  
  let totalPrice = 0;
  totalPrice += oneLiterPrice * liter; 

  $(".totalPrice font").html(totalPrice);
});

$(document).on("change", "#shtuk", function(){
  let price = parseFloat($("#bookpriceadult").val());
  let shtuk = parseInt($(this).val());
  
  let totalPrice = Math.round(price * shtuk); 

  $(".totalPrice font").html(totalPrice);
});

$(document).on("change", "#sutka", function(){
  let price = parseFloat($("#bookpriceadult").val());
  let sutka = parseInt($(this).val());
  
  let totalPrice = Math.round(price * sutka); 

  $(".totalPrice font").html(totalPrice);
});


function calculateDynamic2(){
  let adults = parseInt($("#dynamic2adults").val());
  let child5 = parseInt($("#dynamic2child5").val());
  let child12 = parseInt($("#dynamic2child12").val());
  let child16 = parseInt($("#dynamic2child16").val());

  let adult_price = parseInt($("#bookpriceadult").val());
  let child5_price = parseInt($("#bookpricechild").val());
  let child12_price = parseInt($("#bookpricechild512").val());
  let child16_price = parseInt($("#bookpricechild1220").val());
  
   

  let totalPrice = 0;

  totalPrice += adult_price * adults; 
  totalPrice += child5_price * child5; 
  totalPrice += child12_price * child12; 
  totalPrice += child16_price * child16; 

  $(".totalPrice font").html(totalPrice);
}
    
$(document).on("keyup mouseup", "#dynamic2adults, #dynamic2child5, #dynamic2child12, #dynamic2child16", function(){
  calculateDynamic2();
});

</script>

</body>
</html>