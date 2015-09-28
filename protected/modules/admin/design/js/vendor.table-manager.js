/**
 * Adding a row to editable input's table
 */

$(document).ready(function(){

    /**
     * When clicking on 'plus' icon (under small dynamic tables)
     */
    $(document).on("click", ".editable-table.row-add", function(){

        var names = String($(this).data('names')); //names of fields (used as field names)
        var classes = String($(this).data('classes')); //classes of fields (used as class names for fields)
        var placeholders = String($(this).data('placeholders')); //placeholders for every field
        var options = String($(this).data('options')); //if this not empty - instead of text input will be rendered selector with options
        var action = String($(this).data('action')); //if this set to true - action row will be rendered (delete button)
        var table_selector = String($(this).data('table')); //jquery selection of table container

        var namesArr = !empty(names) ? names.split(',') : []; //names of field separated by ","
        var classArr = !empty(classes) ? classes.split(',') : []; //classes separated by ","
        var placeArr = !empty(placeholders) ? placeholders.split(',') : []; //placeholders separated by ","
        var optionsArr = !empty(options) ? options.split('|') : []; //options separated by "|"

        //start build new row
        var rowHTML = '<div class="list-row h36 editable-row">';

        //pass through all field names
        for(i = 0; i < namesArr.length; i++){
            //get current name
            var curName = !empty(namesArr[i]) ? namesArr[i] : (!empty(namesArr[0]) ? namesArr[0] : '');
            //get current class
            var curClass = !empty(classArr[i]) ? classArr[i] : (!empty(classArr[0]) ? classArr[0] : '');
            //get current placeholder
            var curPlaceholder = !empty(placeArr[i]) ? placeArr[i] : (!empty(placeArr[0]) ? placeArr[0] : '');
            //get current options
            var curOptions = !empty(optionsArr[i]) ? optionsArr[i] : (!empty(optionsArr[0]) ? optionsArr[0] : '');

            //if options not set - add simple text input
            if(empty(curOptions)){
                rowHTML+='<div class="cell no-padding"><input class="in-table-input '+curClass+'" type="text" placeholder="'+curPlaceholder+'" value="" name="'+curName+'[]"></div>';
            //if options set - add selectable input with otions
            }else{
                var optionsCurArr = JSON.parse(curOptions);
                rowHTML+='<div class="cell no-padding"><select name="'+curName+'[]" class="in-table-input '+curClass+'">';

                $.each(optionsCurArr,function(index,value){
                    rowHTML+='<option value="'+index+'">'+value+'</option>'
                });

                rowHTML+='</select></div>'
            }
        }

        //if should render action row - append necessary HTML
        if(action == 'yes'){
            rowHTML+='<div class="cell no-padding smallest-min"><a href="#" class="spec-icon delete editable-table row-del"></a></div>';
        }

        //close tag
        rowHTML+='</div>';

        //append generated HTML to table
        var table = $(table_selector);
        table.append(rowHTML);

        //special validation for numeric/price fields
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

/**
 * Analog of "empty" in php
 * @param val
 * @returns {boolean}
 */
function empty(val) {

    if(val === '')
        return true;

    if (val === undefined)
        return true;

    if(val == undefined || val == "undefined")
        return true;

    if(typeof val == 'undefined' || typeof val == "undefined" || typeof val === 'undefined' || typeof  val === "undefined")
        return true;

    if (typeof (val) == 'function' || typeof (val) == 'number' || typeof (val) == 'boolean' || Object.prototype.toString.call(val) === '[object Date]')
        return false;

    if (val == null || val.length === 0)
        return true;

    if (typeof (val) == "object") {
        var r = true;
        for (var f in val)
            r = false;
        return r;
    }
    return false;
}

