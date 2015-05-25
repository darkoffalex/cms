$(document).ready(function(){
//check if at least one checkbox is checked.
$("input[type=checkbox]").click(function(e){
	if ($(".images input[type=checkbox]:checked").length > 0)
	{
		$(".delete-images").prop("disabled",false);
	}	else { $(".delete-images").prop("disabled", true); }
		
	});//end undo button
	
//open lightbox to upload images
$(".add-images").on("click", function() {
	$(".lightbox").fadeIn(300);
	$(".lightbox #upload-images").fadeIn(300);
	return false;
});//end lightbox upload

//open lightbox to edit image
$(".edit").on("click", function() {
	var image_id = $(this).data("id");
	console.log(image_id);
	$(".lightbox").fadeIn(300);
	$(".lightbox #edit-image").fadeIn(300);
	return false;
});//end lightbox edit

//open lightbox to delete image
$(".delete").on("click", function() {
	var image_id = $(this).data("id");
	console.log(image_id);
	$(".lightbox").fadeIn(300);
	$(".lightbox #delete-image").fadeIn(300);
	return false;
});//end lightbox delete

//delete checked images lightbox
$(".delete-images").on("click", function() {
	var value = [];
		$("input:checked").each(function(i){
				value[i] = $(this).val();
			});
	console.log(value);
	$(".lightbox").fadeIn(300);
	$(".lightbox #delete-images").fadeIn(300);
	return false;
});//end checked images lightbox

//close lightbox
$(".cancel").on("click", function() {
	$(".lightbox").fadeOut(300);
	$(".lightbox .content").fadeOut(300);
	return false;
});//end close lightbox
});//end ready