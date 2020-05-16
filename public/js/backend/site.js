function Feedback() {
}
Feedback.prototype = {
    'selector': $('body'),
    'default': function (data) {
        console.log(data);
    },
    handleValidationFailure: function (response) {
        $.each(response.errors, function (fieldId, messages) {
            $span = $('<label/>').addClass('error');
            $span.html(messages.join("<br/>"));
            inputName = '';
            fields = fieldId.split(".");
            ct = 0;
            while (segment = fields.shift()) {
                if (!ct) {
                    inputName += segment;
                } else {
                    inputName += '[' + segment + ']';
                }
                ct++;
            }
            $input = $(':input[name="' + inputName + '"]:enabled');
            if ($input.is(':radio, :checkbox')) {
                $input = $input.parent();
            }
            $span.insertAfter($input);
        })
    },
    order: function (response) {
        OrderMonitor.reset();
        window.open(response.url);
    },
    order_update: function (response) {
        alert(response.message);
    },
    removeRecord: function (response) {
        // Remove table row
        $tableRow = this.selector.parent().parent().parent();
        $tableRow.remove();
        this.displayAlertThenReloadListView(response);
    },
    // Display feedback to user for remove record
    'displayAlertThenReloadListView': function (response) {
        var $elem = window.myDKScaffolding.selector;
        var htmlAlert = '<p class="alert alert-success fade in">' + response.msg + '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>';
        $('.page-header', $elem).after(htmlAlert);
        setTimeout(function () {
            // Reload ListView
            $elem.find('form').trigger('submit');
        }, 1000);
    },
    // Display feedback to user for resume create
    'responseWithTimerThenRedirect': function (msg, url) {
        // Block UI
        $('#modal-loading .modal-body').html(msg);
        $('#modal-loading').modal('show');
        setTimeout(function () {
            // Hide Block UI
            $('#modal-loading').modal("hide");
            window.location.href = url;
        }, 3000);
    },
    // Display feedback to user for success or error
    'responseWithTimer': function (msg) {
        // Block UI
        $('#modal-loading .modal-body').html(msg);
        $('#modal-loading').modal('show');
        setTimeout(function () {
            // Hide Block UI
            $('#modal-loading').modal("hide");
        }, 3000);
    }
}
function Ajax(options) {
    defaultOptions = {
        loaderContent: '<div class="loader"></div>',
        showLoader: function () {
            $.blockUI({
                message: this.loaderContent,
                baseZ: 99999
            });
        },
        hideLoader: function () {
            $.unblockUI();
        },
    }
    parameters = $.extend({}, defaultOptions, options);
    instance = this;
    $.each(defaultOptions, function (index, property) {
        instance[index] = parameters[index];
    })
}
Ajax.prototype = {
    feedback: new Feedback(),
    send: function (url, data, dataType, type) {
        dataType = typeof (dataType) == "undefined" ? "html" : dataType;
        type = typeof (type) == "undefined" ? "GET" : type;
        myAjax = this;
        $.ajax({
            // Start keep reference variable for specific AJAX Request
            theobject: myAjax,
            // End keep reference variable for specific AJAX Request
            dataType: dataType,
            type: type,
            url: url,
            data: data,
            beforeSend: function () {
                this.theobject.showLoader();
            },
            finish: function () {
                this.theobject.hideLoader();
            },
            success: function (response, type, xhr) {
                this.finish();
                switch (xhr.status) {
                    case 200:
                        myFeedback = this.theobject.feedback;
                        type = myFeedback.type;
                        myFeedback[type](response);
                        break;
                }
            },
            error: function (xhr, type, statusCode) {
                this.finish();
                switch (xhr.status) {
                    case 400:
                        myFeedback = this.theobject.feedback;
                        myFeedback.handleValidationFailure(xhr.responseJSON);
                        break;
                    default:
                        alert("There's something error occurs. Please try again !");
                }
            }
        });
    }
}
jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
jQuery(document).ready(function ($) {
    // Implement Custom Confirmation Box
    ZeroBoxOpts = {
        selector: $('.dk-scaffolding .btn-remove'),
        template: $('#confirmation-box'),
        title: $('.page-header h1').html(),
        message: site.confirmDeleteMessage,
    }
    $Box = new ZeroBox(ZeroBoxOpts);
    $Box.processConfirmation = function () {
        if (this.status) {
            $obj = this.current;
            Id = $obj.attr('data-id');
            if (Id) {
                url = site.formAction;
                data = {'_method': 'DELETE',
                    'identifier': site.tableIdentifier, 'id': Id}
                myFeedback = new Feedback();
                myFeedback.selector = $obj;
                myFeedback.type = 'removeRecord';
                myAjax = new Ajax();
                myAjax.hideBlockUI = false;
                myAjax.feedback = myFeedback;
                myAjax.send(url, data, "json", "POST");
            }
        }
    }
    // Trigger form submit for input search
    $('.dk-table-row-multiple-search :input[name="search[multiple]"]').keyup(function (e) {
        $elem = $(this);
        if (e.keyCode == 13) {
            $form = $elem.parent().parent().parent().parent().parent().parent().parent();
            $form.trigger('submit');
        }
    })

    $('.dk-table-row-search :input[name^="search"]').keyup(function (e) {
        $elem = $(this);
        if (e.keyCode == 13) {
            $form = $elem.parent().parent().parent().parent().parent().parent();
            $form.trigger('submit');
        }
    })
})