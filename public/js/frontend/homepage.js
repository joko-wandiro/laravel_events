jQuery(document).ready(function ($) {
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 1,
    })
    $("a.nav-cart, .cart-info").mouseenter(function(){
        $('.cart-info').show();
    })
    $("a.nav-cart, .cart-info").mouseleave(function(){
        $('.cart-info').hide();
    })    
});
