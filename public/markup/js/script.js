$(document).ready(function(){
	var svg1 = document.getElementById("svg1");
    svg1.addEventListener("load",function(){
		var svgDoc = svg1.contentDocument;
		var container = svgDoc.getElementById("container");
		container.addEventListener("mousedown",function(){
			location.href = "/";
		}, false);
  	});

});