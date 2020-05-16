function ZeroBox(options) {
    defaultOptions = {
        // Selector
        selector: null,
        // Template
        template: null,
        // Message
        title: "",
        // Message
        message: "",
    }
    parameters = $.extend({}, defaultOptions, options);
    instance = this;
    $.each(defaultOptions, function (index, property) {
        instance[index] = parameters[index];
    })
    instance.init();
}

ZeroBox.prototype = {
    // Current selector
    current: null,
    // Status
    status: false,
    show: function (e) {
        e.preventDefault();
        $elem = $(this);
        me = e.data.me;
        // Set current selector
        me.current = $elem;
        // Is callback prepareMessage valid
        if (typeof (me.prepareMessage) == "function") {
            // Prepare message
            me.prepareMessage();
        }
        // Set title
        $('.modal-title', me.template).html(me.title);
        // Set message
        $('.modal-body', me.template).html(me.message);
        // Show Modal Dialog
        me.template.modal('show');
    },
    hide: function (e) {
        this.template.modal('hide');
    },
    init: function () {
        this.template.modal({backdrop: 'static', keyboard: false}).modal('hide');
        // Attach Event Handler click to selector
        $(document).on('click', this.selector.selector, {me: this}, this.show);
        // Attach Event Handler click to buttons selector
        $(document).on('click', this.template.selector + ' .btn-action', {me: this}, this.confirm);
    },
    confirm: function (e) {
        $elem = $(this);
        status = $elem.val();
        me = e.data.me;
        me.status = status;
        // Hide Modal Dialog
        me.hide(e);
        // Is callback processConfirmation valid
        if (typeof (me.processConfirmation) == "function") {
            // Process Confirmation
            me.processConfirmation();
        }
    },
}