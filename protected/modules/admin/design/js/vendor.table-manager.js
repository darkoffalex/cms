/**
 * Adding a row to editable input's table
 */

$(document).on("click", ".editable-table.row-add", function(){

    var names = $(this).data('names');
    var classes = $(this).data('classes');
    var placeholders = $(this).data('placeholders');
    var action = $(this).data('action');
    var table_selector = $(this).data('table');

    var namesArr = names.split(',');
    var classArr = classes.split(',');
    var placeArr = placeholders.split(',');

    var rowHTML = '<div class="list-row h36 editable-row">';

    for(i = 0; i < namesArr.length; i++){
        var curName = namesArr[i] !== undefined ? namesArr[i] : (namesArr[0] !== undefined ? namesArr[0] : '');
        var curClass = classArr[i] !== undefined ? classArr[i] : (classArr[0] !== undefined ? classArr[0] : '');
        var curPlaceholder = placeArr[i] !== undefined ? placeArr[i] : (placeArr[0] !== undefined ? placeArr[0] : '');

        rowHTML+='<div class="cell no-padding"><input class="in-table-input '+curClass+'" type="text" placeholder="'+curPlaceholder+'" value="" name="'+curName+'[]"></div>';
    }

    if(action == 'yes'){
        rowHTML+='<div class="cell no-padding smallest"><a href="#" class="spec-icon delete editable-table row-del"></a></div>';
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
    if($('.editable-row').length > 1){
        $(this).parent().parent().remove();
    }
    return false;
});