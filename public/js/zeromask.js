function ZeroMask(options) {
    defaultOptions = {
        // Selector
        selector: null,
        // Type
        type: null,
    }
    parameters = $.extend({}, defaultOptions, options);
    instance = this;
    $.each(defaultOptions, function (index, property) {
        instance[index] = parameters[index];
    })
    instance.init();
}

ZeroMask.prototype = {
    // Current selector
    current: null,
    addChar: function (me) {
        value = me.current.val();
        var start = me.this.selectionStart;
        var arr = value.split("");
        // If input is empty
        if (!arr.length) {
            return me.e.key;
        }
        var result = [];
        // Add character start
        if (start == 0) {
            result.push(me.e.key);
        }
        for (var i = 0; i < arr.length; i++) {
            if (i == start && !(i == 0)) {
                // Add character middle
                result.push(me.e.key);
                result.push(arr[i]);
            } else {
                result.push(arr[i]);
            }
        }
        // Add character end
        if (arr.length == start) {
            result.push(me.e.key);
        }
        return result.join("");
    },
    removeChar: function (me) {
        value = me.current.val();
        var start = me.start;
        var arr = value.split("");
        // If input is empty
        if (!arr.length) {
            return "";
        }
        indexChar = start - 1;
        if (arr[indexChar] == ".") {
            return false;
        }
        var result = [];
        for (var i = 0; i < arr.length; i++) {
            var counter = i + 1;
            if (counter != start) {
                result.push(arr[i]);
            }
        }
        var result = result.join("");
        var resultNoSeparators = result.replace(/\./gi, "");
        if (resultNoSeparators.length >= 1) {
            result = (parseInt(resultNoSeparators) == 0) ? value : result;
        }
        return result;
    },
    addThousandSeparator: function (me) {
        length = value.length;
        if (length > 3) {
            var arr = value.split("");
            arr = arr.reverse();
            var result = [];
            for (var i = 0; i < arr.length; i++) {
                var counter = i + 1;
                result.push(arr[i]);
                if (counter % 3 == 0 && counter != arr.length) {
                    result.push(".");
                }
            }
            result = result.reverse();
            me.current.val(result.join(""));
        } else {
            var result = value;
            me.current.val(value);
        }
        return result;
    },
    types: {
        number: function (me) {
            value = me.current.val();
            prevLength = value.length;
            if (me.e.keyCode == 39 || me.e.keyCode == 37) {
                return true;
            }
            // Not Backspace
            if (me.e.keyCode != 8) {
                // Restrict input if character is not number
                if (isNaN(me.e.key)) {
                    me.e.preventDefault();
                    return;
                }
                // Restrict input if first character 0
                if (parseInt(value) == 0) {
                    me.e.preventDefault();
                    return;
                }
                // Add character to specific position
                value = me.addChar(me);
            }
            // Backspace functionality
            if (me.e.keyCode == 8) {
                // Add character to specific position
                result = me.removeChar(me);
                value = (typeof (result) == "boolean" && result == false) ? value : result;
                if (typeof (result) == "boolean" && result == false) {
                    var isDotChar = true;
                }
            }
            // Remove separator character
            value = value.replace(/\./gi, "");
            // Add thousand separator
            var result = me.addThousandSeparator(me);
            var currLength = result.length;
            var position = me.start + (currLength - prevLength);
            if (isDotChar) {
                position = me.start - 1;
            }
            me.this.setSelectionRange(position, position);
            me.e.preventDefault();
        }
    },
    mask: function (e) {
        $elem = $(this);
        me = e.data.me;
        // Set current selector
        me.current = $elem;
        // Set event
        me.e = e;
        me.this = this;
        me.start = this.selectionStart;
        // Call mask method
        var method = me.type;
        me.types[method](me);
    },
    unmask: function () {
        $(this.selector).each(function (key, input) {
            value = $(input).val();
            value = value.replace(/\./gi, "");
            $(input).val(value);
        })
    },
    destroy: function () {
        this.selector.unbind('keydown');
        this.selector.unbind('keypress');
    },
    init: function () {
        // Attach Event Handler keydown to selector
        this.selector.keydown({me: this}, this.mask);
        // Attach Event Handler keypress to selector
        this.selector.keypress({me: this}, this.mask);
        $(this.selector).each(function (key, input) {
            $(input).attr('autocomplete', 'off');
        })
        return this;
    },
}