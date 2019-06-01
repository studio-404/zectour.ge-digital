<?php 
namespace functions;
class map
{
	public function generateMarkers($data)
	{
		$out = array();
		$out["counts"] = 0;
		$out["markers"] = "";
		if(!empty($data))
		{
			$explode = explode(",", $data); 
			$out["counts"] = count($explode);
			$i = 1;
			foreach ($explode as $value) {
				$expl = explode(":", $value);
				if(empty($expl[0]) || empty($expl[1])){
					continue;
				}
				$out["markers"] .= "var xmarker".$i." = new google.maps.Marker({ \n";
		        $out["markers"] .= "map: map, \n";
		        $out["markers"] .= "draggable: true, \n";
		        $out["markers"] .= sprintf(
		        	"icon: '/public/img/marker.png', \n",
		        	$i
		        );
		        $out["markers"] .= sprintf(
		        	"position: {lat: %s, lng: %s} \n",
		        	$expl[0],
		        	$expl[1]
		        );
		        $out["markers"] .= "}); \n";
		        
		        $out["markers"] .= sprintf("xmarker%d.metadata = {type: \"point\", id: %d}; \n", $i, $i );
				$out["markers"] .= sprintf(
					'var input = "<input type=\"hidden\" class=\"coords\" id=\"i%s\" value=\"%s:%s\" />"; ',
					$i,
					$expl[0],
		        	$expl[1]
				);
      			$out["markers"] .= '$("#mapCords").append(input); ';

      			$out["markers"] .= "google.maps.event.addListener(xmarker".$i.", \"dragend\", function (e) { \n";
				$out["markers"] .= "var lat = xmarker".$i.".getPosition().lat(); \n";
				$out["markers"] .= "var lng = xmarker".$i.".getPosition().lng(); \n";
				$out["markers"] .= "$(\"#mapCords #i\"+xmarker".$i.".metadata.id).val(lat + \":\" + lng); \n";
				$out["markers"] .= "setMessageToParent(); \n";
				$out["markers"] .= "}); \n\n";
      			
      			$out["markers"] .= "google.maps.event.addListener(xmarker".$i.", \"click\", function (e) { \n";
				$out["markers"] .= "$(\"#mapCords #i\"+xmarker".$i.".metadata.id).remove(); \n";
				$out["markers"] .= "xmarker".$i.".setMap(null); \n";
				$out["markers"] .= "setMessageToParent(); \n";
				$out["markers"] .= "}); \n\n";

				$i++;
			}
			
		}

		return $out;
	}
}