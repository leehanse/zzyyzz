$(window).load(function() {
    $('#carousel').flexslider({
        animation: "slide",
        controlNav: true,
        directionNav: false,
        animationLoop: true,
        slideshow: true,
        itemWidth: 114,
        itemMargin: 0,
        asNavFor: '#slider'
    });

    $('#slider').flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: true,
        sync: "#carousel"
    });

    $('#property-slider .flexslider').flexslider({
        animation: "fade",
        slideshowSpeed: 6000,
        animationSpeed:	1300,
        directionNav: true,
        controlNav: false,
        keyboardNav: true
    });
});