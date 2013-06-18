jQuery(function(){
    var slider = jQuery('#slider1').bxSlider({
        auto:true,
        pause:10000,
        autoDelay:2000,
        autoHover:true,
        speed:800,
        displaySlideQty: 3,
        moveSlideQty: 3,
        prevSelector:'.demo-wrap .bx-nav',
        nextSelector:'.demo-wrap .bx-nav',
        onPrevSlide: function(currentSlideNumber){
            jQuery('.ul_page li[pagenum='+currentSlideNumber+']').triggerHandler('click');
        },
        onNextSlide: function(currentSlideNumber){
            jQuery('.ul_page li[pagenum='+currentSlideNumber+']').triggerHandler('click');          
        }
    });
    
    jQuery('#slider1').css("visibility","visible");    
    
    jQuery('.ul_page li').click(function(){
        jQuery('.ul_page li').removeClass('current');
        slider.goToSlide(jQuery(this).attr('pagenum'));
        jQuery(this).addClass('current');
        return false;
    });
    
    jQuery('#bulletinslider').bxSlider({
        controls: true,
        prevSelector:'#bx-prev',
        prevText:'',
        nextSelector:'#bx-next',
        nextText:'',
        pager:true,
        pagerType:'short',
        pagerSelector:'#bspager'
    });
    jQuery('.bx-pager-current')[0].nextSibling.nodeValue = jQuery.trim(jQuery('.bx-pager-current')[0].nextSibling.nodeValue);
    
    jQuery('#bulletinslider').css("visibility","visible");
    
    jQuery('.demo-wrap2 #slider2').bxSlider({
        speed:800,
        displaySlideQty: 2,
        moveSlideQty: 2,
        prevSelector:'.demo-wrap2 .bx-nav',
        nextSelector:'.demo-wrap2 .bx-nav'
    });
    
    jQuery('.demo-wrap2 #slider2').css("visibility","visible"); 
})
