/**
 * Adding a row to editable input's table
 */
$(document).ready(function(){

    $(document).on("click", ".editable-table.row-add", function(){

        var names = String($(this).data('names'));
        var classes = String($(this).data('classes'));
        var placeholders = String($(this).data('placeholders'));
        var options = String($(this).data('options'));
        var action = String($(this).data('action'));
        var table_selector = String($(this).data('table'));

        var namesArr = names != undefined ? names.split(',') : [];
        var classArr = classes != undefined ? classes.split(',') : [];
        var placeArr = placeholders != undefined ? placeholders.split(',') : [];
        var optionsArr = options != undefined ? options.split('|') : [];

        var rowHTML = '<div class="list-row h36 editable-row">';

        for(i = 0; i < namesArr.length; i++){
            var curName = namesArr[i] !== undefined ? namesArr[i] : (namesArr[0] !== undefined ? namesArr[0] : '');
            var curClass = classArr[i] !== undefined ? classArr[i] : (classArr[0] !== undefined ? classArr[0] : '');
            var curPlaceholder = placeArr[i] !== undefined ? placeArr[i] : (placeArr[0] !== undefined ? placeArr[0] : '');
            var curOptions = optionsArr[i] !== undefined ? optionsArr[i] : (optionsArr[0] !== undefined ? optionsArr[0] : '');

            if(curOptions == ''){
                rowHTML+='<div class="cell no-padding"><input class="in-table-input '+curClass+'" type="text" placeholder="'+curPlaceholder+'" value="" name="'+curName+'[]"></div>';
            }else{
                var optionsCurArr = JSON.parse(curOptions);
                rowHTML+='<div class="cell no-padding"><select name="'+curName+'[]" class="in-table-input '+curClass+'">';

                $.each(optionsCurArr,function(index,value){
                    rowHTML+='<option value="'+index+'">'+value+'</option>'
                });

                rowHTML+='</select></div>'
            }
        }

        if(action == 'yes'){
            rowHTML+='<div class="cell no-padding smallest-min"><a href="#" class="spec-icon delete editable-table row-del"></a></div>';
        }

        rowHTML+='</div>';

        var table = $(table_selector);
        table.append(rowHTML);

        table.find('input.numeric-input-block').numeric({decimal:false});
        table.find('input.numeric-input-price').numeric({negative:false,decimalPlaces:2});

        return false;
    });

    /**
     * Removing row of editable inputs table
     */
    $(document).on("click", ".editable-table.row-del", function(){
        if($(this).parent().parent().parent().find('.editable-row').length > 1){
            $(this).parent().parent().remove();
        }
        return false;
    });

});

