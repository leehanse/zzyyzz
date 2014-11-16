jQuery(document).ready(function() {
    jQuery(document).on('keydown', '.number-field', function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }).on('keyup', '.product-addons-field-width', function() {
        var pdiv = jQuery(this).parent('.product-addon');
        var width = jQuery(this).val();
        var height_input = pdiv.find('.product-addons-field-height');
        var hidden_input = pdiv.find('.product-addons-field');
        var height = height_input.val();
        if (width && height) {
            hidden_input.val(width + 'x' + height);
        } else {
            hidden_input.val('');
        }
        var qty = jQuery('.qty').val() * 1;
        if (qty == 0) qty = 1;
        calculateTablePrice(qty);

    }).on('keyup', '.product-addons-field-height', function() {
        var pdiv = jQuery(this).parent('.product-addon');
        var height = jQuery(this).val();
        var width_input = pdiv.find('.product-addons-field-width');
        var hidden_input = pdiv.find('.product-addons-field');
        var width = width_input.val();
        if (width && height) {
            hidden_input.val(width + 'x' + height);
        } else {
            hidden_input.val('');
        }
        var qty = jQuery('.qty').val() * 1;
        if (qty == 0) qty = 1;
        calculateTablePrice(qty);
    });;

});