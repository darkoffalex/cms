$(document).ready(function() {
// undo button
$(".undo").click(function()
	{
		console.log("undo");
		return false;
	});// end undo button
//delete button
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
	});//end delete button
$(".add-image").click(function(e)
	{
		$(".lightbox").fadeIn(300);
		return false;
	});//end add button
// cancel lightbox
$(".cancel-images").click(function(e)
	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end cancel lightbox
// submit lighbox
$(".load-images").submit(function(e)
	{
		$(".lightbox").fadeOut(300);
		return false;
	});//end submit lightbox
});//end ready