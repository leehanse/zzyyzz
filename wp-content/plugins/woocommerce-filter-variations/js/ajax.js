jQuery(document).ready(function(){
	jQuery('#product_filter_variation_button').click(function(){
		adminFilterProductVariations();
	});
});
function adminFilterProductVariations(){
    if(window.ajaxAdminFilterProductVariations !== undefined){
        window.ajaxAdminFilterProductVariations.abort();
    }
    var data = jQuery('#product_filter_variations_wrapper').find('input[name],select[name],textarea[name]').serializeArray();
    data.push({
    	name : "action",
    	value: productFilterVariationAjax.action
    });

	jQuery('.woocommerce_variations').block({
		message: null,
		overlayCSS: {
			background: '#fff url(' + woocommerce_admin_meta_boxes_variations.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center',
			opacity: 0.6
		}
	});

    window.ajaxAdminFilterProductVariations = jQuery.ajax({
        url : productFilterVariationAjax.ajaxurl,
        data: data,
        type: 'post',
        success: function(response){        	
            jQuery('.woocommerce_variations').unblock();
            jQuery('.woocommerce_variations .woocommerce_variation').remove();
            jQuery('.woocommerce_variations #product_filter_variations_wrapper').after(response);
            jQuery('.woocommerce_variations .woocommerce_variable_attributes').hide();
            jQuery('.woocommerce_variation .options input[type="checkbox"]').change();
        }
    });
}