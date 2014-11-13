jQuery(document).ready(function(){
    calculateTablePrice();
    if(jQuery('.product-addons-field').size() >0){
        jQuery('.product-addons-field-height').change(function(){
            var qty = jQuery('.qty').val() * 1;
            if(qty == 0) qty = 1;
            calculateTablePrice(qty);
        });

        jQuery('.product-addons-field-width').change(function(){
            var qty = jQuery('.qty').val() * 1;
            if(qty == 0) qty = 1;
            calculateTablePrice(qty);
        });
        jQuery('.product-addons-field').change(function(){
            var qty = jQuery('.qty').val() * 1;
            if(qty == 0) qty = 1;
            calculateTablePrice(qty);
        });
    }
    jQuery('.qty').change(function(){
        calculateTablePrice(jQuery(this).val());
    });
    jQuery(document).on('click','.table-cell-price', function(){
        var slt_price = jQuery(this).find('.slt-table-price');
        jQuery('.slt-table-price').prop("checked",false);
        jQuery('.table-cell-price-select').removeClass('table-cell-price-select');
        
        slt_price.parent('td').addClass('table-cell-price-select');
        slt_price.prop("checked",true);        
        
        jQuery('.product-addons-field-last .product-addons-field').val(slt_price.data('price'));
        jQuery('#target_quantity').val(slt_price.data('qty'));
        
    }).on('click','.custom-add-to-cart-button', function(){
        if(jQuery('.slt-table-price:checked').size() > 0){
            jQuery('form.cart').submit();
        }else{
            alert('Please choose price to continue...');
        }
    });
    
});
function calculateTablePrice(qty){
    var _data = jQuery('.cart').serializeArray();
    var data  = [];
    for(i=0; i<_data.length; i++){
        if(_data[i].name.indexOf('addon-') !== -1){
            data.push(_data[i]);
        }
    }
    
    data.pop();
    
    data.push({
        name: 'action',
        value: 'calculateTablePrice',        
    });
    data.push({
       name:  'product_id',
       value: jQuery("#product_id_hidden").val()
    });
    if(qty !== undefined){
        data.push({
            name: 'qty',
            value: qty,        
        });
    }
    jQuery('.vinaprint_table_price').html('<div class="loader">Loading...</div>');
    jQuery.ajax({
        url : nemprintAjax.ajaxurl,
        data: data,
        type: 'post',
        success: function(response){
            jQuery('.vinaprint_table_price').html(response);
        }
    });
}