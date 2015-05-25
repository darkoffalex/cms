$(document).ready(function(){
//toggle checkbox
$('[id="checkall_pages"]').each(function(){
	$(this).toggleAll();
	});//end toggle checkbox
//delete page
$('.delete-page').click(function(e)
	{
		e.preventDefault();
		var data_id = $(this).attr('data-id');

		console.log(data_id);
	});//end delete page
//delete all pages
$('.delete-all-pages').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
		console.log(value);
	});//end delete all pages
//copy
$('.copy').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
		console.log(value);
	});//end copy
//refresh
$('.refresh').click(function(e)
	{
		e.preventDefault();
	});//end refresh
//add page
$('.add').click(function(e)
	{
		e.preventDefault();
	});//end add page
});//end ready