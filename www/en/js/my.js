$(document).ready(function()
{
     
    var document = window.document;

    var requestAnimFrame = (function(){
        return  window["requestAnimationFrame"] || 
        function(callback){
            window.setTimeout(callback, 1000/60);    // 16.7ms display frequency displayed on most monitors
        };
    })();

    var cancelAnimFrame = (function(){
        return  window["cancelRequestAnimationFrame"] || 
        clearTimeout;
    })();

    //轮播图部分
    var carrousel   = $('.carrousel').find('.main-content'),    //轮播图容器
        counter     = 1,                                        //计数器，16.666毫秒 +1
        interval    = 3 * 60,                                   //一个循环经历时间，当计数器等于这个数时执行动画
                                                                //当大于等于时，重置计数器为 1
        flag        = true,                                     //为 true 动画继续，为 false 动画暂停
        carr_len    = carrousel.find('img').length,             //容器中的图片数
        carr_c      = null,
        carr_n      = null,
        carr_panel  = carrousel.find('.carrousel-panel');

    //鼠标进入容器，停止动画
    carrousel.mouseenter(function(){
        flag = false;
    });
    //鼠标离开容器，继续动画
    carrousel.mouseleave(function(){
        flag = true;
        requestAnimFrame(carr);
    });
    //动画默认执行
    requestAnimFrame(carr);
    //轮播图动画
    function carr(){
       
        counter++;
        //在初始化后 16.666 * 60，的时间时计算出当前显示的图片的序号和下一张图片的序号
        //这个时间只要保证在图片动画执行完成后再计算即可
        if (counter === 60) {
            
            carrousel.find('img').each(function(i){
                if ($(this).css('display') == 'block') {
                    carr_c = i;

                    if (carr_c !== null) {

                        if (carr_c < carr_len - 1) {
                            carr_n = carr_c + 1;
                        }else{
                            carr_n = 0;
                        }
                    }
                }
            });
        }
        //当等于设定的周期时，执行图片切换动画
        if (counter === interval) {
            carrousel.find('img').eq(carr_c).fadeOut('slow');
            carrousel.find('img').eq(carr_n).fadeIn('slow');
            carr_panel.find('.panel-btn').eq(carr_n).addClass('white-back');
            carr_panel.find('.panel-btn').eq(carr_n).siblings('.panel-btn').removeClass('white-back');
        }
        //当大于等于周期时，初始化计数器为 1
        if (counter >= interval) {
            counter = 1;
        }

        if (flag) {
            requestAnimFrame(carr);
        }else{
            cancelAnimFrame(carr);
        }
        
    }
    //给小圆点绑定点击事件
    carr_panel.find('.panel-btn').each(function(i){
        $(this).mouseenter(function(){
            carrousel.find('img').eq(carr_c).hide();
            carrousel.find('img').eq(i).show();
            carr_c = i;
            $(this).addClass('white-back');
            $(this).siblings('.panel-btn').removeClass('white-back');
        });
    })

    //导航部分
    var box = $('.navi-drop'),
        sub = '',
        showflag = true;

    //导航下拉
    $('.navi-bar').find('a.top-navi').each(function(i){
        
        $(this).mouseenter(function(){
            $(this).find('.navi-light').show();
            $(this).siblings('a.top-navi').find('.navi-light').hide();

            sub = $('.navi-drop').find('.main-content').eq(i),

            requestAnimFrame(navi);
        });
    });

    //导航收起
    $('.navigation').mouseleave(function(){
        requestAnimFrame(closeNavi);
    });

    /**
     * [navi 导航展开动画]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T11:55:50+0800
     * @return     {[type]} [description]
     */
    var naviHeight = 210;       //导航下拉的高度

    function navi(){

        var boxH = box.height(),    //包含所有下拉内容的容器高度
            subH = sub.height(),    //当前这个导航的下拉容器高度
            kids = sub.children().length;
        //如果目前有展开动画，则为 true，如果没有展开动画，则为 false
        showflag = true;
        //如果有下拉内容
        if (kids) {

            sub.show();
            sub.css('z-index', 2);
            sub.siblings('.main-content').css('z-index', 1);

            if (boxH < naviHeight) {
                box.height(boxH+10);
            }
            
            if (subH < naviHeight) {

                sub.height(subH+10);

                // sub.siblings('.main-content').each(function(i){
                //     if ($(this).height() > 0) {
                //         var sibH = $(this).height();

                //         $(this).height(sibH-10);
                //     };
                // });
                
            }else{

                showflag = false;
                sub.siblings('.main-content').height(0).css({'display':'none', 'z-index':1});
                cancelAnimFrame(navi);
                return false;
            }
        //没有下拉内容
        }else{

            if (boxH > 0) {

                box.height(boxH-10);
                box.find('.main-content').each(function(){

                    if ($(this).height() > 0) {
                        var H = $(this).height();

                        $(this).height(H-10);
                    }
                });

            }else{

                showflag = false;
                box.find('.main-content').height(0).css({'display':'none', 'z-index':1});
                cancelAnimFrame(navi);
                return false;
            }

        }

         requestAnimFrame(navi);

    }

    /**
     * [closeNavi 导航收起动画]
     * @AuthorName lzhan<lzhan@3ti.us>
     * @DateTime   2016-02-02T11:56:09+0800
     * @return     {[type]} [description]
     */
    function closeNavi(){
        //如果展开动画还在执行，则不执行收起动画
        if (showflag) {
            cancelAnimFrame(closeNavi);
            return false;
        };

        var boxH = box.height();

        if (boxH > 0) {

            box.height(boxH-10);
            box.find('.main-content').each(function(){

                if ($(this).height() > 0) {
                    var H = $(this).height();

                    $(this).height(H-10);
                }
            });

            requestAnimFrame(closeNavi);
        }else{

            box.find('.main-content').height(0).css({'display':'none', 'z-index':1});
            cancelAnimFrame(closeNavi);
            return false;
        }
    }

    //首页应用与解决方案轮播
    if ($('.roll-bar').length) {

        var container   = $('.roll-container'),         //包含所有移动元素的大容器
            kids        = container.find('.roll-block').length,     //容器中包含多少子元素
            kidsw       = container.find('.roll-block').outerWidth(),   //子元素的宽度
            direction   = 1,    //移动方向，1右，-1左
            step        = 8,    //每60毫秒移动的像素
            n           = 0;    //计数器

        container.width(kids * kidsw);

        $('.roll-left').click(function(){
            direction = -1;
            requestAnimFrame(roll);
        });

        $('.roll-right').click(function(){
            direction = 1;
            requestAnimFrame(roll);
        });

        function roll(){
            var left = parseInt(container.css('left'));

            container.css('left', (left + (direction * step)) + 'px');
            n++;

            left = parseInt(container.css('left'));

            if (left <= -2688) {container.css('left', '-1344px')}

            if (left >= 0) {container.css('left', '-1344px')}

            if (n >= kidsw / step) {
                n = 0;
                cancelAnimFrame(roll);
            }else{
                requestAnimFrame(roll);
            }
        }
        
    }
    //首页应用与解决方案轮播结束

    //如果页面有左侧边栏
    if ($('.main-box').find('.left').find('.sub1').length) {
        //左侧分类显示隐藏效果开始
        $('.main-box').find('.left').find('.sub1').each(function(i){

            var sub1 = $(this);
            var url  = sub1.attr('href');

            //如果访问的是这一个二级分类，则显示子集并且调整样式
            if (url == window.location.pathname) {
                sub1.css('backgroundColor', '#cee9f0');
                sub1.find('.arrow-h').hide();
                sub1.find('.tran-h').show();
                sub1.next('div').show();
            }

            var subCtg = sub1.next('div'),
                subLen = subCtg.children().length;
            //有子集的二级即使有链接也不能点    没有子集的二级可以点进去
            sub1.click(function(e){
                if (subLen) {

                    e.preventDefault();

                    var nextDiv = sub1.next('div'),
                        dis     = nextDiv.css('display');

                    if (dis == 'none') {
                        sub1.find('.arrow-h').hide();
                        sub1.find('.tran-h').show();
                        nextDiv.show();
                    }else{
                        sub1.find('.arrow-h').show();
                        sub1.find('.tran-h').hide();
                        nextDiv.hide();
                    }

                }
            });

            //sub1.find('.arrow-h').click(function(e){
            //    e.preventDefault();
            //    $(this).hide();
            //    sub1.find('.tran-h').show();
            //    sub1.next('div').show();
            //});
            //
            //sub1.find('.tran-h').click(function(e){
            //    e.preventDefault();
            //    $(this).hide();
            //    sub1.find('.arrow-h').show();
            //    sub1.next('div').hide();
            //});

        });
        //左侧分类显示隐藏效果结束

        $('.main-box').find('.left').find('.sub2').each(function(i){

            var url = $(this).attr('href');
            //如果页面是三级分类，展开这个三级的父级分类并且调整样式
            if (url == window.location.pathname) {
                $(this).parent('.sub-wrapper').show();
                $(this).parent('.sub-wrapper').prev('.sub1').find('.arrow-h').hide();
                $(this).parent('.sub-wrapper').prev('.sub1').find('.tran-h').show();
                $(this).css('color', '#f00');
            }

            $(this).prev('.sub1').css('backgroundColor', '#cee9f0');

        });


    }
    //如果页面有左侧边栏

});