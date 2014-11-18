jQuery(document).ready(function(){
    // register change select atrributes
    jQuery(".number-field").keydown(function (e) {
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
    });
    jQuery('.product-addons-field-width').keyup(function(){
       var w_tag  = jQuery(this);
       var wh_tag = w_tag.prev();        
       var h_tag  = w_tag.next();
       
       var w = w_tag.val() * 1;
       var h = h_tag.val() * 1;
       if(w && h){
           wh_tag.val(w+'x'+h);
           calculateTablePrice();
       }
    });
    jQuery('.product-addons-field-height').keyup(function(){
       var w_tag  = jQuery(this).prev();
       var wh_tag = w_tag.prev();        
       var h_tag  = w_tag.next();
       
       var w = w_tag.val() * 1;
       var h = h_tag.val() * 1;
       if(w && h){
           wh_tag.val(w+'x'+h);
           calculateTablePrice();
       }
    });
    
    jQuery('form.cart .attribute_field select').change(function(){
        calculateTablePrice();        
    })

    jQuery('form.cart .product-addons-field').change(function(){
        calculateTablePrice();
    });
    jQuery('.qty').keyup(function(){
        jQuery(this).change();
    });
    jQuery('.qty').change(function(){
        calculateTablePrice();
    });
    jQuery(document).on('click','.table-cell-price', function(){
        var chk_price = jQuery(this).find('.chk-table-price');
        jQuery('.chk-table-price').prop("checked",false);
        jQuery('.table-cell-price-select').removeClass('table-cell-price-select');
        
        chk_price.parent('td').addClass('table-cell-price-select');
        chk_price.prop("checked",true);        
        
        var map_field_name  = chk_price.data('map-field-name');
        var map_field_value = chk_price.data('map-field-value');
        jQuery('* [name="'+map_field_name+'"]').val(map_field_value);
        
        getVariationId();
        
        //jQuery('.product-addons-field-last .product-addons-field').val(chk_price.data('price'));
        jQuery('#target_quantity').val(chk_price.data('qty'));
        
    }).on('click','.custom-add-to-cart-button', function(){
        if(jQuery('.chk-table-price:checked').size() > 0){
            jQuery('form.cart').submit();
        }else{
            alert('Please choose price to continue...');
        }
    });
    calculateTablePrice();
});

if(Array.prototype.diff === undefined){
    Array.prototype.diff = function(a) {
        return this.filter(function(i) {return a.indexOf(i) < 0;});
    };
}

function getVariationId(){
    var selectAttributes    = jQuery('.cart .attribute_field select').serializeArray();
    if(selectAttributes.length){
        var arrSelectAttributes = {};
        for(i=0; i< selectAttributes.length; i++){
            var item = selectAttributes[i];
            arrSelectAttributes[item.name] = item.value;
        }
        var product_variations = jQuery('.cart').data('product_variations');
        if(product_variations.length){
            for(i = 0; i< product_variations.length; i++){
                var attributes   = product_variations[i].attributes;
                var variation_id = product_variations[i].variation_id;
                if(JSON.stringify(arrSelectAttributes) === JSON.stringify(attributes)){
                    jQuery('input[name="variation_id"]').val(variation_id);                
                    return false;
                } 
            }
        }
        jQuery('input[name="variation_id"]').val('');
    }
}
function calculateTablePrice(){
    getSelectAddonMetaData();
    var qty             = jQuery('.qty').val() * 1;
    if(qty == 0){
      qty = 1;  
    }

    var data            = [];
    var data_attributes = jQuery('form.cart .attribute_field select').serializeArray();
    var data_addons     = jQuery('form.cart .product-addons-field').serializeArray();

    for(i = 0; i< data_attributes.length; i++){
        data_attributes[i].name = "attributes[" + data_attributes[i].name+"]";
        data.push(data_attributes[i]);
    }

    for(i = 0; i< data_addons.length; i++){
        if(data_addons[i].name.indexOf('[]') != -1){
            var tmp_name = data_addons[i].name.replace('[]','');
            data_addons[i].name = "addons[" + tmp_name +"][]";
        }else{
            data_addons[i].name = "addons[" + data_addons[i].name+"]";
        }
        data.push(data_addons[i]);
    }

    data.push({
        name: 'action',
        value: 'calculateTablePrice',        
    });

    data.push({
       name:  'product_id',
       value: jQuery("#product_id_hidden").val()
    });

    data.push({
        name: 'qty',
        value: qty,        
    });

    jQuery('.vinaprint_table_price').html('<div class="loader">Loading...</div>');
    if(window.ajaxCalculatePrice !== undefined){
        window.ajaxCalculatePrice.abort();
    }

    window.ajaxCalculatePrice = jQuery.ajax({
        url : vinaprintAjax.ajaxurl,
        data: data,
        type: 'post',
        success: function(response){
            jQuery('.vinaprint_table_price').html(response);
        }
    });
}
function getSelectAddonMetaData(){
    var qty             = jQuery('.qty').val() * 1;
    if(qty == 0){
      qty = 1;  
    }    
    var data            = [];
    var data_addons     = jQuery('form.cart .product-addons-field').serializeArray();

    for(i = 0; i< data_addons.length; i++){
        if(data_addons[i].name.indexOf('[]') != -1){
            var tmp_name = data_addons[i].name.replace('[]','');
            data_addons[i].name = "addons[" + tmp_name +"][]";
        }else{
            data_addons[i].name = "addons[" + data_addons[i].name+"]";
        }
        data.push(data_addons[i]);
    }

    data.push({
        name: 'action',
        value: 'getWidthHeightPrice',        
    });

    data.push({
       name:  'product_id',
       value: jQuery("#product_id_hidden").val()
    });

    data.push({
        name: 'qty',
        value: qty,        
    });
    
    if(window.ajaxGetSelectAddonMetaData !== undefined){
        window.ajaxGetSelectAddonMetaData.abort();
    }

    window.ajaxGetSelectAddonMetaData = jQuery.ajax({
        url : vinaprintAjax.ajaxurl,
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(response){
            if(response.length){
                for(i=0;i<response.length;i++){
                    var addition_addon = response[i].addition_info;
                    var sanitize_title = response[i].sanitize_title;
                    var addon_type     = response[i].addon_type;
                    if(addition_addon){
                        if(addon_type == 'width_height'){
                            jQuery('.addon-' + sanitize_title + '-addition-info').html(addition_addon);
                        }
                    }
                }
            }
        }
    });    
}