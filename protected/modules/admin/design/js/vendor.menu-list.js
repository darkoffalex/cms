$(document).ready(function(){
//change order event
$(".order").click(function()
	{
		alert('change order event');
	});//end change order event
//delete
$(".delete").click(function(e)
	{
		e.preventDefault();
		var item_id = $(this).attr("data-id");
		$.popup({"url":"_handles/popup-confirm.html"});
		$.popup.show();
		return false;
	});//end delete
//add button
$(".add").click(function(e)
	{
		$(".lightbox").fadeIn(300);
		return false;
	});//end add button
// cancel lightbox
$("#cancel-label").click(function(e)
	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end cancel lightbox
// submit lighbox
$(".lightbox form").submit(function(e)
	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end submit lightbox
});//end ready