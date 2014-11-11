<?php
// set value to cart item data
add_filter('woocommerce_add_cart_item_data','vinaprint_add_item_data',1,2);
if(!function_exists('vinaprint_add_item_data'))
{
    function vinaprint_add_item_data($cart_item_data,$product_id)
    {
        $new_value = array('vinaprint_order_item_upload_file_value' => '202,203');
        return array_merge($cart_item_data,$new_value);        
    }
}
// Get cart from session
add_filter('woocommerce_get_cart_item_from_session', 'vinaprint_get_cart_items_from_session', 1, 3 );
if(!function_exists('vinaprint_get_cart_items_from_session'))
{
    function vinaprint_get_cart_items_from_session($item,$values,$key)
    {
        if (array_key_exists( 'vinaprint_order_item_upload_file_value', $values ) )
        {
        $item['vinaprint_order_item_upload_file_value'] = $values['vinaprint_order_item_upload_file_value'];
        }       
        return $item;
    }
}
// display cart checkout page
add_filter('woocommerce_checkout_cart_item_quantity','vinaprint_add_user_custom_option_from_session_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','vinaprint_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('vinaprint_add_user_custom_option_from_session_into_cart'))
{
 function vinaprint_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key )
    {
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['vinaprint_order_item_upload_file_value']) > 0)
        {
            $return_string  = $product_name;
//            $return_string .= "<table class='vinaprint_options_table' id='" . $values['product_id'] . "'>";
//            $return_string .= "<tr><td>" . $values['vinaprint_order_item_upload_file_value'] . "</td></tr>";
//            $return_string .= "</table>"; 
            return $return_string;
        }
        else
        {
            return $product_name;
        }
    }
}
// Add Custom Data as Metadata to the Order Items
add_action('woocommerce_add_order_item_meta','vinaprint_add_values_to_order_item_meta',1,2);
if(!function_exists('vinaprint_add_values_to_order_item_meta'))
{
  function vinaprint_add_values_to_order_item_meta($item_id, $values)
  {
        global $woocommerce,$wpdb;
        $user_custom_values = $values['vinaprint_order_item_upload_file_value'];
        if(!empty($user_custom_values))
        {
            wc_add_order_item_meta($item_id,'vinaprint_order_item_upload_file',$user_custom_values);  
        }
  }
}
// Remove User Custom Data, if Product is Removed from Cart
add_action('woocommerce_before_cart_item_quantity_zero','vinaprint_remove_user_custom_data_options_from_cart',1,1);
if(!function_exists('vinaprint_remove_user_custom_data_options_from_cart'))
{
    function vinaprint_remove_user_custom_data_options_from_cart($cart_item_key)
    {
        global $woocommerce;
        // Get cart
        $cart = $woocommerce->cart->get_cart();
        // For each item in cart, if item is upsell of deleted product, delete it
        foreach( $cart as $key => $values)
        {
        if ( $values['vinaprint_order_item_upload_file_value'] == $cart_item_key )
            unset( $woocommerce->cart->cart_contents[ $key ] );
        }
    }
}

add_action( 'woocommerce_before_calculate_totals', 'vinaprint_add_custom_price', 10, 2 );

function vinaprint_add_custom_price( $cart_object ) {
    global $woocommerce;
    foreach ( $cart_object->cart_contents as $key => $value ) {
        $product_id = $value['product_id'];
        $qty   = $value['quantity'];
        $price = $value['data']->price;
        
        $discount_by_qty    = vinaprint_get_discount_price_by_qty($product_id, $qty);
        
        $h_discount_type    = $discount_by_qty['discount_type'];
        $h_discount_value   = $discount_by_qty['discount_value'];
        
        if($h_discount_value){
            switch ($h_discount_type) {
                case 'percent':
                        $new_price = $price - ($price * ($h_discount_value / 100));
                    break;
                case 'cash':
                        $new_price = $price - $h_discount_value;
                    break;
                default:
                        $new_price = $price - ($price * ($h_discount_value / 100));
                    break;
            }
        }
        $value['data']->price = $new_price;
    }

    $woocommerce->cart->persistent_cart_update();
}

//add_filter('woocommerce_get_price', 'return_custom_price', $product, 2); 
//function return_custom_price($price, $product) {    
//    return 9.5;
//}

add_action( 'woocommerce_new_order', 'vinaprint_woocommerce_new_order' );


function vinaprint_hidden_order_item_meta_fields( $fields ) {
    $fields[] = 'vinaprint_order_item_upload_file';
    return $fields;
}

add_filter( 'woocommerce_hidden_order_itemmeta', 'vinaprint_hidden_order_item_meta_fields' );

