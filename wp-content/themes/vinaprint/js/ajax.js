jQuery(document).ready(function(){
    // register change select atrributes
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
function calculateTablePrice(){
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