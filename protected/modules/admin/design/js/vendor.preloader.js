(function( $ ){

    $.preLoader = function()
    {
        this.show();
    };

    $.preLoader.show = function()
    {
        var body = $("body");
        var html = '<div class="overlay-pre-load"></div>';
        body.append(html);
    };

    $.preLoader.hide = function()
    {
        $('.overlay-pre-load').remove();
    }

})( jQuery );
