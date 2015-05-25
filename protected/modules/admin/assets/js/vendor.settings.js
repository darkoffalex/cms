$(document).ready(function(){
//tab line
$(".editor > .tab-line > span").bind("click", function(e){
		$(this).addClass("active");
		$(this).siblings().removeClass("active");
		var tab_id = $(this).attr("data-for");
		var cont = $(".editor > .editor-content > div[data-content="+tab_id+"]");
		if(!cont.is(":visible"))
			cont.fadeIn(300);
		cont.siblings().hide();
	});//end tabl line
//undo button
$(".undo").click(function(e){
		e.preventDefault();
		var data_id = $(this).attr('data-id');
		console.log("undo?");
	});//end undo button
//delete button
$(".del").click(function(e){
		e.preventDefault();
		var data_id = $(this).attr('data-id');
	});//delete undo button
//save button
$(".save").click(function(e){
		e.preventDefault();
	});//end save button
});//end ready