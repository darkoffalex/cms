/**
 * Shows modal confirmation dialog box
 */
$(document).on("click", ".confirm-box", function(){
    var href = $(this).attr('href');

    var question = 'Delete ?';
    var yes = 'Yes';
    var no = 'Cancel';

    var msg_q = $('#confirmation-question').val();
    var msg_y = $('#confirmation-yes').val();
    var msg_n = $('#confirmation-no').val();

    if(typeof msg_q !== 'undefined'){
        question = msg_q;
    }
    if(typeof msg_y !== 'undefined'){
        yes = msg_y;
    }
    if(typeof msg_n !== 'undefined'){
        no = msg_n;
    }

    //random id part
    var randDialogIndex = Math.floor((Math.random() * 9999) + 1);

    //if should use ajax link
    var ajax_class = $(this).hasClass('ajax') ? 'ajax' : '';

    //block preset
    var markup = [
        '<div class="popup-box">',
        '<div class="popup-content">',
        '<a class="popup-close" href="#"></a><span class="message">'+question+'</span>',
        '<a id="'+'cancel_'+randDialogIndex+'" href="#" class="button cancel">'+no+'</a>',
        '<a id="'+'confirm_'+randDialogIndex+'" href="'+href+'" class="button confirm '+ajax_class+'">'+yes+'</a>',
        '</div></div>'
    ].join('');

    //append hidden
    $(markup).hide().appendTo('body');

    //show
    $("body").css({"overflow":"hidden"});
    $('.popup-box').fadeIn();
    var top = ($(window).height())/2-$(".popup-box > .popup-content").height() - 150;
    $(".popup-box > .popup-content").animate({"margin-top":top+"px"},300);

    return false;
});

/**
 * Hides dialog-box
 */
var hide_dialog = function(){
    $('.popup-box').fadeOut(function(){
        $(this).remove();
        $("body").css({"overflow":"auto"});
    });
};

var hide_dialog_fast = function(){
    $('.popup-box').remove();
    $("body").css({"overflow":"auto"});
};

/**
 * Perform ajax action link
 */
$(document).on("click", ".ajax", function(){
    if(!$(this).hasClass('confirm-box'))
    {
        var href = $(this).attr('href');

        $.preLoader.show();

        var request = $.ajax({url: href});

        request.done(function(msg) {
            if(msg == 'OK')
            {
                if(typeof(ajaxRefreshTable) == "function"){
                    ajaxRefreshTable();
                }
            }
            else{
                alert('Response content  = ' + msg)
            }
            $.preLoader.hide();
            hide_dialog();
        });

        request.fail(function(jqXHR,textStatus) {
            alert( "Request failed: " + textStatus);
            $.preLoader.hide();
            hide_dialog_fast();
        });
    }

    return false;
});