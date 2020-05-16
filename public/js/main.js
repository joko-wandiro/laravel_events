jQuery(document).ready(function ($) {
    $("a.nav-cart, .cart-info").mouseenter(function () {
        $('.cart-info').show();
    })
    $("a.nav-cart, .cart-info").mouseleave(function () {
        $('.cart-info').hide();
    })
});
