$(function()
{
    $('.media-placeholder').each(function()
    {
        var $this = $(this);
        $this.attr('style', 'background-color: hsl(' + $this.data('id') * 57 % 360 + ', 80%, 90%)');
    });

    if ($('[data-toggle="tooltip"]')) {
        // $('[data-toggle="tooltip"]').tooltip({container: 'body'});
    }
    
    $('#modeControl a').click(function()
    {
        $('#modeControl a').removeClass('active');
        $(this).addClass('active');
        $('#modeControl').parents('.list-condensed').find('section').hide();
        $('#' + $(this).data('mode') + 'Mode').show();
        $.cookie('productViewType', $(this).data('mode'), {path: "/"});
    })
    var type = $.cookie('productViewType');
    if(typeof(type) == 'undefined' || type == '') type = 'card';
    $('#modeControl').find('[data-mode=' + type +']').click();


    var box         = $(".product-box"),
        title_box   = box.find('.table-title'),
        box_w       = 0;
        

    //给全部属性的容器赋予宽度
    $("#param_table").find('tbody').find('tr').each(function(){

        var atr_max     = 0;

        $(this).find('td').each(function(){

            var len = $(this).find('.atr-block').length;

            if (len > atr_max) {
                atr_max = len;
            }

        });

        $(this).find('td').each(function(){

            var len = $(this).find('.atr-block').length;

            if (len < atr_max) {
                var h = atr_max * 30 / len;

                $(this).find('.atr-block').height(h).css('line-height', h + 'px');
            }

        });


    });

    $('#productwin').perfectScrollbar();

})
