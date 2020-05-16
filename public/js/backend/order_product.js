jQuery(document).ready(function ($) {
    OrderMonitor = {
        selector: $('#order-table'),
        reset: function () {
            // Reset form
            $('.btn-delete', this.selector).trigger('click');
            $(':input[name="nominal"]', this.selector).val("");
            $('.change .price', this.selector).html("-");
        },
        calculate: function () {
            subtotal = 0;
            $(':input[name$="[id_product]"]', this.selector).each(function () {
                $elem = $(this);
                var id_product = $elem.val();
                var product = site.products[id_product];
                var qty = $elem.parent().find(':input[name$="[qty]"]').val();
                qty = (qty.length >= 1) ? qty : 0;
                var price = product.price * qty;
                subtotal += price;
            })
            tax = subtotal * site.settings.tax / 100;
            total = subtotal + tax;
            $('.subtotal .price', this.selector).html(subtotal.toLocaleString('id-ID'));
            $('.ppn .price', this.selector).html(tax.toLocaleString('id-ID'));
            $('.total .price', this.selector).html(total.toLocaleString('id-ID'));
            // Assign values to object
            this.total = total;
            console.log("testing");
        },
        total: 0,
    }
    // Order product
    var options = {
        selector: $('#order-table'),
        btnAddSelector: $('.menu a'),
        btnDeleteSelector: $('#order-table .btn-delete'),
        addTemplate: $('#template-product .row-product'),
        modifyTemplate: function ($elem, $tr) {
            var id = $elem.attr('data-id');
            var product = site.products[id];
            $tr.find(':input[name$="[id_product]"]').val(product.id);
            $tr.find(':input[name$="[qty]"]').val('1');
            $tr.find('.description .name').html(product.name);
            $tr.find('.price').html(product.price_format);
            return $tr;
        },
        afterAdd: function ($elem) {
            OrderMonitor.calculate();
        },
        afterDelete: function () {
            OrderMonitor.calculate();
        },
    }
    myOrder = new Order(options);
    OrderMonitor.calculate();
    // Update order while user change quantity
    $(document).on('keyup mouseup', '#order-table :input[name$="[qty]"]', function (e) {
        OrderMonitor.calculate();
    });

    // Restrict e, -, + for html input number
    $(document).on('keypress', '#order-table :input[name$="[qty]"]', function (e) {
        if (isNaN(e.key)) {
            return false;
        }
    });

    // Update change while nominal are entered
    $(document).on('keyup', '#order-table :input[name="nominal"]', function (e) {
        var $elem = $(this);
        var nominal = $elem.val().replace(/\./, '');
        if (nominal >= OrderMonitor.total) {
            var change = nominal - OrderMonitor.total;
            $('#order-table .change .price').html(change.toLocaleString('id-ID'));
        } else {
            $('#order-table .change .price').html('0');
        }
    });
    $('#order-table :input[name="nominal"]').trigger('keyup');
    // Mask input
    var options = {
        selector: $(':input[name="nominal"]'),
        type: 'number',
    }
    myZeroMask = new ZeroMask(options);
    // Cancel order
    $(':input[name="cancel"]').on('click', function (e) {
        OrderMonitor.reset();
    })
    // Form submit
    $('form').submit(function (e) {
        e.preventDefault();
        $form = $(this);
        $('.error', $form).remove();
        url = $form.attr('action');
        data = $form.serialize();
        myFeedback = new Feedback();
        myFeedback.selector = $form;
        myFeedback.type = (site.method == "edit") ? 'order_update' : 'order';
        myAjax = new Ajax();
        myAjax.hideBlockUI = false;
        myAjax.feedback = myFeedback;
        myAjax.send(url, data, "json", "POST");
    })
    // Menu Navigation
    $('#menus-navigation li a').on('click', function (e) {
        $elem = $(this);
        // Set active class to link element
        $('#menus-navigation li a').removeClass('active');
        $elem.addClass('active');
        // Display menu for specific category
        id_category = $elem.attr('data-id');
        $('#menus-list li').hide();
        $('#menus-list li.' + id_category).show();
    })
    $('#menus-navigation li:first a').trigger('click');
})