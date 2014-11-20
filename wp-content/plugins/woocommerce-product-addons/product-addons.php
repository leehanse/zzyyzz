<?php
/*
Plugin Name: WooCommerce Product Add-ons
Plugin URI: http://facebook.com/mr_leehanse
Description: WooCommerce Product Add-ons
Version: 1.1
Author: Cong Ngo
Author URI: http://facebook.com/mr_leehanse
Requires at least: 3.1
Tested up to: 3.2
*/

/**
 * Required functions
 **/
if ( ! function_exists( 'is_woocommerce_active' ) ) require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 **/
if (is_admin()) {
	$woo_plugin_updater_product_addons = new WooThemes_Plugin_Updater( __FILE__ );
	$woo_plugin_updater_product_addons->api_key = '425a1db6e55f69136a0eb2a008dec364';
	$woo_plugin_updater_product_addons->init();
}
		
if (is_woocommerce_active()) {
	
	/**
	 * Localisation
	 **/
	load_plugin_textdomain('wc_product_addons', false, dirname( plugin_basename( __FILE__ ) ) . '/');
	
	/**
	 * woocommerce_product_addons class
	 **/
	if (!class_exists('woocommerce_product_addons')) {
	 
		class woocommerce_product_addons {
			
			var $settings;
			
			public function __construct() { 
				
				// Addon display
				add_action( 'woocommerce_before_add_to_cart_button', array(&$this, 'product_addons'), 10 );
				
				// Filters for cart actions
				add_filter( 'woocommerce_add_cart_item_data', array(&$this, 'add_cart_item_data'), 10, 2 );
				add_filter( 'woocommerce_get_cart_item_from_session', array(&$this, 'get_cart_item_from_session'), 10, 2 );
				add_filter( 'woocommerce_get_item_data', array(&$this, 'get_item_data'), 10, 2 );
				add_filter( 'woocommerce_add_cart_item', array(&$this, 'add_cart_item'), 10, 1 );
				add_action( 'woocommerce_order_item_meta', array(&$this, 'order_item_meta'), 10, 2 );
				add_filter( 'woocommerce_add_to_cart_validation', array(&$this, 'validate_add_cart_item'), 10, 3 );
				
				// Write Panel
				add_action('woocommerce_admin_css', array(&$this, 'meta_box_css'));
				add_action('add_meta_boxes', array(&$this, 'add_meta_box'));
				add_action('woocommerce_process_product_meta', array(&$this, 'process_meta_box'), 1, 2);
				
		    } 
		    
		    /*-----------------------------------------------------------------------------------*/
			/* Write Panel */
			/*-----------------------------------------------------------------------------------*/ 
		    
		    function add_meta_box() {
		    	add_meta_box( 'woocommerce-product-addons', __('Product Add-ons', 'wc_product_addons'), array(&$this, 'meta_box'), 'product', 'normal', 'default' );
		    }
		    
		    function meta_box_css() {
		    	global $typenow;
		    	
		    	if ($typenow=='product') wp_enqueue_style( 'woocommerce_product_addons_css', plugins_url(basename(dirname(__FILE__))) . '/css/admin.css' );
		    }
		    
		    
		    function meta_box( $post ) {
                            $products = get_posts(array( 'post_type' => 'product', 'posts_per_page' => -1 ));
				?>
				<div id="product_addons" class="panel">
                                        <p style="text-align: right;" class="action-all">
                                            <a class="action-minus button" href="javascript:void(0);">Hide all options</a>
                                            <a class="action-plus button" href="javascript:void(0);">Show all options</a>
                                        </p>    
					<div class="woocommerce_addons">
						<?php
						$product_addons = get_post_meta( $post->ID, '_product_addons', true );

						$loop = 0;
						
						if (is_array($product_addons) && sizeof($product_addons)>0) foreach ($product_addons as $addon) :
							
							if (!$addon['name']) continue;
							if (!isset($addon['required'])) $addon['required'] = 0;
							
							?><div class="woocommerce_addon">
								<p class="addon_name">
									<label class="hidden"><?php _e('Name:', 'wc_product_addons'); ?></label>
									<input type="text" name="addon_name[<?php echo $loop; ?>]" placeholder="<?php _e('Name', 'wc_product_addons'); ?>" value="<?php echo esc_attr($addon['name']); ?>" />
									<input type="hidden" name="addon_position[<?php echo $loop; ?>]" class="addon_position" value="<?php echo $loop; ?>" />
								</p>
								<p class="addon_type">
									<label class="hidden"><?php _e('Type:', 'wc_product_addons'); ?></label>
									<select name="addon_type[<?php echo $loop; ?>]">
										<option <?php selected('select', $addon['type']); ?> value="select"><?php _e('Select box', 'wc_product_addons'); ?></option>
										<option <?php selected('checkbox', $addon['type']); ?> value="checkbox"><?php _e('Checkboxes', 'wc_product_addons'); ?></option>
                                                                                <option <?php selected('width_height', $addon['type']); ?> value="width_height"><?php _e('Width x Height', 'wc_product_addons'); ?></option>
									</select>
								</p>
								<p class="addon_description">
									<label class="hidden"><?php _e('Description:', 'wc_product_addons'); ?></label>
									<input type="text" name="addon_description[<?php echo $loop; ?>]" placeholder="<?php _e('Description', 'wc_product_addons'); ?>" value="<?php echo esc_attr($addon['description']); ?>" />
								</p>
                                <div class="addon-other-options">
                                    <p class="field-option addon_required">
                                        <label><input type="checkbox" name="addon_required[<?php echo $loop; ?>]" <?php checked($addon['required'], 1) ?> /> <?php _e('Required field', 'wc_product_addons'); ?></label>
                                    </p>
                                    <p class="field-option price_instance">                                    	
                                        <label>Price increase</label>
                                        <select name="addon_price_type[<?php echo $loop; ?>]">
                                            <option <?php selected('x', $addon['price_type']); ?> value="x"><?php _e('Multiply with Qty', 'wc_product_addons'); ?></option>
                                            <option <?php selected('+', $addon['price_type']); ?> value="+"><?php _e('Add to item price', 'wc_product_addons'); ?></option>
                                        </select>
                                    </p>
                                    <p class="field-option price_instance">                                    	
                                        <label>Default added price:</label>
                                        <input style="width:50px;" type="text" name = "addon_price_added_default[<?php echo $loop; ?>]" value="<?php echo $addon["price_added_default"];?>"/>
                                    </p>
                                    <p class="field-option field-option-width_height" style="<?php if($addon['type'] != 'width_height') echo 'display:none;';?>">
                                        <label>Input unit</label>
                                        <select name="addon_wh_input_unit[<?php echo $loop; ?>]">
                                            <option <?php selected('cm', $addon['wh_input_unit']); ?> value="cm"><?php _e('cm', 'wc_product_addons'); ?></option>
                                            <option <?php selected('m', $addon['wh_input_unit']); ?> value="m"><?php _e('m', 'wc_product_addons'); ?></option>
                                        </select>
                                    </p>   
                                    <p class="field-option field-option-width_height" style="<?php if($addon['type'] != 'width_height') echo 'display:none;';?>">
                                        <label>Option price unit</label>
                                        <select name="addon_wh_option_price_unit[<?php echo $loop; ?>]">
                                            <option <?php selected('cm', $addon['wh_option_price_unit']); ?> value="cm"><?php _e('cm&sup2;', 'wc_product_addons'); ?></option>
                                            <option <?php selected('m', $addon['wh_option_price_unit']); ?> value="m"><?php _e('m&sup2;', 'wc_product_addons'); ?></option>
                                        </select>
                                    </p>
                                    <p class="field-option field-option-width_height" style="<?php if($addon['type'] != 'width_height') echo 'display:none;';?>">
                                        <label>Default value (ex: 100x100)</label>
                                        <input type="text" name="addon_wh_default_value[<?php echo $loop; ?>]" value="<?php echo $addon['wh_default_value'];?>" style="line-height: 23px;width:80px;"/>
                                    </p>
                                </div>                                                                
                                <p class="actions-options">
                                    <a class="action-minus" href="javascript:void(0);">Hide options</a>
                                    <a class="action-plus" href="javascript:void(0);">Show options</a>
                                </p>
								<table cellpadding="0" cellspacing="0" class="woocommerce_addon_options">
									<thead>
	                                    <tr>
	                                        <th><?php _e('Label/Value/(cm&sup2;,m&sup2;):', 'wc_product_addons'); ?></th>
	                                        <th><?php _e('Price (or Price/cm&sup2;,m&sup2;)', 'wc_product_addons'); ?></th>
	                                        <th width="1%" class="actions">
	                                            <button type="button" class="add_addon_option button"><?php _e('Add', 'wc_product_addons'); ?></button>                                                                                            
	                                        </th>
	                                    </tr>
									</thead>
									<tbody>	
										<?php
										foreach ($addon['options'] as $option) :
											?>
											<tr>
												<td><input type="text" name="addon_option_label[<?php echo $loop; ?>][]" value="<?php echo esc_attr($option['label']) ?>" placeholder="<?php _e('Label', 'wc_product_addons'); ?>" /></td>
												<td><input type="text" name="addon_option_price[<?php echo $loop; ?>][]" value="<?php echo esc_attr($option['price']) ?>" placeholder="0.00" /></td>
												<td class="actions"><button type="button" class="remove_addon_option button">x</button></td>
											</tr>
											<?php
										endforeach;
										?>	
									</tbody>
								</table>
                                <div style="clear:both;">
                                    <span class="handle"><?php _e('&varr; Move', 'wc_product_addons'); ?></span>
                                    <a href="#" class="delete_addon"><?php _e('Delete add-on', 'wc_product_addons'); ?></a>
                                </div>
							</div><?php
							
							$loop++;
							 
						endforeach;
						?>
						
					</div>
					
					<h4>
						<a href="#" class="import button" tip="<?php _e('Import From Text', 'wc_product_addons'); ?>">Import From Text</a>						
						<a href="#" class="export button" tip="<?php _e('Export', 'wc_product_addons'); ?>">Export To Text</a>
						<select class="import-from-product" name="import_from_product">
                            <option value="">-- Import from product--</option>
                            <?php foreach($products as $p):?>
                                <?php if($post->ID != $p->ID):?>
                                    <option value="<?php echo $p->ID;?>"><?php echo $p->post_title;?></option>
                                <?php endif;?>
                            <?php endforeach;?>
						</select>
						<a href="#" class="add_new_addon"><?php _e('+ Add New Product Add-on', 'wc_product_addons'); ?></a>
					</h4>
					
					<textarea name="export_product_addon" class="export" cols="20" rows="5" readonly="readonly"><?php echo esc_textarea( serialize($product_addons) ); ?></textarea>
					<textarea name="import_product_addon" class="import" cols="20" rows="5" placeholder="<?php _e('Paste form data to import here then save the product. The imported fields will be appended.', 'wc_product_addons'); ?>"></textarea>
				</div>
				<script type="text/javascript">
				jQuery(function(){
                    jQuery('select[name="import_from_product"]').change(function(){
                        if(jQuery(this).val()){
                            jQuery('textarea[name="import_product_addon"]').val('');
                        }
                    });
                    jQuery('textarea[name="import_product_addon"]').change(function(){
                        if(jQuery(this).val()){
                            jQuery('select[name="import_from_product"]').val('');
                        }
                    });
					jQuery('#product_addons').on('click', 'a.add_new_addon', function(){
						
						var loop = jQuery('.woocommerce_addons .woocommerce_addon').size();
						
						jQuery('.woocommerce_addons').append('<div class="woocommerce_addon">\
							<p class="addon_name">\
								<label class="hidden"><?php _e('Name:', 'wc_product_addons'); ?></label>\
								<input type="text" name="addon_name[' + loop + ']" placeholder="<?php _e('Name', 'wc_product_addons'); ?>" />\
								<input type="hidden" name="addon_position[' + loop + ']" class="addon_position" value="' + loop + '" />\
							</p>\
							<p class="addon_type">\
								<label class="hidden"><?php _e('Type:', 'wc_product_addons'); ?></label>\
								<select name="addon_type[' + loop + ']">\
									<option value="select"><?php _e('Select box', 'wc_product_addons'); ?></option>\
                                                                        <option value="checkbox"><?php _e('Checkboxes', 'wc_product_addons'); ?></option>\
                                                                        <option value="width_height"><?php _e('Width x Height', 'wc_product_addons'); ?></option>\
								</select>\
							</p>\
							<p class="addon_description">\
								<label class="hidden"><?php _e('Description:', 'wc_product_addons'); ?></label>\
								<input type="text" name="addon_description[' + loop + ']" placeholder="<?php _e('Description', 'wc_product_addons'); ?>" />\
							</p>\
                                <div class="addon-other-options">\
                                    <p class="addon_required">\
                                            <label><input type="checkbox" name="addon_required[' + loop + ']" /> <?php _e('Required field', 'wc_product_addons'); ?></label>\
                                    </p>\
                                    <p class="price_instance">\
                                        <label>Price increase</label>\
                                        <select name="addon_price_type[' + loop + ']">\
                                            <option value="x"><?php _e('Multiply with Qty', 'wc_product_addons'); ?></option>\
                                            <option value="+"><?php _e('Add to item price', 'wc_product_addons'); ?></option>\
                                        </select>\
                                    </p>\
                                    <p class="field-option price_instance">\
                                        <label>Default added price:</label>\
                                        <input style="width:50px;" type="text" name = "addon_price_added_default['+loop+']" value="0"/>\
                                    </p>\
                                    <p class="field-option field-option-width_height" style="display:none">\
                                        <label>Input unit</label>\
                                        <select name="addon_wh_input_unit[' + loop + ']">\
                                            <option value="cm"><?php _e('cm', 'wc_product_addons'); ?></option>\
                                            <option value="m"><?php _e('m', 'wc_product_addons'); ?></option>\
                                        </select>\
                                    </p>\
                                    <p class="field-option field-option-width_height" style="display:none">\
                                        <label>Option price unit</label>\
                                        <select name="addon_wh_option_price_unit[' + loop + ']">\
                                            <option value="cm"><?php _e('cm&sup2;', 'wc_product_addons'); ?></option>\
                                            <option value="m"><?php _e('m&sup2;', 'wc_product_addons'); ?></option>\
                                        </select>\
                                    </p>\
                                    <p class="field-option field-option-width_height" style="display:none;">\
                                        <label>Default value (ex: 100x100)</label>\
                                        <input type="text" name="addon_wh_default_value[' + loop + ']" value="" style="line-height: 23px;width:80px;"/>\
                                    </p>\
                                </div>\
                                <p class="actions-options">\
                                    <a class="action-minus" href="javascript:void(0);">Hide options</a>\
                                    <a class="action-plus" href="javascript:void(0);">Show options</a>\
                                </p>\
                                <table cellpadding="0" cellspacing="0" class="woocommerce_addon_options">\
								<thead>\
									<tr>\
										<th><?php _e('Label/Value/(cm&sup2;,m&sup2;):', 'wc_product_addons'); ?></th>\
										<th><?php _e('Price (or Price/cm&sup2;,m&sup2;):', 'wc_product_addons'); ?></th>\
										<th width="1%" class="actions"><button type="button" class="add_addon_option button"><?php _e('Add', 'wc_product_addons'); ?></button></th>\
									</tr>\
								</thead>\
								<tbody>\
									<tr>\
										<td><input type="text" name="addon_option_label[' + loop + '][]" value="<?php ?>" placeholder="<?php _e('Label', 'wc_product_addons'); ?>" /></td>\
										<td><input type="text" name="addon_option_price[' + loop + '][]" value="<?php ?>" placeholder="0.00" /></td>\
										<td class="actions"><button type="button" class="remove_addon_option button">x</button></td>\
									</tr>\
								</tbody>\
							</table>\
                            <div style="clear:both;">\
                                <span class="handle"><?php _e('&varr; Move', 'wc_product_addons'); ?></span>\
                                <a href="#" class="delete_addon"><?php _e('Delete add-on', 'wc_product_addons'); ?></a>\
                            </div>\
						</div>');
						
						return false;
						
					});
	                jQuery('.action-all .action-minus').live('click', function(){
	                    jQuery('.actions-options .action-minus').hide();
	                    jQuery('.actions-options .action-plus').show();
	                    jQuery('#product_addons .woocommerce_addon').find('.woocommerce_addon_options').hide();                                            
	                });
	                jQuery('.action-all .action-plus').live('click', function(){
	                    jQuery('.actions-options .action-minus').show();
	                    jQuery('.actions-options .action-plus').hide();
	                    jQuery('#product_addons .woocommerce_addon').find('.woocommerce_addon_options').show();
	                });
                                        
					jQuery('.actions-options .action-minus').live('click', function(){
                        jQuery(this).hide();
                        jQuery(this).next('.action-plus').show();
                        jQuery(this).parents('.woocommerce_addon').find('.woocommerce_addon_options').slideUp();
                    });
                    jQuery('.actions-options .action-plus').live('click', function(){
                        jQuery(this).hide();
                        jQuery(this).prev('.action-minus').show();
                        jQuery(this).parents('.woocommerce_addon').find('.woocommerce_addon_options').slideDown();
                    });
                                        
                    jQuery('.addon_type select').live('change', function(){
                        if(jQuery(this).val() != 'width_height'){
                            jQuery(this).parents('.woocommerce_addon').find('.field-option-width_height').hide();
                        }else{
                            jQuery(this).parents('.woocommerce_addon').find('.field-option-width_height').show();
                        }
                    });
                                        
					jQuery('button.add_addon_option').live('click', function(){
						
						var loop = jQuery(this).closest('.woocommerce_addon').index('.woocommerce_addon');
						
						jQuery(this).closest('.woocommerce_addon_options').find('tbody').append('<tr>\
							<td><input type="text" name="addon_option_label[' + loop + '][]" placeholder="<?php _e('Label', 'wc_product_addons'); ?>" /></td>\
							<td><input type="text" name="addon_option_price[' + loop + '][]" placeholder="0.00" /></td>\
							<td class="actions"><button type="button" class="remove_addon_option button">x</button></td>\
						</tr>');
						
						return false;
			
					});
					
					jQuery('button.remove_addon_option').live('click', function(){
					
						var answer = confirm('<?php _e('Are you sure you want delete this add-on item?', 'wc_product_addons'); ?>');
			
						if (answer) {
							jQuery(this).closest('tr').remove();
						}
						
						return false;
			
					});
					
					jQuery('a.delete_addon').live('click', function(){
					
						var answer = confirm('<?php _e('Are you sure you want delete this add-on?', 'wc_product_addons'); ?>');
			
						if (answer) {
							var addon = jQuery(this).closest('.woocommerce_addon');
							jQuery(addon).find('input').val('');
							jQuery(addon).hide();
						}
						
						return false;
			
					});
					
					jQuery('.woocommerce_addon table.woocommerce_addon_options tbody').sortable({
						items:'tr',
						cursor:'move',
						axis:'y',
						scrollSensitivity:40,
						helper:function(e,ui){
							ui.children().each(function(){
								jQuery(this).width(jQuery(this).width());
							});
							return ui;
						},
						start:function(event,ui){
							ui.item.css('background-color','#f6f6f6');
						},
						stop:function(event,ui){
							ui.item.removeAttr('style');
						}
					});
					
					jQuery('.woocommerce_addons').sortable({
						items:'.woocommerce_addon',
						cursor:'move',
						axis:'y',
						handle:'.handle',
						scrollSensitivity:40,
						helper:function(e,ui){
							ui.children().each(function(){
								jQuery(this).width(jQuery(this).width());
							});
							return ui;
						},
						start:function(event,ui){
							ui.item.css('border-style','dashed');
						},
						stop:function(event,ui){
							ui.item.removeAttr('style');
							addon_row_indexes();
						}
					});
					
					function addon_row_indexes() {
						jQuery('.woocommerce_addons .woocommerce_addon').each(function(index, el){ jQuery('.addon_position', el).val( parseInt( jQuery(el).index('.woocommerce_addons .woocommerce_addon') ) ); });
					};
					
					jQuery('#product_addons').on('click', 'a.export', function() {
						
						jQuery('#product_addons textarea.import').hide();
						jQuery('#product_addons textarea.export').slideToggle('500', function() {
							jQuery(this).select();
						});
						
						return false;
					});
					
					jQuery('#product_addons').on('click', 'a.import', function() {
						
						jQuery('#product_addons textarea.export').hide();
						jQuery('#product_addons textarea.import').slideToggle('500', function() {
							jQuery(this).val('');
						});
						
						return false;
					});
					
				});
				</script>
		    	<?php
		    }
		    
		    function process_meta_box( $post_id, $post ) {
		    	
		    	// Save addons as serialised array
				$product_addons = array();
				
				if (isset($_POST['addon_name'])) :
					 $addon_name		= $_POST['addon_name'];
					 $addon_description	= $_POST['addon_description'];
					 $addon_type 		= $_POST['addon_type'];
					 $addon_option_label	= $_POST['addon_option_label'];
					 $addon_option_price	= $_POST['addon_option_price'];
					 $addon_position 	= $_POST['addon_position'];
					 $addon_required	= $_POST['addon_required'];

                                        $addon_price_type      = $_POST['addon_price_type'];
                                        $addon_price_added_default  = $_POST['addon_price_added_default'];

                                        $addon_wh_input_unit   = $_POST['addon_wh_input_unit'];
                                        $addon_wh_option_price_unit = $_POST['addon_wh_option_price_unit'];
                                        $addon_wh_default_value     = $_POST['addon_wh_default_value'];
                                         
					 for ($i=0; $i<sizeof($addon_name); $i++) :
					 	
					 	if (!isset($addon_name[$i]) || ('' == $addon_name[$i])) continue;

					 	// Meta
					 	$addon_options 			= array();
					 	$option_label 			= $addon_option_label[$i];
					 	$option_price 			= $addon_option_price[$i];
					 	$price_type                     = $addon_price_type[$i];
                                                $price_added_default            = $addon_price_added_default[$i];                                                
                                                $wh_input_unit                  = $addon_wh_input_unit[$i];
                                                $wh_option_price_unit           = $addon_wh_option_price_unit[$i];
                                                $wh_default_value               = $addon_wh_default_value[$i];
						

					 	for ($ii=0; $ii<sizeof($option_label); $ii++) :
					 		$label = esc_attr(stripslashes($option_label[$ii]));
					 		$price = esc_attr(stripslashes($option_price[$ii]));

				 			$addon_options[] = array(
				 				'label' => $label,
				 				'price' => $price
				 			);

					 	endfor;
					 	
					 	if (sizeof($addon_options)==0) continue; // Needs options
					 	
					 	// Add to array	 	
					 	$product_addons[] = array(
                                                    'name' 			=> esc_attr(stripslashes($addon_name[$i])),
                                                    'description'           => esc_attr(stripslashes($addon_description[$i])),
                                                    'type' 			=> esc_attr(stripslashes($addon_type[$i])),
                                                    'position'		=> (int) $addon_position[$i],
                                                    'options' 		=> $addon_options,
                                                    'required'		=> (isset($addon_required[$i])) ? 1 : 0,
                                                    'price_type'        => $price_type, 
                                                    'price_added_default' => $price_added_default,
                                                    'wh_input_unit'     => $wh_input_unit,
                                                    'wh_option_price_unit' => $wh_option_price_unit,
                                                    'wh_default_value'  => $wh_default_value
					 	);
					 	
					 endfor; 
				endif;	
				
				if (!function_exists('addons_cmp')) {
					function addons_cmp($a, $b) {
					    if ($a['position'] == $b['position']) {
					        return 0;
					    }
					    return ($a['position'] < $b['position']) ? -1 : 1;
					}
				}
				uasort($product_addons, 'addons_cmp');
				
				if ($_POST['import_product_addon']) {
					$import_addons = maybe_unserialize(maybe_unserialize(stripslashes(trim( $_POST['import_product_addon'] ))));
					if (is_array($import_addons) && sizeof($import_addons)>0) {
						$valid = true;
						foreach ($import_addons as $addon) {
							if (!isset($addon['name']) || !$addon['name']) $valid = false;
							if (!isset($addon['description'])) $valid = false;
							if (!isset($addon['type'])) $valid = false;
							if (!isset($addon['position'])) $valid = false;
							if (!isset($addon['options'])) $valid = false;
							if (!isset($addon['required'])) $valid = false;
						}
						if ($valid) {
							// Append data
							$product_addons = array_merge( $product_addons, $import_addons );
						}
					}
				}elseif($_POST['import_from_product']){
                                    $import_addons = get_post_meta( $_POST['import_from_product'], '_product_addons', true );
                                    if (is_array($import_addons) && sizeof($import_addons)>0) {
                                        $valid = true;
                                        foreach ($import_addons as $addon) {
                                                if (!isset($addon['name']) || !$addon['name']) $valid = false;
                                                if (!isset($addon['description'])) $valid = false;
                                                if (!isset($addon['type'])) $valid = false;
                                                if (!isset($addon['position'])) $valid = false;
                                                if (!isset($addon['options'])) $valid = false;
                                                if (!isset($addon['required'])) $valid = false;
                                        }
                                        if ($valid) {
                                                // Append data
                                                $product_addons = array_merge( $product_addons, $import_addons );
                                        }
                                    }
                                }

				update_post_meta( $post_id, '_product_addons', $product_addons );
		
		    }
		    
		    
	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/ 
			
			function product_addons() {
				global $post;
				
				$product_addons = get_post_meta( $post->ID, '_product_addons', true );
				if (is_array($product_addons) && sizeof($product_addons)>0): ?>
                                            <?php foreach ($product_addons as $addon) : if (!isset($addon['name'])) continue; ?>
                                            <li class="product-addon product-addon-<?php echo sanitize_title($addon['name']); ?>"
                                                data-field="<?php echo esc_attr(json_encode($addon));?>">
                                                <?php if ($addon['name']) : ?>
                                                    <label class="field-title" <?php if(strlen(wptexturize($addon['name'])) > 25) echo 'style="font-size:11px;"';?>>
                                                        <?php echo wptexturize($addon['name']); ?>
                                                        <?php if ($addon['description']) : ?>
                                                            <span><?php echo wptexturize($addon['description']); ?></span>
                                                        <?php endif;?>
                                                    </label>
                                                <?php endif; ?>
                                                
                                                <?php
                                                switch ($addon['type']) :
                                                    case "checkbox" :
                                                        foreach ($addon['options'] as $option) :
                                                            $current_value = (
                                                                    isset($_POST['addon-'. sanitize_title( $addon['name'] )]) && 
                                                                    in_array(sanitize_title( $option['label'] ), $_POST['addon-'. sanitize_title( $addon['name'] )])
                                                                    ) ? 1 : 0;

                                                            //$price = ($option['price']>0) ? ' (+' . woocommerce_price($option['price']) . ')' : '';
                                                            $price = '';
                                                            echo '<label><input class="product-addons-field" data-price="'.$option['price'].'" type="checkbox" name="addon-'. sanitize_title( $addon['name'] ) .'[]" value="'. sanitize_title( $option['label'] ) .'" '.checked($current_value, 1, false).' /> '. wptexturize($option['label']) . $price .'</label>';
                                                        endforeach;
                                                    break;
                                                    case "select" :
                                                        $current_value = (isset($_POST['addon-'. sanitize_title( $addon['name'] )])) ? $_POST['addon-'. sanitize_title( $addon['name'] )] : '';
                                                        echo '<select class="product-addons-field" name="addon-'. sanitize_title( $addon['name'] ) .'">';
                                                        if(!$addon['required']){
                                                            echo '<option value="">'. __('None', 'wc_product_addons') .'</option>';
                                                        }
                                                        $loop = 0;
                                                        foreach ($addon['options'] as $option) : $loop++;
                                                                //$price = ($option['price']>0) ? ' (+' . woocommerce_price($option['price']) . ')' : '';
                                                                $price = '';
                                                                echo '<option data-price="'.$option['price'].'" value="'. sanitize_title( $option['label'] ) .'-'. $loop .'" '.selected($current_value, sanitize_title( $option['label'] ), false).'>'. wptexturize($option['label']) . $price .'</option>';
                                                        endforeach;
                                                        echo '</select>';
                                                    break;                               
                                                    case 'width_height':
                                                        $current_value = (isset($_POST['addon-' . sanitize_title( $addon['name'] ) . '-' . sanitize_title( $option['label'] )])) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';

                                                        $wh_input_unit = $addon['wh_input_unit'];
                                                        $wh_option_price_unit = $addon['wh_option_price_unit'];
                                                        $wh_default_value     = $addon['wh_default_value'];
                                                        if($current_value){
                                                                $current_value_arr = explode('x',$current_value);
                                                                $width  = $current_value_arr[0];
                                                                $height = $current_value_arr[1];
                                                        }else{
                                                            if($wh_default_value){
                                                                $wh_default_value_arr = explode('x',$wh_default_value);
                                                                $width  = $wh_default_value_arr[0];
                                                                $height = $wh_default_value_arr[1];
                                                            }else{
                                                                $width  = 1;
                                                                $height = 1;
                                                            }
                                                        }
                                                        echo '<input type="hidden" class="input-text product-addons-field" name="addon-' . sanitize_title( $addon['name'] ).'" value="'.$width.'x'.$height.'"/>';
                                                        echo '<input type="text" class="number-field input-text product-addons-field-width" name="addon-' . sanitize_title( $addon['name'] ).'-width" value="'.$width.'"/>';
                                                        echo '&nbsp;x&nbsp;';
                                                        echo '<input type="text" class="number-field input-text product-addons-field-height" name="addon-' . sanitize_title( $addon['name'] ).'-height" value="'.$height.'"/>';
                                                        break;
                                                endswitch;
                                                ?>                                                
                                                <div class="product-addons-field-addition-info addon-<?php echo sanitize_title( $addon['name'] ); ?>-addition-info"></div>
                                            </li>
					<?php endforeach; ?>                                            
				<?php endif;
			}
			
			function add_cart_item_data( $cart_item_meta, $product_id ) {
				global $woocommerce;
				
				$product_addons = get_post_meta( $product_id, '_product_addons', true );
				
				$cart_item_meta['addons'] = array();
				
				if (is_array($product_addons) && sizeof($product_addons)>0) foreach ($product_addons as $addon) :
							
					if (!isset($addon['name'])) continue;
					
					switch ($addon['type']) :
						case "checkbox" :							
							// Posted var = name, value = label
							$posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';
							
							if (!$posted || sizeof($posted)==0) continue;
							
							foreach ($addon['options'] as $option) :
								
								if (array_search(sanitize_title($option['label']), $posted)!==FALSE) :
									
									// Set
									$cart_item_meta['addons'][] = array(
										'name' 		=> esc_attr( $addon['name'] ),
										'value'		=> esc_attr( $option['label'] ),
										'price' 	=> esc_attr( $option['price'] )
									);
									
								endif;

							endforeach;
							
						break;
						case "select" :
							
							// Posted var = name, value = label
							$posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';
							
							if (!$posted) continue;
							
							$chosen_option = '';
							
							$loop = 0;
							foreach ( $addon['options'] as $option ) : $loop ++;
								if ( sanitize_title( $option['label'] . '-' . $loop )==$posted) :
									$chosen_option = $option;
									break;
								endif;
							endforeach;
							
							if (!$chosen_option) continue;
							
							$cart_item_meta['addons'][] = array(
								'name' 		=> esc_attr( $addon['name'] ),
								'value'		=> esc_attr( $chosen_option['label'] ),
								'price' 	=> esc_attr( $chosen_option['price'] )
							);	
							
						break;												
					endswitch;
																	
				endforeach;
				
				return $cart_item_meta;
				
			}
			
			function get_cart_item_from_session( $cart_item, $values ) {
				
				if (isset($values['addons'])) :
					$cart_item['addons'] = $values['addons'];
				
					$cart_item = $this->add_cart_item( $cart_item );
				endif;
				
				return $cart_item;
				
			}
			
			function get_item_data( $other_data, $cart_item ) {
					
				if (isset($cart_item['addons'])) :
					
					foreach ($cart_item['addons'] as $addon) :
						
						$name = $addon['name'];
						if ($addon['price']>0) $name .= ' (' . woocommerce_price($addon['price']) . ')';
						
						$other_data[] = array(
							'name' => $name,
							'value' => $addon['value'],
							'display' => isset($addon['display']) ? $addon['display'] : ''
						);
						
					endforeach;
					
				endif;
				
				return $other_data;
					
			}
			
			function add_cart_item( $cart_item ) {
				
				// Adjust price if addons are set
				if (isset($cart_item['addons'])) :
					
					$extra_cost = 0;
					
					foreach ($cart_item['addons'] as $addon) :
						
						if ($addon['price']>0) $extra_cost += $addon['price'];
						
					endforeach;
					
					$cart_item['data']->adjust_price( $extra_cost );
					
				endif;
				
				return $cart_item;
				
			}
			
			function order_item_meta( $item_meta, $cart_item ) {
			
				// Add the fields
				if (isset($cart_item['addons'])) :
					
					foreach ($cart_item['addons'] as $addon) :
						
						$name = $addon['name'];
						if ($addon['price']>0) $name .= ' (' . strip_tags(woocommerce_price($addon['price'])) . ')';
						
						$item_meta->add( $name, $addon['value'] );
						
					endforeach;

				endif;
			
			}
			
			function validate_add_cart_item( $passed, $product_id, $qty ) {
				global $woocommerce;
				
				$product_addons = get_post_meta( $product_id, '_product_addons', true );
				
				if (is_array($product_addons) && sizeof($product_addons)>0) foreach ($product_addons as $addon) {
							
					if (!isset($addon['name'])) continue;
					if (!isset($addon['required'])) continue;
					
					if ($addon['required']) {
					
						switch ($addon['type']) :
							case "checkbox" :
							case "select" :								
                                                            $posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';								
                                                            if (!$posted || sizeof($posted)==0) $passed = false;								
							break;														
						endswitch;
																		
						if (!$passed) {
                                                    $woocommerce->add_error( sprintf( __('"%s" is a required field.', 'woocommerce'), $addon['name']) );
                                                    break;
						}
					}
					
					do_action('woocommerce_validate_posted_addon_data', $addon);
																	
				}
				
				return $passed;
			}
		}
		
		$woocommerce_product_addons = new woocommerce_product_addons();
	}
}