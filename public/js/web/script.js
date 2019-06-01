var Config = {
	website: "https://zectour.ge/",
	ajax: "https://zectour.ge/ru/ajax/index",
	mainLang: "ru",
	mainClass: "home"
};

$(document).ready(function(){
	if($(window).width()<1024){
		$(".pull-mobile").insertBefore(".push-mobile");
	}else{
		$(".push-mobile").insertBefore(".pull-mobile");
	}
});

$(document).on("click", ".bookFinalStep", function(){
	var bookid = (typeof $("#bookid").val() !== "undefined") ? $("#bookid").val() : 0;
	var formtype = (typeof $("#formtype").val() !== "undefined") ? $("#formtype").val() : 0;
	var booktitle = (typeof $("#booktitle").val() !== "undefined") ? $("#booktitle").val() : 0;
	var tourist_points = (typeof $("#tourist_points").val() !== "undefined") ? $("#tourist_points").val() : 0;
	var token = (typeof $("#token").val() !== "undefined") ? $("#token").val() : 0;
	var date = (typeof $(".date").val() !== "undefined") ? $(".date").val() : 0;
	var time = (typeof $(".time").val() !== "undefined") ? $(".time").val() : 0;
	var adult = (typeof $("#adult").val() !== "undefined") ? $("#adult").val() : 0;
	var child = (typeof $("#child").val() !== "undefined") ? $("#child").val() : 0;
	
	var dynamic2adults = (typeof $("#dynamic2adults").val() !== "undefined") ? $("#dynamic2adults").val() : 0;
	var dynamic2child5 = (typeof $("#dynamic2child5").val() !== "undefined") ? $("#dynamic2child5").val() : 0;
	var dynamic2child12 = (typeof $("#dynamic2child12").val() !== "undefined") ? $("#dynamic2child12").val() : 0;
	var dynamic2child16 = (typeof $("#dynamic2child16").val() !== "undefined") ? $("#dynamic2child16").val() : 0;


	var firstname = (typeof $("#firstname").val() !== "undefined") ? $("#firstname").val() : 0;
	var mobile = (typeof $("#mobile").val() !== "undefined") ? $("#mobile").val() : 0;
	var email = (typeof $("#email").val() !== "undefined") ? $("#email").val() : 0;
	var address = (typeof $("#address").val() !== "undefined") ? $("#address").val() : 0;
	var liter = (typeof $("#liter").val() !== "undefined") ? $("#liter").val() : 0;
	var shtuk = (typeof $("#shtuk").val() !== "undefined") ? $("#shtuk").val() : 0;
	var sutka = (typeof $("#sutka").val() !== "undefined") ? $("#sutka").val() : 0;
	var tp = parseInt($(".totalPrice font").html());

	var ajaxFile = "/bookFinalStep";
	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { 
			formtype:formtype, 
			bookid:bookid, 
			booktitle:booktitle, 
			tourist_points:tourist_points, 
			date:date, 
			time:time, 
			adult:adult, 
			child:child, 
			dynamic2adults:dynamic2adults, 
			dynamic2child5:dynamic2child5, 
			dynamic2child12:dynamic2child12, 
			dynamic2child16:dynamic2child16, 
			firstname:firstname, 
			mobile:mobile, 
			email:email, 
			address:address, 
			liter:liter, 
			shtuk:shtuk, 
			sutka:sutka, 
			tp:tp, 
			token:token 
		}
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			setTimeout(function(){
				location.href = "/";
			}, 3500);
			var text = obj.Success.Text;
		}else{
			var text = obj.Error.Text;
		}

		$(".theMessage").html(text);
		$(".modal").modal("show");	
	});
});

$(document).on("click", ".sendMessage", function(){
	var contacttoken = $("#contacttoken").val();
	var firstname = $("#firstname").val();
	var email = $("#email").val();
	var message = $("#message").val();

	var ajaxFile = "/sendmessage";
	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { contacttoken:contacttoken, firstname:firstname, email:email, message:message }
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Success.Code==1){
			setTimeout(function(){
				location.reload();
			}, 2500);
			var text = obj.Success.Text;
		}else{
			var text = obj.Error.Text;
		}

		$(".theMessage").html(text);
		$(".modal").modal("show");	
	});
});

$('.date').on('changeDate', function(ev){
    $(this).datepicker('hide');
});

function selectText(containerid) {
    if (document.selection) { // IE
        var range = document.body.createTextRange();
        range.moveToElementText(document.getElementById(containerid));
        range.select();
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(document.getElementById(containerid));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
    }
}

$(document).on('click', '.callme', function(){
	selectText('numbertocall');
});

$(document).on('click', '.callme2', function(){
	selectText('numbertocall2');
});

$(document).on("click", ".g-currency-box p a", function(){
	var cur = $(this).attr("data-cur");
	var ajaxFile = "/changeCurrency";
	$.ajax({
		method: "POST",
		url: Config.ajax + ajaxFile,
		data: { 
			cur: cur
		}
	}).done(function( msg ) {
		var obj = $.parseJSON(msg);
		if(obj.Error.Code==1){
			console.log(obj.Error.Text);
		}else if(obj.Success.Code==1){
			location.reload();
		}
	});
});


$(".navbar-toggler").click(function(){
	$("#navbarResponsive > ul > li > ul").addClass("show");
});