add_action( 'woocommerce_admin_order_item_values','vinaprint_admin_order_item_values', 10, 3 );
function vinaprint_admin_order_item_values( $_product, $item, $item_id ){ ?>
    <?php if($item['type'] == 'line_item'): ?>
        <?php if(isset($item['vinaprint_order_item_upload_file']) && $item['vinaprint_order_item_upload_file']): ?>
            <td class="vinaprint-upload-file-item" style="display: inline-block;width:150px;">
            <?php $media_items = explode(',',$item['vinaprint_order_item_upload_file']); ?>
            <ul style="margin-top:-20px;">
                <?php foreach($media_items as $media_item_id): ?>
                    <?php $media_item = get_post($media_item_id); ?>
                        <li>
                            <p style="padding:0px;"><b>File:</b>
                                <a href="<?php echo $media_item->guid;?>"><?php echo basename($media_item->guid) ?></a>
                            </p>   
                        </li>
                <?php endforeach;?>    
            </ul>
            </td>
        <?php else:?>
            <td>No upload file</td>
        <?php endif;?>    
    <?php endif;?>
<?php } ?>
        
<?php
add_action( 'woocommerce_admin_order_item_headers','vinaprint_add_order_item_header');
function vinaprint_add_order_item_header() { ?>
    <th class="vinaprint-upload-file-header">File Uploaded</th>
<?php } 

add_action( 'woocommerce_product_write_panel_tabs','vinaprint_add_product_data_tab');
add_action( 'woocommerce_product_write_panels', 'vinaprint_add_product_data_panel');

function vinaprint_add_product_data_tab() { ?>
    <li class="vinaprint_price_table"><a href="#vinaprint_product_price_table">Table Price</a></li>
<?php }

function vinaprint_add_product_data_panel(){ 
    global $wpdb, $post;
    $product = new WC_Product($post->ID);
?>
    <div id="vinaprint_product_price_table" class="panel woocommerce_options_panel">
        <div class="options_group">
            <?php 
                $product_attributes = array_keys($product->get_attributes());
            ?>
            <table id="vinaprint_table_price_table">
                <?php if(count($product_attributes)): ?>
                    <thead>
                        <tr>
                            <?php foreach($product_attributes as $att):?>
                                <th data-attribute="<?php echo $att;?>">
                                    <pre>
                                        <?php //print_r(get_taxonomy($att));?>
                                    </pre>
                                    <?php echo get_taxonomy($att)->label;?>    
                                </th>    
                            <?php endforeach;?>
                        </tr>
                    </thead>
                <?php endif;?>
                <tbody>
                    <?php if(count($product_attributes)): ?>
                        <tr>
                            <?php foreach($product_attributes as $att):?>                
                                <td>
                                    <?php
                                        $terms = get_the_terms( $product->id, $att); 
                                        //print_r($terms);
                                    ?>
                                </td>
                            <?php endforeach;?>                    
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
<?php }

/* Only use simple product */
/*End only use simple product */

function vinaprint_get_discount_price_by_qty($product_id, $amount, $discount_by_quantity_list = null){
    
    if(!$discount_by_quantity_list){
        $discount_by_quantity_list = get_field('discount_by_quantity_list', $product_id);
    }
    
    $h_discount_type    = 'percent';
    $h_discount_value   = 0;
    $h_quantity_to      = 0;
    $h_quantity_from    = 0;

    if(count($discount_by_quantity_list)){
        foreach($discount_by_quantity_list as $discount_by_quantity){
            $quantity_from_to = $discount_by_quantity['quantity_from_to'];

            $quantity_from_to_arr = explode('-', $quantity_from_to);

            if(count($quantity_from_to_arr) == 2){
                $quantity_from    = $quantity_from_to_arr[0];
                if(strlen($quantity_from) == 0){
                    $quantity_from = 0;
                }

                $quantity_to      = $quantity_from_to_arr[1];
                if(strlen($quantity_to) == 0){
                    $quantity_to = 999999999;
                }
            }elseif(count($quantity_from_to_arr) == 1){
                $quantity_from = $quantity_from_to_arr[0];
                $quantity_to = 999999999;
            }   

            if($amount >= $quantity_from && $amount <= $quantity_to){                                            
                $h_quantity_from  = $quantity_from;
                $h_quantity_to    = $quantity_to;
                $h_discount_type    = $discount_by_quantity['discount_type'];
                $h_discount_value   = $discount_by_quantity['discount_value'];
                break;
            }
        }
    }
    return array(
        'quantity_from'  => $h_quantity_from,
        'quantity_to'    => $h_quantity_to,
        'discount_type'  => $h_discount_type,
        'discount_value' => $h_discount_value
    );
}