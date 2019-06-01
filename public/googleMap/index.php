<?php 
session_start();
if(@$_SESSION["token"]!=@$_GET["token"]){
	exit();
}
require_once("../../app/core/Config.php"); 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Marker Animations</title>
    <script src="/public/js/jquery-3.1.1.min.js" type="text/javascript" charset="utf-8"></script> 
    <style>
    p{ margin:0; padding:10px; height: 30px; line-height: 30px; }
    p a{ line-height: 30px; font-size: 16px; color: black; text-decoration: underline; }
      #map {
        height: 350px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
  	<form action="javascript:void(0)" method="post" id="mapCords">
  		
  	</form>
  	<p><a href="javascript:void(0)" onclick="addNewMarker()" class="waves-effect waves-light btn">პინის დამატება</a></p>
    <div id="map"></div>
    <script>
		var marker;
		var marker2;
		var map;
		var counts = 1;

		function initMap() {
			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 13,
				center: {lat: 41.70487171965874, lng: 44.89561328125001}
			});
      	}     
      

      function addNewMarker(){
      	var input = "<input type=\"hidden\" class=\"coords\" id=\"i"+counts+"\" value=\"41.70487171965874:44.89561328125001\" />";
      	$("#mapCords").append(input);

		var xmarker = new google.maps.Marker({
			map: map,
			draggable: true,
			icon: '/public/img/marker.png',
			position: {lat: 41.70487171965874, lng: 44.89561328125001}
        });

        xmarker.metadata = {type: "point", id: counts};

        setMessageToParent();

        // on drag sent info to parent
        google.maps.event.addListener(xmarker, 'dragend', function(e) { 
	      	var lat = xmarker.getPosition().lat();
			var lng = xmarker.getPosition().lng();
 			
			$("#mapCords #i"+xmarker.metadata.id).val(lat + ":" + lng);

			setMessageToParent();
		});

		google.maps.event.addListener(xmarker, "click", function (e) { 
            
            $("#mapCords #i"+xmarker.metadata.id).remove();
            xmarker.setMap(null);
            setMessageToParent();
        });
		counts++;
      }

      function setMessageToParent()
      {
      	var msg = "";
		$("#mapCords .coords").each(function(){
			msg += $(this).val() + ",";
		});

		window.top.postMessage(msg.replace(/(^,)|(,$)/g, ""), '*');
      }
      
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=Config::GOOGLE_MAP_KEY?>&amp;callback=initMap">
    </script>
  </body>
</html>