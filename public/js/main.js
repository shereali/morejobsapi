jQuery(document).ready(function( $ ) {

    $("#offerCarousel").owlCarousel({
        items:4,
        margin:15,
        navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
        nav:true,
        loop: false,
        autoplay: true,
        autoplayHoverPause: true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });

    $('select#niceselect').niceSelect();

    $('[data-toggle="tooltip"]').tooltip();

});