$(document).ready(function(){

    $(document).on("click", ".save-label",function(e){

        var save_id = $(this).data('save');
        var url = $(this).attr('href');
        var field = $('#input_for_'+save_id);

        var value = field.val();
        var name = field.attr('name');


        var dataArray = {};
        dataArray[name] = value;

        var request = $.ajax({
            method: "POST",
            url: url,
            data: dataArray
        });

        $.preLoader.show();

        request.done(function(msg) {
            if(msg == 'OK'){
                $.preLoader.hide();
            }else{
                alert("Request failed: " + msg);
                $.preLoader.hide();
            }
        });

        request.fail(function(jqXHR,textStatus) {
            alert("Request failed: " + textStatus);
            $.preLoader.hide();
        });

        return false;
    });
});//end ready