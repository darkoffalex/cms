/**
 * Show necessary inputs, depending on type, when editing field
 */
$(document).ready(function(){

    $(".triggered").addClass('force-hide');
    var triggers = $(".trigger-field");

    //trigger on page can already have required value for opening some fields
    triggers.each(function(){

        var value = $(this).val();
        var trigger_id = $(this).attr('id');

        $(".triggered").each(function(){

            if($(this).data('trigger') == trigger_id){

                var conditionsStr = String($(this).data('condition'));
                var conditionsArr = conditionsStr != undefined ? conditionsStr.split(',') : [];

                $(this).addClass('force-hide');

                if(conditionsArr.indexOf(value) !== -1){

                    $(this).removeClass('force-hide');
                }
            }
        });
    });

    //when changing trigger value
    triggers.change(function(){

        var value = $(this).val();
        var trigger_id = $(this).attr('id');

        $(".triggered").each(function(){

            if($(this).data('trigger') == trigger_id){

                var conditionsStr = String($(this).data('condition'));
                var conditionsArr = conditionsStr != undefined ? conditionsStr.split(',') : [];

                $(this).addClass('force-hide');

                if(conditionsArr.indexOf(value) !== -1){

                    $(this).removeClass('force-hide');
                }
            }

        });

    });

});


