<?php
if ( ! class_exists( 'VinaprintAjax' ) ) {
    class VinaprintAjax {

        private $actions = array(
                'calculateTablePrice',
            );

        function __construct() {

            // Add our javascript file that will initiate our AJAX requests
            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

            // Let's make sure we are actually doing AJAX first
            if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                // Add our callbacks for AJAX requests
                if(count($this->actions)){
                    foreach($this->actions as $action){
                        add_action( 'wp_ajax_' . $action, array( $this, 'doAjax' ) ); // For logged in users
                        add_action( 'wp_ajax_nopriv_' . $action, array( $this, 'doAjax' ) ); // For logged out users
                    }
                }
            }
        }

        /**
         * Enqueue our script that will initiate our AJAX requests and pass important variables
         * from PHP to our JavaScript.
         */
        function wp_enqueue_scripts() {

            if( is_single() && 'product' == get_post_type() ){ // Make sure you only call your scripts where you need them!
                // Load our script
                wp_enqueue_script( 'ajax-vinaprint', get_template_directory_uri().'/js/ajax.js', array('jquery') );

                // Pass a collection of variables to our JavaScript
                wp_localize_script(
                    'ajax-vinaprint', 'vinaprintAjax', array(
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'action' => $this->action
                    ));
            }
        }

        function doAjax(){
            $action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : null);
            switch($action){
                case 'calculateTablePrice':
                        $product_id       = $_POST['product_id'];
                        $html_table_price = $this->calculateTablePrice($product_id);
                        echo $html_table_price; die;
//                        $response = array('post_id' => $product_id);
//                        header( 'Content: application/json' );
//                        echo json_encode( $response );
//                        die;            
                    break;
                default:
                        echo 'No ajax action found';
                    die;
                    break;
            }
        }    

        function calculatePriceCell($product_id, $qty, $select_attributes = array(), $select_addons = array(), $available_variations = null, $product_addons = null){
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

            // check variations 
            $found_variation = false;
            if(count($available_variations)){                
                if(count($available_variations)){
                    foreach($available_variations as $variation){
                        if(count(array_diff_assoc($variation['attributes'], $select_attributes)) == 0){ // compare two array = equal
                            $variation_price   = get_post_meta($variation["variation_id"], "_price", true);
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
                                    $posted = (isset( $select_addons['addon-' . sanitize_title( $addon['name'] )] )) ? $select_addons['addon-' . sanitize_title( $addon['name'] )] : '';
                                    
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
                                        }if($h_v == 0 && $h_v1 == 0){
                                            $h_square = reset($price_range_by_with_height_arr_keys);
                                        }
                                    }
                                    
                                    $_price  = $price_range_by_with_height_arr[$h_square];
                                    
                                    $price = (($input_width * $input_height) /10000) * $_price;

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
                                        'value'     => esc_attr( stripslashes( trim( $posted ) ) ),
                                        'price'     => esc_attr( $_price ),
                                        'fprice'    => $fprice,
                                        'price_type'    => esc_attr( $addon['price_type'] ),
                                        'price_added_default' => esc_attr( $addon['price_added_default']),
                                        'addition_info'     => '<p><b>Price: '.woocommerce_price($_price).'/'.$wh_option_price_unit.'&sup2;</b><br/><b>+'.woocommerce_price($fprice).'</b></p>'
                                    );
                                break;
                        endswitch;
                    endforeach;
                endif;
                if(count($cart_item_meta)){
                    foreach($cart_item_meta as $item){
                        $addon_price += $item['fprice'];
                    }
                }
            endif;
            return $variation_price * $qty + $addon_price;
        }

        function calculateTablePrice($product_id){
            $_select_attributes    = $_POST['attributes'];
            $_select_addons        = $_POST['addons'];
            $qty                  = isset($_POST['qty']) ? $_POST['qty'] : 1;

            $productVariable      = new  WC_Product_Variable($product_id);            
            $product_addons       = get_post_meta( $product_id, '_product_addons', true );
            $available_variations = $productVariable->get_available_variations();

            $available_attributes = $productVariable->get_variation_attributes();

            $select_attributes    = array();
            $select_addons        = array();

            $arr_amount = array();
            switch(true) {
               case in_array($qty, range(1,24)): $step = 1; break;
               case in_array($qty, range(25,49)): $step = 5; break;
               case in_array($qty, range(50,239)): $step = 10; break;
               case in_array($qty, range(240,499)): $step = 50; break;
               case in_array($qty, range(500,1499)): $step = 100; break;
               default : $step = 500;
            }
            $next_qty = ceil($qty/$step) * $step;

            if($next_qty == $qty){
                $next_qty = $qty + $step;
            }
            $arr_amount[] = $qty;
            for($j=0;$j<4;$j++){
                $arr_amount[] = $next_qty + $step * $j; 
            }

            $html  = "<table>";
            $html .= "<thead>";
            $html .= "<tr>";
            $html .= '<th>{__NAME__}</th>';
            foreach($arr_amount as $amount){
                $html .= "<th>$amount</th>";
            }
            $html .= "</tr>";                

            if(count($available_attributes)){ // variable product -> remove last select attribute to build table price
                end($available_attributes);
                $last_attribute = key($available_attributes);                
                if(count($_select_attributes)){
                    foreach($_select_attributes as $key => $item){
                        if($key != 'attribute_'.$last_attribute){
                            $select_attributes[$key] = $item;
                        }
                    }
                }

                if(count($available_attributes[$last_attribute])){
                    $select_addons = $_select_addons;
                    foreach($available_attributes[$last_attribute] as $attribute){
                        $tmp_select_attributes = $select_attributes;

                        $pname    = 'attribute_'.$last_attribute;
                        $pvalue   = $attribute;
                        $tmp_select_attributes[$pname] = $pvalue;

                        $tmp_select_addons     = $select_addons;
                        

                        $html .= '<tr>';
                        $term = get_term_by('slug', $attribute, $last_attribute);
                        $html .= '<td>'.$term->name.'</td>';

                        foreach($arr_amount as $amount){
                            $price = $this->calculatePriceCell($product_id, $amount, $tmp_select_attributes, $tmp_select_addons, $available_variations, $product_addons);
                            if($price != 'no_price'){
                                $html .='<td class="table-cell-price">';                                
                                    $html .= '<input type="checkbox" class="chk-table-price" data-map-field-name="'.$pname.'" data-map-field-value="'.$pvalue.'" data-qty="'.$amount.'"/>';
                                    $html .= woocommerce_price($price);
                                $html .= '</td>';
                            }else{
                                $html .='<td>N/A</td>';
                            }
                        }
                        $html .='</tr>';
                    }
                }

                $html .= '</table>';
                $html = str_replace('{__NAME__}',wc_attribute_label( $last_attribute ), $html);
                return $html;
            }else{
                if(count($product_addons)){ // product addons -> remove lass select addon to build table price
                    $select_attributes = $_select_attributes;

                    // get last select box addons
                    $last_addon = null;
                    for($j=count($product_addons)-1; $j >=0 ; $j--){
                        $item = $product_addons[$j];
                        if($item['type'] == 'select'){
                            $last_addon = $item;
                            break;        
                        }
                    }
                    if(!$last_addon) return 'product_select_addon_non_exists';

                    foreach($_select_addons as $key => $item){
                        if($key != 'addon-'.sanitize_title($last_addon['name'])){
                            $select_addons[$key] = $item;
                        }
                    }

                    $options         = $last_addon['options'];
                    if(count($options)){
                        foreach($options as $option_index => $option){
                            $tmp_select_attributes = $select_attributes;
                            $tmp_select_addons     = $select_addons;

                            $pname  = 'addon-'.sanitize_title($last_addon['name']);
                            $pvalue = sanitize_title( $option['label'] ) .'-'. ($option_index+1);

                            $tmp_select_addons[$pname] = $pvalue;

                            $html .= '<tr>';
                            $html .= '<td>'.$option['label'].'</td>';

                            foreach($arr_amount as $amount){
                                $price = $this->calculatePriceCell($product_id, $amount, $tmp_select_attributes, $tmp_select_addons, $available_variations, $product_addons);
                                if($price != 'no_price'){
                                    $html .='<td class="table-cell-price">';                                
                                        $html .= '<input type="checkbox" class="chk-table-price" data-map-field-name="'.$pname.'" data-map-field-value="'.$pvalue.'" data-qty="'.$amount.'"/>';
                                        $html .= woocommerce_price($price);
                                    $html .= '</td>';
                                }else{
                                    $html .='<td>N/A</td>';
                                }
                            }
                            $html .='</tr>';
                        }
                        $html.= '</table>';
                        $html = str_replace('{__NAME__}', $last_addon['name'], $html);
                    }
                }else{
                    return __( 'This product is currently out of stock and unavailable.', 'woocommerce' );
                }
            }
            
               
            return $html;
        }
    }

    new VinaprintAjax();
}