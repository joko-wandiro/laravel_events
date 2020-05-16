function ZeroValidation(options) {
    defaultOptions = {
        // Selector
        selector: null,
        // Template
        rules: null,
        // Message
		messages: {
			required: 'The :attribute field is required.',
			number: 'The :attribute must be a number.',
			stock: 'The :attribute may not be greater than stock.',
		},
		addons: null,
    }
    parameters = $.extend({}, defaultOptions, options);
    instance = this;
    $.each(defaultOptions, function (index, property) {
        instance[index] = parameters[index];
    })
    instance.init();
}

ZeroValidation.prototype = {
	errors: {},
	valid: true,
	getLength: function(value){
		return value.length;
	},
	getValue: function(elem){
		return $(elem).val();
	},
	getInputs: function(name){
		name= name.replace(/\*/, '\\d+');
		name= name.replace(/\[/g, '\\[');
		name= name.replace(/\]/g, '\\]');
		regex= new RegExp('^' + name + '$');
		$inputs= $(':input', this.selector).not(':button');
		$elems= [];
		$.each($inputs, function (index, element) {
			if( regex.test(element.name) ){
				$elems.push(element);
			}
		});
		return $elems;
	},
	methods: {
		required: function(elem){
			var me= elem.me;
			return (me.getLength(me.getValue(elem)) > 0) ? true : false;
		},
		number: function(elem){
			var me= elem.me;
			regex= new RegExp('^\\d+$');
			return ( regex.test(me.getValue(elem)) ) ? true : false;				
		},
		stock: function(elem){
			var me= elem.me;
			me.selector= elem;
			stock= me.addons[elem.ruleValue](me);
			value= me.getValue(elem);
			value= value.replace(/\./gi, "");
			return ( value <= stock ) ? true : false;
		}
	},
    validate: function () {
    	$('.zv-error').remove();
    	var me= this;
    	me.errors= {};
    	me.valid= true;
	    $.each(this.rules, function (index, rule) {
	    	$inputs= me.getInputs(index);
	    	label= rule.label;
	    	delete rule.label;
	    	$.each($inputs, function (key, input) {
	    		errors= [];
				$.each(rule, function (property, value) {
					var isValidate= false;
					// Is required validation
					if( property == "required" ){
						isValidate= true;
					}else{
						// Is optional
						if( me.rules[index].required ){
							isValidate= true;
						}else{
							// Verify length
							if( me.getLength(me.getValue(input)) > 1 ){
								isValidate= true;
							}
						}
					}
					if( isValidate ){
						input.me= me;
						input.ruleProperty= property;
						input.ruleValue= value;
						if( ! me.methods[property](input) ){
							errors.push(property);
							me.valid= false;
						}
					}
				});
				if( errors.length ){
					me.errors[input.name]= {};
					me.errors[input.name].label= label;
					me.errors[input.name].errors= errors;
				}
	    	});
	    })
    	$.each(me.errors, function (input, properties) {
			$.each(properties.errors, function (key, property) {
				var message= me.messages[property];
				message= message.replace(/\:attribute/, properties.label);
				$span= $('<label class="error zv-error"/>');
				$span.html(message);
				$(':input[name="'+input+'"]').after($span);
			});
		});
    },
    init: function(){
		this.validate();
	}
}