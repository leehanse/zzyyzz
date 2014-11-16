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
        $h_discount_value   = (float)$discount_by_qty['discount_value'];
        
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
        }else{
            $new_price = $price;
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
<?php }
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

function _get_discount_by_quantity_list($product_id){
    $discount_by_quantity_list = get_field('discount_by_quantity_list', $product_id);
    if($discount_by_quantity_list){
        for($i=0; $i < count($discount_by_quantity_list) - 1; $i++){
            for($j=$i+1; $j< count($discount_by_quantity_list); $j++){
                if($discount_by_quantity_list[$i]['quantity'] > $discount_by_quantity_list[$j]['quantity']){
                    $tmp = $discount_by_quantity_list[$i];
                    $discount_by_quantity_list[$i] = $discount_by_quantity_list[$j];
                    $discount_by_quantity_list[$j] = $tmp;
                }
            }
        }
    }else{
        $discount_by_quantity_list = array();
    }
    if(count($discount_by_quantity_list)){
        $first_item = reset($discount_by_quantity_list);
        if($first_item['quantity'] != 0){
            array_unshift($discount_by_quantity_list, array('quantity' => 0, 'discount_value' => 0));
        }
    }else{
        array_unshift($discount_by_quantity_list, array('quantity' => 0, 'discount_value' => 0));
    }
    return $discount_by_quantity_list;
}

function vinaprint_get_discount_price_by_qty($product_id, $amount, $discount_by_quantity_list = null){
    //echo $amount.'<br/>';
    if(!$discount_by_quantity_list){
        $discount_by_quantity_list = _get_discount_by_quantity_list($product_id);
    }
    
    if(count($discount_by_quantity_list)){
        $list_qty   = array();
        $list_discount_value = array();

        for($i=0;$i<count($discount_by_quantity_list);$i++){
            $list_qty[] = $discount_by_quantity_list[$i]['quantity'];
            $list_discount_value[] = $discount_by_quantity_list[$i]['discount_value'];
        }
        $h1_qty = null;
        $h2_qty = null;
        $h1_discount_value = null;
        $h2_discount_value = null;

        $first_item_qty = reset($list_qty);
        for($i=0; $i< count($list_qty); $i++){
            if($list_qty[$i] <= $amount){
                if($i == count($list_qty) -1){
                   $h1_qty =  $list_qty[$i];
                   $h2_qty = null;
                   $h1_discount_value = $list_discount_value[$i];
                   $h2_discount_value = null;
                }else{
                    if($list_qty[$i+1] >= $amount){
                       $h1_qty =  $list_qty[$i];
                       $h2_qty = $list_qty[$i+1];
                       $h1_discount_value = $list_discount_value[$i];
                       $h2_discount_value = $list_discount_value[$i+1];
                    }
                }
            }
        }
        //echo "$h1_qty($h1_discount_value)==$h2_qty($h2_discount_value)<br/>";
        if($h2_qty){
            if($h2_qty - $h1_qty == 0){
                return $h1_discount_value;
            }else{
                $discount_step = (($h2_discount_value - $h1_discount_value) / ($h2_qty - $h1_qty));
                return $h1_discount_value +  $discount_step * ($amount - $h1_qty);
            }          
        }else{
            return $h1_discount_value;
        }        
    }else{
        return 0;
    }
}