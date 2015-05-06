/*created by Sergey Rusanov*/
$(document).ready(function(){

$(".search-input-wrapper > button")
	.button({
		icons: {primary: "ui-icon-search"},
		text: false,
	});

$("#search-input").keypress(function(event){
	if($(this).hasClass("error-input")) {
		$(this).val("");
		$(this).removeClass("error-input");
	};
	});

	
$("#search").submit( function(ev){
	ev.preventDefault();
	var value = $("#search-input").val();
	if(value.length !== 0) {
		$("#search-input").val("");
		search(value);
	} else {
		$("#search-input").addClass("error-input").val("Введите критерий поиска.");
	}
	return false;
	});

function search(value){
		var data = {
					url: "index.php",
					params: "operation=2&q=" + value,
					};
		console.log(data);
		myAjax(data);
		return false;
};

function likeClick() {
	var like, type = $(this).attr("id").split("-")[0] === "project" ? 20 : 10;
	if($(this).hasClass("like")){
		like = 1;
		$(this).removeClass("like").addClass("unlike");
	} else  {
		like = 0;
		$(this).removeClass("unlike").addClass("like");
	}
	var id = $(this).attr("id").split("-");
		var data = {
				id : id[1],
				like : like,
				type : type,
				operation : 1,
				};
		console.log(data);
		manageLike(data);
	return false;
};


$(".mainPlate").on("click", ".counter-plate > div", likeClick);
$(".mainPlate").on("click", ".contributor-item > div", likeClick);
$(".mainPlate").on("click", ".user-logo-like > div:last-child", likeClick);

var contributor = $(".mainPlate").find(".contributor-item").find("div");
$(contributor).button();

function manageLike(data){
	var retval = true;
	$.ajax({
		method: "get",
		url: "index.php",
		data: data,
		}).done(function(msg){
				console.log(msg);
			});
	return retval;
};

$(".mainPlate").on("click", ".title-plate > span > a", function(event){
	if(!$(this).hasClass("release")) {
		event.preventDefault();
		myAjax(parseLink($(this)));
		return false;
	}
});

$(".mainPlate").on("click", ".contributor-item > a", function(event){
	if(!$(this).hasClass("release")) {
		event.preventDefault();
		myAjax(parseLink($(this)));
		return false;
	}
});

function parseLink(target) {
	var data = {
			url : "index.php", 
			params : $(target).attr("href").split('?')[1],
			};
		console.log(data);
	return data;
};

function setOverlay(target) {
	$(target).css({"position":"relative"});
	$(".mainPlate-wrapper").css({
				"opacity" : 0.2,
				});
	$("<div/>", {"class" : "overlay"})
						.appendTo(target);
	return false;
};

function removeOverlay(target) {
	$(".mainPlate-wrapper").css({
		"opacity" : 1,
	});
	$(".overlay").replaceWith("");
	return false;
};


function myAjax(data){
	$.ajax({
		url: data.url,
		data: data.params,
		cache: false,
		beforeSend : function(){ setOverlay(".mainPlate"); },
		})
		.done(function(html){
			removeOverlay(".mainPlate");
			$(".mainPlate-wrapper").replaceWith(html);
			$(".contributor-item > div").button();
			$(".counter-plate > div").button();
			$(".user-logo-like > div:last-child").button();
			});
	return false;
};
});
