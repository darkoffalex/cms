$(document).ready(function(){
//toggle checkbox
$('[id="checkall_products"]').each(function(){
	$(this).toggleAll();
	}); //end toggle checkbox
//delete items
$('.delete').click(function(e)
	{
		e.preventDefault();
		var data_id = $(this).attr('data-id');
		var elem = $(this).closest('.list-row');
	});//end delete items
//delete selected
$('.del').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
	});//end delete selected
// copy selection
$('.copy').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
	});//end copy selection
});//end ready