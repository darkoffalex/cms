$(document).ready(function() {

// Sorting change event
    $(document).on("change","#orders",function(){

        var request = $.ajax({
            method: "POST",
            url: $('#ajax-swap-link').val(),
            data: { orders: this.value}
        });

        request.done(function(msg) {
            if(msg == 'OK')
            {
                ajaxRefreshTable();
            }
        });

        request.fail(function(jqXHR,textStatus) {
            alert( "Request failed: " + textStatus);
        });

        return false;
    });

// Table reloaded event
    $(document).on("table-update",".sortable",function(){
        $.enable_handlers();
    });

});// end document ready


/**
 * Refresh table of menu items
 */
var ajaxRefreshTable = function()
{
    var request = $.ajax({url: $('#ajax-refresh-link').val()});

    request.done(function(data){
        $('.sortable').html(data).trigger('table-update');
        $.preLoader.hide();
    });

    request.fail(function(jqXHR,textStatus) {
        alert( "Request failed: " + textStatus);
        $.preLoader.hide();
    });
};