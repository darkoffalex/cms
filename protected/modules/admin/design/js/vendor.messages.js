$(document).ready(fnction(){
//add label
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
});//end ready