<?php 
$lang = (isset($_GET["lang"]) && $_GET["lang"]=="ru") ? "ru" : "ge";

$json = json_decode(file_get_contents("data.json"), true);

// echo "<pre>";
// print_r($json);
// echo "</pre>";

$fontClass = "NotoSansGeorgian";
$phone = $json["ge"]["phone"];
$title = $json["ge"]["title"];
$subtitle = $json["ge"]["subtitle"];
$subtitle2 = $json["ge"]["subtitle2"];
$text = $json["ge"]["text"];

if($lang=="ru"){
	$fontClass = "NotoSansRegular";
	$phone = $json["ru"]["phone"];
	$title = $json["ru"]["title"];
	$subtitle = $json["ru"]["subtitle"];
	$subtitle2 = $json["ru"]["subtitle2"];
	$text = $json["ru"]["text"];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="<?=$title?>">
  	<meta name="keywords" content="ბუღალტრული მომსახურება,ვეძებ ბუღალტერს,საბუღალტრო მომსახურება,ბუღალტერი,ბუღალტერი ბათუმში,მთავარი ბუღალტერი,მთ ბუღალტერი,ბუხჰალტერი,Бухгалтер,требуется бухгалтер,главный бухгалтер,ищу бухгалтера,бухгалтер по совместительству,бухгалтер на дому,бухгалтерские услуги,bugalteri,buRalteri,bugalter,бухгалтер удаленно,бухгалтерия онлайн,требуется бухгалтер на дому,бухгалтерское обслуживание,бухгалтерское сопровождение,услуги бухгалтера,онлайн бухгалтерия,сайт бухгалтер,бухгалтер ищет работу,резюме бухгалтера,бухгалтер сайт,помощник бухгалтера,бухгалтерские услуги цены,интернет бухгалтерия,резюме главного бухгалтера,требуеться бухгалтер,бухгалтерские услуги сопровождение,бухгалтер на производство,бухгалтерские услуги,бухгалтерия для ооо,требуется главный бухгалтер,бухгалтерия для ип,бухгалтерия ип,бухгалтерские услуги батуми,нужен бухгалтер,бухгалтер батуми,помощь бухгалтера,главный бухгалтер батуми,резюме бухгалтер,бухгалтерское сопровождение бизнеса,бухгалтер услуги,бухгалтер в батуме
">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$title?></title>
	<link rel="stylesheet" type="text/css" href="/css/style.css?v=3" />
</head>
<body>

<div id="app">
	<div class="header">
		<div class="center">
			<div class="language">
				<ul>
					<li><a href="?lang=ge" class="NotoSansGeorgian <?=($lang=="ge") ? "active" : ""?>">ქართული</a></li>
					<li>/</li>
					<li><a href="?lang=ru" class="NotoSansRegular <?=($lang=="ru") ? "active" : ""?>">Русский</a></li>
				</ul>
			</div>
			<div class="clear"></div>
			<div class="data">
				<ul>
					<li><a href="tel:<?=str_replace(" ", "", $phone)?>" class="NotoSansRegular"><?=$phone?></a></li>
					<li><span class="NotoSansRegular">Viber & WhatsApp</span></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="clear"></div>
	<div class="title">
		<div class="center">
			<h1 class="<?=$fontClass?>"><?=$title?></h1>
			<p class="<?=$fontClass?>"><?=$subtitle?></p>
		</div>
	</div>

	<div class="clear"></div>
	<div class="subtitle">
		<div class="center">
			<span class="<?=$fontClass?>"><?=$subtitle2?></span>
		</div>
	</div>

	<div class="clear"></div>
	<div class="text">
		<div class="center <?=$fontClass?>">
			<p><?=$text?></p>
		</div>
	</div>
</div>

</body>
</html>