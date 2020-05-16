function Order(options) {
    defaultOptions = {
        // Selector
        selector: null,
        // Add button selector
        btnAddSelector: null,
        // Delete button selector
        btnDeleteSelector: null,
        // Add template
        addTemplate: '<tr><td>New</td></tr>',
        // Hook Filter modifyTemplate
        modifyTemplate: null,
        // Hook Action afterAdd
        afterAdd: null,
        // Hook Action afterDelete
        afterDelete: null,
    }
    parameters = $.extend({}, defaultOptions, options);
    instance = this;
    $.each(defaultOptions, function (index, property) {
        instance[index] = parameters[index];
    })
    instance.init();
}
Order.prototype = {
    sort: function () {
        this.selector.find('.row-product').each(function (index) {
            $elem = $(this);
            $elem.find(':input').not(':button').each(function () {
                $input = $(this);
                name = $input.attr('name');
                name = name.replace(/(\[[\d]*\])/g, '[' + index + ']');
                $input.attr({'name': name});
            })
        });
    },
    add: function () {
        $(document).on('click', this.btnAddSelector.selector, {myOrder: this}, function (e) {
            e.preventDefault();
            var myOrder = e.data.myOrder;
            var $elem = $(this);
            if (myOrder.selector.find('.row-empty').length) {
                $('.row-empty').remove();
            }
            $tr = myOrder.addTemplate.clone();
            if (typeof (myOrder.modifyTemplate) == "function") {
                // Hooks Filter modifyValidationOptions
                $tr = myOrder.modifyTemplate($elem, $tr);
            }
            myOrder.selector.append($tr);
            myOrder.sort();
            if (typeof (myOrder.afterAdd) == "function") {
                // Hooks Filter modifyValidationOptions
                myOrder.afterAdd($elem);
            }
        })
    },
    remove: function () {
        $(document).on('click', this.btnDeleteSelector.selector, {myOrder: this}, function (e) {
            e.preventDefault();
            var myOrder = e.data.myOrder;
            var $elem = $(this);
            $elem.parent().parent().remove();
            if (typeof (myOrder.afterDelete) == "function") {
                // Hooks Filter modifyValidationOptions
                myOrder.afterDelete();
            }
        })
    },
    init: function () {
        this.add();
        this.remove();
    },
}