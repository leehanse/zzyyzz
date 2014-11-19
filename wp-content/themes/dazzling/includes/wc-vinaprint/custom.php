<?php
// set value to cart item data
add_filter('woocommerce_add_cart_item_data','vinaprint_add_item_data',1,2);
if(!function_exists('vinaprint_add_item_data'))
{
    function vinaprint_add_item_data($cart_item_data,$product_id)
    {
        $upload_files = array();
        if(isset($_POST['wp_multi_file_uploader_1'])){
            $i=1;
            while(isset($_POST['wp_multi_file_uploader_'.$i])){
                $upload_files[] = $_POST['wp_multi_file_uploader_'.$i];
                $i++;
            }
        }
        $new_value = array('vinaprint_order_item_upload_file_value' => $upload_files);
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
add_filter( 'woocommerce_get_item_data', 'vinaprint_get_item_data', 10, 2 );
if(!function_exists('vinaprint_get_item_data')){
    function vinaprint_get_item_data( $other_data, $cart_item ) {
        $upload_files = $cart_item['vinaprint_order_item_upload_file_value'];

        if(is_array($upload_files) && count($upload_files)){
            $loop = 1;
            foreach ($upload_files as $attachment_id) :
                $media = get_post($attachment_id);
                $other_data[] = array(
                    'name'    => 'Upload File '.$loop,
                    'value'   => $attachment_id,
                    'display' => '<a href="'.$media->guid.'">'.esc_attr($media->post_name).'('.$media->post_mime_type .')</a>'
                );
                $loop++;
            endforeach;
        }
        return $other_data;
    }
}

// display cart checkout page
add_filter('woocommerce_checkout_cart_item_quantity','vinaprint_add_user_custom_option_from_session_into_cart',1,3);  
add_filter('woocommerce_cart_item_price','vinaprint_add_user_custom_option_from_session_into_cart',1,3);
if(!function_exists('vinaprint_add_user_custom_option_from_session_into_cart'))
{
 function vinaprint_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key ){
        /*code to add custom data on Cart & checkout Page*/    
        if(count($values['vinaprint_order_item_upload_file_value']) > 0)
        {
           $return_string  = $product_name;
           $return_string .= "<table class='vinaprint_options_table' id='" . $values['product_id'] . "'>";
           $return_string .= "<tr><td>" . $values['vinaprint_order_item_upload_file_value'] . "</td></tr>";
           $return_string .= "</table>"; 
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
        global $woocommerce, $wpdb;
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
            <td class="vinaprint-upload-file-item" style="width:150px;">
            <?php $media_items = unserialize($item['vinaprint_order_item_upload_file']);?>
            <ul style="margin-top:-20px;">
                <?php foreach($media_items as $media_item_id): ?>
                    <?php $media_item = get_post($media_item_id); ?>
                        <li>
                            <p style="padding:0px;"><b>File:</b>
                                <a target="_blank" href="<?php echo $media_item->guid;?>"><?php echo $media_item_id;?> <?php echo basename($media_item->guid) ?></a>
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

//add_action( 'woocommerce_product_write_panel_tabs','vinaprint_add_product_data_tab');
//add_action( 'woocommerce_product_write_panels', 'vinaprint_add_product_data_panel');

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

function getTierPrice($o_price, $tier_price, $qty){
    $tier_price = trim($tier_price);    
    if($tier_price){
       $_tier_price_arr = explode(',', $tier_price);
       $tier_price_arr  = array();
       foreach($_tier_price_arr as $item){
           $item = trim($item);
           $item_arr = explode('-', $item);
           if(count($item_arr) ==2){
                $tier_price_arr[$item_arr[0]] = $item_arr[1];
           }
       }
       if(count($tier_price_arr)){
           ksort($tier_price_arr);
           $amount_arr = array_keys($tier_price_arr);           
           $value_arr  = array_values($tier_price_arr);
           if($qty < $amount_arr[0]){
               $a1 = 1;
               $a2 = $amount_arr[0];
               $v1 = $o_price;
               $v2 = $value_arr[0];
               return $v1 + ($qty - $a1) * (($v2 - $v1) / ($a2 - $a1));
           }else{
            if($qty >= end($amount_arr)){
                $a1 = end($amount_arr);
                $a2 = $qty;
                $v1 = end($value_arr);
                $v2 = ($v1/$a1) * $qty;
                if($a2 - $a1 == 0){
                    return $v2;
                }else{
                    return $v1 + ($qty - $a1) * (($v2 - $v1) / ($a2 - $a1));
                }
            }else{
                for($i=0;$i < count($amount_arr)-1; $i++){
                    if($amount_arr[$i] <= $qty && $amount_arr[$i+1] > $qty){
                        $a1 = $amount_arr[$i];
                        $a2 = $amount_arr[$i+1];
                        $v1 = $value_arr[$i];
                        $v2 = $value_arr[$i+1];
                        break;
                    }                    
                }
                return $v1 + ($qty - $a1) * (($v2 - $v1) / ($a2 - $a1));
            }
           }
       }else{
           return $o_price;
       }
    }else return $o_price;
}

function getAddonCartItemMeta($product_id, $qty, $select_addons, $product_addons = null){
    if(!$product_addons){
        $product_addons = get_post_meta( $product_id, '_product_addons', true );
    }
    if($select_addons):
        // check addons
        $cart_item_meta = array();
        if (is_array($product_addons) && sizeof($product_addons)>0):
            foreach ($product_addons as $addon) :                    
                if (!isset($addon['name'])) continue;
                switch ($addon['type']) :
                        case "checkbox" :

                            // Posted var = name, value = label
                            $posted = (isset( $select_addons['addon-' . sanitize_title( $addon['name'] )] )) ? $select_addons['addon-' . sanitize_title( $addon['name'] )] : '';

                            if (!$posted || sizeof($posted)==0) continue;

                                foreach ($addon['options'] as $option) :
                                    if (array_search(sanitize_title($option['label']), $posted)!==FALSE) :
                                        $price               = (float)esc_attr( $option['price'] );
                                        $price_added_default = (float) esc_attr( $addon['price_added_default'] );
                                        $price_type          = esc_attr( $addon['price_type']);

                                        switch($price_type){
                                            case 'x':
                                                $fprice = $price_added_default + ($price * $qty);
                                                break;
                                            case '+':
                                                $fprice = $price_added_default + $price;
                                            break;
                                        }
                                        // Set
                                        $cart_item_meta[] = array(
                                            'name'       => esc_attr( $addon['name'] ),
                                            'sanitize_title' => sanitize_title( $addon['name'] ),
                                            'addon_type' => $addon['type'],
                                            'value'      => esc_attr( $option['label'] ),
                                            'price'      => $price,
                                            'fprice'     => $fprice,
                                            'price_type' => $price_type,
                                            'price_added_default' => $price_added_default
                                        );
                                    endif;
                            endforeach;

                        break;
                        case "select" :                                
                            // Posted var = name, value = label
                            $posted = (isset( $select_addons['addon-' . sanitize_title( $addon['name'] )] )) ? $select_addons['addon-' . sanitize_title( $addon['name'] )] : '';

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

                            $price               = (float)esc_attr( $chosen_option['price'] );
                            $price_added_default = (float) esc_attr( $addon['price_added_default'] );
                            $price_type          = esc_attr( $addon['price_type']);

                            switch($price_type){
                                case 'x':
                                        $fprice = $price_added_default + ($price * $qty);
                                    break;
                                case '+':
                                        $fprice = $price_added_default + $price;
                                    break;
                            }

                            $cart_item_meta[] = array(
                                    'name'      => esc_attr( $addon['name'] ),
                                    'sanitize_title' => sanitize_title( $addon['name'] ),
                                    'addon_type' => $addon['type'],
                                    'value'     => esc_attr( $chosen_option['label'] ),
                                    'price'     => $price,
                                    'fprice'    => $fprice,
                                    'price_type'    => $price_type,
                                    'price_added_default' => $price_added_default
                            );
                        break;
                        case "custom" :
                        case "custom_textarea" :
                            // Posted var = label, value = custom
                            foreach ($addon['options'] as $option) :
                                    $posted = (isset( $select_addons['addon-' . sanitize_title( $addon['name'] ) . '-' . sanitize_title( $option['label'] )] )) ? $select_addons['addon-' . sanitize_title( $addon['name'] ) . '-' . sanitize_title( $option['label'] )] : '';
                                    if (!$posted) continue;

                                    $price               = (float)esc_attr( $option['price'] );
                                    $price_added_default = (float) esc_attr( $addon['price_added_default'] );
                                    $price_type          = esc_attr( $addon['price_type']);

                                    switch($price_type){
                                        case 'x':
                                                $fprice = $price_added_default + ($price * $qty);
                                            break;
                                        case '+':
                                                $fprice = $price_added_default + $price;
                                            break;
                                    }

                                    $cart_item_meta[] = array(
                                        'name'      => esc_attr( $option['label'] ),
                                        'sanitize_title' => sanitize_title( $addon['name'] ),
                                        'addon_type' => $addon['type'],
                                        'value'     => esc_attr( stripslashes( trim( $posted ) ) ),
                                        'price'     => $price,
                                        'price_type'    => $price_type,
                                        'price_added_default' => $price_added_default
                                    );
                            endforeach;

                        break;
                        case 'width_height':
                            $wh_input_unit = $addon['wh_input_unit'];
                            $wh_option_price_unit = $addon['wh_option_price_unit'];
                            $options = $addon['options'];
                            $posted = (isset( $select_addons['addon-' . sanitize_title( $addon['name'] )] ))
                                      ? $select_addons['addon-' . sanitize_title( $addon['name'] )] : '';

                            if (!$posted) continue;

                            $input_with_height_arr = explode('x',$posted);
                            $input_width  = $input_with_height_arr[0];
                            $input_height = $input_with_height_arr[1];

                            switch($wh_input_unit){
                                case 'm':
                                        $square_input = ($input_width*100) * ($input_height * 100);
                                    break;                                        
                                case 'cm':
                                        $square_input = $input_width * $input_height;
                                    break;
                            }
                            $price_range_by_with_height_arr = array();
                            $price_range_by_with_height     = 0;

                            if(count($options)){
                                foreach($options as $option){
                                    if($wh_option_price_unit == 'm'){
                                        $square = (float)$option['label'] * 10000;
                                        $price_range_by_with_height_arr[$square] = (float)$option['price'];
                                    }else{
                                        $square = (float)$option['label'];
                                        $price_range_by_with_height_arr[$square] = (float)$option['price'];
                                    }
                                }
                                ksort($price_range_by_with_height_arr);

                                $price_range_by_with_height_arr_keys = array_keys($price_range_by_with_height_arr);

                                $h_square = 0;
                                $h_v      = 0;
                                $h_v1     = 0;
                                for($i=0; $i< count($price_range_by_with_height_arr_keys) -1; $i++){
                                    $v  = $price_range_by_with_height_arr_keys[$i];
                                    $v1 = $price_range_by_with_height_arr_keys[$i+1];
                                    if($v <= $square_input && $square_input <= $v1){
                                        $v_step       = $v1 - $v;
                                        $v_step_div_2 = (float)$v_step / 2;
                                        if($square_input <= $v + $v_step_div_2){
                                            $h_square = $v;
                                            $h_v      = $v;
                                            $h_v1     = $v1;       
                                        }else{
                                            $h_square = $v1;
                                            $h_v      = $v;
                                            $h_v1     = $v1;
                                        }
                                    }
                                }
                                if($h_v == 0 && $h_v1 == 0){
                                    $h_square = reset($price_range_by_with_height_arr_keys);
                                }
                            }

                            $_price  = $price_range_by_with_height_arr[$h_square];

                            $input_m2 = (float)(($input_width * $input_height) /10000);
                            $price    = (($input_width * $input_height) /10000) * $_price;
                            
                            $price_added_default = (float) esc_attr( $addon['price_added_default'] );
                            $price_type          = esc_attr( $addon['price_type']);

                            switch($price_type){
                                case 'x':
                                        $fprice += $price_added_default + $price * $qty;
                                    break;
                                case '+':
                                        $fprice += $price_added_default + $price;
                                    break;
                            }
                            
                            $cart_item_meta[] = array(
                                'name'      => esc_attr( $addon['name'] ),
                                'sanitize_title' => sanitize_title( $addon['name'] ),
                                'addon_type' => $addon['type'],
                                'value'     => esc_attr( stripslashes( trim( $posted ) ) ),
                                'price'     => esc_attr( $_price ),
                                'fprice'    => $fprice,
                                'price_type'    => esc_attr( $addon['price_type'] ),
                                'price_added_default' => esc_attr( $addon['price_added_default']),
                                'addition_info'     => '<p><b>'.woocommerce_price($_price). ' x '.number_format($input_m2,2).' = '.woocommerce_price($fprice).'</b></p>'
                            );
                        break;
                endswitch;
            endforeach;
        endif;
        return $cart_item_meta;
    else:
        return array();
    endif;
}
function calculatePriceCell($product_id, $qty, $select_attributes = array(), $select_addons = array(), $available_variations = null, $product_addons = null){
    if(is_array($select_attributes) && count($select_attributes)){
        $select_attributes = array_map('sanitize_title',$select_attributes);
    }
    
    global $woocommerce;
    $price           = 0;

    $variation_price = 0;
    $addon_price     = 0;

    if(!$available_variations || !$product_addons){
        $productVariable     = new  WC_Product_Variable($product_id);
        if(!$product_addons){
            $product_addons      = get_post_meta( $product_id, '_product_addons', true );
        }
        if(!$available_variations){
            $available_variations = $productVariable->get_available_variations();        
        }
    }
    $variation_price      = 0;
    $variation_tier_price = 0;
    // check variations 
    $found_variation = false;
    if(count($available_variations)){                
        if(count($available_variations)){
            foreach($available_variations as $variation){
                if(count(array_diff_assoc($variation['attributes'], $select_attributes)) == 0){ // compare two array = equal
                    $variation_price   = get_post_meta($variation["variation_id"], "_price", true);
                    $tier_price        = get_post_meta($variation["variation_id"], "_tier_price", true);                            
                    if($tier_price){
                        $variation_tier_price = getTierPrice($variation_price, $tier_price, $qty);                                                                                               
                    }
                    if(!$variation_price){ // if price not set => return null
                        return 'no_price';
                    }
                    $found_variation = true;
                    break;
                }
            }
        }
        if(!$found_variation){ // not found variation
            return 'no_price';
        }
    }
    
    $cart_item_meta = getAddonCartItemMeta($product_id, $qty, $select_addons, $product_addons);
    
    if(count($cart_item_meta)){
        foreach($cart_item_meta as $item){
            $addon_price += $item['fprice'];
        }
    }
    // calculate discount variation by qty       
    if($variation_tier_price){
        return ceil($variation_tier_price + $addon_price);
    }else{
        return ceil($variation_price *$qty + $addon_price);
    }
}

/* add to cart price */
add_action( 'woocommerce_before_calculate_totals', 'vinaprint_add_custom_price', 10, 2 );
function vinaprint_add_custom_price( $cart_object ) {
    global $woocommerce;
    foreach ( $cart_object->cart_contents as $key => $value ) {        
        $product_id = $value['product_id'];
        $qty   = $value['quantity'];
        $select_attributes = $value['variation'];
        $select_addons = $value['addons'];
        
        if(count($select_addons)){
            $product_addons = get_post_meta( $product_id, '_product_addons', true );            
            for($i=0; $i<count($select_addons); $i++){
                $addon_name  = $select_addons[$i]['name'];
                $addon_value = $select_addons[$i]['value'];
                if(count($product_addons)){
                    foreach($product_addons as $paddon){
                        if($paddon['name'] == $addon_name){
                            $paddon_options = $paddon['options'];
                            if(count($paddon_options)){
                                foreach($paddon_options as $op_index => $option){
                                    if($option['label'] == $addon_value){
                                        $post_addon_name  = 'addon-'. sanitize_title( $select_addons[$i]['name'] );
                                        $post_addon_value = sanitize_title( $option['label'] ) .'-'. ($op_index+1);
                                        $select_addons[$post_addon_name] = $post_addon_value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $price = calculatePriceCell($product_id, $qty, $select_attributes, $select_addons);
        $value['data']->price = (float) $price / $qty;
    }
    $woocommerce->cart->persistent_cart_update();
}
add_action( 'body_class', 'vinaprint_add_my_bodyclass');
function vinaprint_add_my_bodyclass( $classes ) {
  if ( basename(get_page_template()) == 'shop.php'){
    $classes[] = 'woocommerce woocommerce-page';
  }
  return $classes;
} 