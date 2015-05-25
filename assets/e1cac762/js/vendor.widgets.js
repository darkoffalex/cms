$(document).ready(function(){
//toggle checkbox region
$('[id="checkall_region"]').each(function(){
	$(this).toggleAll();
	});//end toggle checkbox region
//toggle checkbox offers
$('[id="checkall_offers"]').each(function(){
	$(this).toggleAll();
	});//end toggle checkbox offers
//add widget button
$(".add").click(function(e){
	e.preventDefault();
	return false;
	});//end add widget button
//delete region
$('.delete-region').click(function(e)
	{
		e.preventDefault();
		var data_id = $(this).attr('data-id');
		var elem = $(this).closest('.list-row');
	});//end delete region
//delete selected regions
$('.delete-all-regions').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
		var elem = $(this).closest('.translate-row');
	});//end delete selected regions
//copy selected regions
$('.copy-all-regions').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
		var elem = $(this).closest('.translate-row');
	});//end copy selected regions
//delete offer
$('.delete-offer').click(function(e)
	{
		e.preventDefault();
		var data_id = $(this).attr('data-id');
		var elem = $(this).closest('.list-row');
	});//end delete offer
//delete selected offers
$('.delete-all-offers').click(function(e)
	{
		e.preventDefault();
		var value = [];
		$("input[name^="+$(this).attr('data-id')+"]:checked").each(function(i){
				value[i] = $(this).val();
			});
	});//end delete selected offers
});//end ready