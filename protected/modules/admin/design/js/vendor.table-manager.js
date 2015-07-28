$(document).on("click", ".table-manage.row-add", function(){

    var table_selector = $(this).data('table');
    var table = $(table_selector);
    var last_row = table.find(".editable-row").last();
    var last_row_html = last_row.get(0).outerHTML;
    table.append(last_row_html);
    return false;

});