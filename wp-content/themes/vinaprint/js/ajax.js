jQuery(document).ready(function(){
    calculateTablePrice();
    if(jQuery('.product-addons-field').size() >0){
        jQuery('.product-addons-field').change(function(){
            var qty = jQuery('.qty').val() * 1;
            if(qty == 0) qty = 1;
            calculateTablePrice(qty);
        });
    }
    jQuery('.qty').change(function(){
        calculateTablePrice(jQuery(this).val());
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