jQuery(document).ready(function() {
    jQuery('#submit, .wpcf7-submit, .comment-reply-link, input[type="submit"]').addClass('btn btn-default');
    jQuery('.wp-caption').addClass('thumbnail');
    jQuery('.widget_rss ul').addClass('media-list');
    jQuery('table#wp-calendar').addClass('table table-striped')
});
jQuery(document).ready(function() {
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 100) {
            jQuery('.scroll-to-top').fadeIn()
        } else {
            jQuery('.scroll-to-top').fadeOut()
        }
    });
    jQuery('.scroll-to-top').click(function() {
        jQuery('html, body').animate({
            scrollTop: 0
        }, 800);
        return false
    })
});
jQuery(document).ready(function($) {
    $(window).load(function() {
        if($('.flexslider').flexslider !== undefined){
            $('.flexslider').flexslider({
                animation: "fade"
            })
        }
    })
});
(function() {
    var is_webkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
        is_opera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
        is_ie = navigator.userAgent.toLowerCase().indexOf('msie') > -1;
    if ((is_webkit || is_opera || is_ie) && document.getElementById && window.addEventListener) {
        window.addEventListener('hashchange', function() {
            var element = document.getElementById(location.hash.substring(1));
            if (element) {
                if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) element.tabIndex = -1;
                element.focus()
            }
        }, false)
    }
})();