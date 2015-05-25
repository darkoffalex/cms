$(document).ready(function() {
// Add to main menu
$(".add").click(function()
	{
		var link = "_handles/popup-input.html";
		$.popup({"url":link});
		$.popup.show();
		return false;
	});//end add main menu
// Sorting change event
$(document).on("change","#sortable-order",function(){
		console.log("new order "+this.value);
		return false;
	});//end sorting event change
// Delete menu label event
$(document).on("click", ".delete", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		var link = "_handles/popup-confirm.html#"+data_id;
		$.popup({"url":link});
		$.popup.show();
		return false;
	});//end delete menu label event
// Edit menu label event
$(document).on("click", ".edit", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		$.popup("edit "+data_id+" ?");
		$.popup.show();
		return false;
	});//end edit menu label
// move label up
$(document).on("click", ".go-up", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" up");
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
		return false;
	});//end move label up
//move label down
$(document).on("click", ".go-down", function()
	{
		var data_id = $(this).parent().parent().attr("data-id");
		console.log(data_id+" down");
		$(".sortable").load("_handles/main-menu.html", function() { $.enable_handlers(); });
		return false;
	});//end move label down
});//end ready