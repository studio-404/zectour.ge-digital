<?php
require_once("app/functions/l.php"); 
require_once("app/functions/strip_output.php");
$l = new functions\l();
echo $data['headerModule']; 
echo $data['headertop']; 
?>
<main>
	<section class="centerWidth">
		<section class="row">
			<section class="col s12 m6 l8">
				<section class="headerText">
					<div class="line"></div>
					<div class="title"><?=strip_tags($data['pageData']['description'])?></div>
				</section>
				<section class="event">
					<?=$data['mainnews']?>
					<?php
					if(isset($data['othernews'])):
					?>
					<section class="marginminus10 marginTop40">
						<section class="col s12 m12 l12">
							<section class="headerText">
								<div class="line"></div>
								<div class="title"><?=$l->translate('allnews')?></div>
							</section>
						</section>
						<?=$data['othernews']?>
					</section>
					<?php
					endif;
					?>
				</section>
			</section>
			<section class="col s12 m6 l4 rightSide">
				<section class="justTitle"><?=$l->translate('eventcalendar')?></section>
				<section class="CalendarBox">
					<?php
					require_once('app/functions/calendar.php'); 
					$calendar = new functions\calendar();
					echo $calendar->index($_SESSION['LANG']); 
					?>
				</section>

				<section class="justTitle marginTop40"><?=$l->translate('publications')?></section>
				<section class="files" style="margin: 10px 0px; width: 100%">
					<section class="col s12 m12 l12 reports">
						<?=$data['publications']?>
					</section>
				</section>
			</section>

		</section>	
	</section>
</main>


<?=$data['footer']?>

<script type="text/javascript">  
	var scroll = true;
	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
	       if(scroll){
	       		scroll = false;
	       		var newsitem = parseInt($("#counterVals").val());
	       		var item = "";
	       		var ajaxFile = "/loadmorenews";
	       		$(".loadergif").fadeIn();
	       		$.ajax({
					method: "POST",
					url: Config.ajax + ajaxFile,
					data: { itemsnums: newsitem }
				}).done(function( msg ) {
					var obj = $.parseJSON(msg);
					if(obj.Error.Code==1){
						console.log(obj.Error.Text);
					}else if(obj.Success.Code==1){
						var news = obj.Success.news;
						if(news.length){
							for(var i = 0; i<news.length; i++){
								var title = news[i].title;
								var titleUrl = title.replace(" ", "-");
								var theUrl = "<?=Config::WEBSITE.strip_output::index($_SESSION['LANG'])?>/news/"+news[i].idx+"/"+titleUrl;
								var image ="<?=Config::WEBSITE.strip_output::index($_SESSION['LANG'])?>/image/loadimage?f=<?=Config::WEBSITE_?>"+news[i].photo+"&w=383&h=235";

								item += '<section class="col s12 m12 l6 news-item">';
					       		item += '<section class="newsBox">';
					       		item += '<a href="' + theUrl + '">';
					       		item += '<section class="imageBox">';
					       		item += '<img src="' + image + '" width="100%" alt="">';
					       		item += '</section>';
					       		item += '<section class="data">';
					       		item += '<p><?=$l->translate('singlenews')?></p>';
					       		item += '<p>'+timeConverter(news[i].date,'<?=strip_output::index($_SESSION['LANG'])?>')+'</p>';
					       		item += '</section>';
					       		item += '<section class="title">' + title.substring(0, 100) + '</section>';
					       		item += '<section class="text">' + news[i].description.substring(0, 160) + '</section>';
					       		item += '</a>';
					       		item += '</section></section>';
						       	if(((i+1)%2) == 0){
									item += "<div style=\"clear:both\"></div>";
								}
							}
						}
						$("#counterVals").val(newsitem + 4);
						$(".othernews-box").append(item);
					}
					scroll = true;
					$(".loadergif").fadeOut();
				});         		
	       }
	   }
	});
	if($(document).width()<1200){
		var rightSide = $(".rightSide").html();
		$(".rightSide").hide();
		$(".mainText").append(rightSide);
		$(".file .title").css("text-align","left");
	}
</script>

</body>
</html>