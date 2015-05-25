$(document).ready(function() {
// Add to main menu
$(".menu-content > .tab-line > span").bind("click", function(e){
	$(this).addClass("active");
	$(this).siblings().removeClass("active");
	var tab_id = $(this).attr("data-lang");
	var cont = $(".menu-content > .inner-content .tabs table[data-tab="+tab_id+"]");
	if(!cont.is(":visible"))
		cont.fadeIn(300);
	cont.siblings().hide();
}); // end tabs
// undo button
$(".undo").click(function()
	{
		console.log("undo");
		return false;
	}); // end undo buttons
// delete button
$(".del").click(function()
	{
		data_id = $(this).attr("data-id");
		console.log("delete"+data_id);
		return false;
	}); // end delete button
// delete label
$(document).on("click", ".delete", function()
	{
		if ($(this).hasClass("active"))
			{
				var data_id = $(this).attr("data-id");
				var link = "_handles/popup-confirm.html";
				$.popup({"url":link});
				$.popup.show();
			}
		return false;
	}); // end delete label
});//end ready