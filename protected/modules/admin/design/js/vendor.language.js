$(document).ready(function(){
// add label
$('.add-label').click(function(e)
	{
		e.preventDefault();
	});//end add label
//delete
$('.delete').click(function(e)
	{
		e.preventDefault();
		var data_id = $(this).attr('data-id');
		var elem = $(this).closest('.translate-row');
	});//end delete
//save
$('.save').click(function(e)
	{
		var id = $(this).attr("data-id");
		var value = $(this).parent().parent().find(".translations > input").val();
		console.log(value);
		e.preventDefault();
		return false;
	});//end save
//submit search
$('#search-language-form').submit(function(e)
	{
		value = $(this).children("input[type=text]").val();
		console.log(value);
		e.preventDefault();
		return false;
	});
});//end submit search