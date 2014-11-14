<?php
if ( ! class_exists( 'NemprintAjax' ) ) {
    class NemprintAjax {

        private $actions = array(
                'calculateTablePrice'
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
                wp_enqueue_script( 'ajax-nemprint', get_template_directory_uri().'/js/ajax.js', array('jquery') );

                // Pass a collection of variables to our JavaScript
                wp_localize_script(
                    'ajax-nemprint', 'nemprintAjax', array(
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

        function calculateTablePrice($product_id){
            $wc_product = new WC_Product($product_id);
            
            $total_adjust_price_x_qty_x_qty    = 0;
            $total_adjust_price_add            = 0;
            global $woocommerce;
				
            $product_addons = get_post_meta( $product_id, '_product_addons', true );
            $cart_item_meta = array();
            
            if (is_array($product_addons) && sizeof($product_addons)>0):               
                foreach ($product_addons as $addon) :
                
                    if (!isset($addon['name'])) continue;

                    switch ($addon['type']) :
                            case "checkbox" :

                                // Posted var = name, value = label
                                $posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';

                                if (!$posted || sizeof($posted)==0) continue;

                                foreach ($addon['options'] as $option) :

                                        if (array_search(sanitize_title($option['label']), $posted)!==FALSE) :

                                                // Set
                                                $cart_item_meta[] = array(
                                                        'name' 		=> esc_attr( $addon['name'] ),
                                                        'value'		=> esc_attr( $option['label'] ),
                                                        'price' 	=> esc_attr( $option['price'] ),
                                                        'price_type' 	=> esc_attr( $addon['price_type'] ),
                                                );
                                                switch(esc_attr( $addon['price_type'])){
                                                    case 'x':
                                                            $total_adjust_price_x_qty += (float)esc_attr( $option['price'] );
                                                        break;
                                                    case '+':
                                                            $total_adjust_price_add += (float)esc_attr( $option['price'] );
                                                        break;
                                                }
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

                                $cart_item_meta[] = array(
                                        'name' 		=> esc_attr( $addon['name'] ),
                                        'value'		=> esc_attr( $chosen_option['label'] ),
                                        'price' 	=> esc_attr( $chosen_option['price'] ),
                                        'price_type'    => esc_attr( $addon['price_type'] )
                                );	
                                switch(esc_attr( $addon['price_type'])){
                                            case 'x':
                                                    $total_adjust_price_x_qty += (float)esc_attr( $chosen_option['price'] );
                                                break;
                                            case '+':
                                                    $total_adjust_price_add += (float)esc_attr( $chosen_option['price'] );
                                                break;
                                }
                            break;
                            case "custom" :
                            case "custom_textarea" :
                                // Posted var = label, value = custom
                                foreach ($addon['options'] as $option) :

                                        $posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] ) . '-' . sanitize_title( $option['label'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] ) . '-' . sanitize_title( $option['label'] )] : '';

                                        if (!$posted) continue;

                                        $cart_item_meta[] = array(
                                                'name' 		=> esc_attr( $option['label'] ),
                                                'value'		=> esc_attr( stripslashes( trim( $posted ) ) ),
                                                'price' 	=> esc_attr( $option['price'] ),
                                                'price_type' 	=> esc_attr( $addon['price_type'] )
                                        );
                                        switch(esc_attr( $addon['price_type'])){
                                            case 'x':
                                                    $total_adjust_price_x_qty += (float)esc_attr( $option['price'] );
                                                break;
                                            case '+':
                                                    $total_adjust_price_add += (float)esc_attr( $option['price'] );
                                                break;
                                        }
                                endforeach;

                            break;
                            case 'width_height':
                                $wh_input_unit = $addon['wh_input_unit'];
                                $wh_option_price_unit = $addon['wh_option_price_unit'];
                                $options = $addon['options'];
                                $posted = (isset( $_POST['addon-' . sanitize_title( $addon['name'] )] )) ? $_POST['addon-' . sanitize_title( $addon['name'] )] : '';
                                
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
                                
                                $price  = $price_range_by_with_height_arr[$h_square];
                                
                                $fprice = (($input_width * $input_height) /10000) * $price;
                                
                                switch(esc_attr( $addon['price_type'])){
                                    case 'x':
                                            $total_adjust_price_x_qty += (float)esc_attr( $fprice );
                                        break;
                                    case '+':
                                            $total_adjust_price_add += (float)esc_attr( $fprice );
                                        break;
                                }
                                $cart_item_meta[] = array(
                                    'name' 		=> esc_attr( $addon['name'] ),
                                    'value'		=> esc_attr( stripslashes( trim( $posted ) ) ),
                                    'price'             => esc_attr( $price ),
                                    'price_type' 	=> esc_attr( $addon['price_type'] ),
                                    'addition_info'     => '<p><b>Price: '.woocommerce_price($price).'/'.$wh_option_price_unit.'&sup2;</b><br/><b>+'.woocommerce_price($fprice).'</b></p>'
                                );
                            break;
                    endswitch;

                endforeach;
                
                //$discount_by_quantity_list = get_field('discount_by_quantity_list', $product_id);

                $qty        = isset($_POST['qty']) ? $_POST['qty'] : 1;
                
                $arr_amount = array();

                if($qty < 10){
                    $step = 1;
                }elseif($qty < 25){
                    $step = 5;
                }elseif($qty < 50){
                    $step = 10;
                }elseif($qty < 500){
                    $step = 50;
                }elseif($qty < 1000){
                    $step = 100;
                }elseif($qty < 5000){
                    $step = 500;
                }elseif($qty < 10000){
                    $step = 1000;
                }else{
                    $step = 10000;
                }

                $next_qty = ceil($qty/$step) * $step;

                if($next_qty == $qty){
                    $next_qty = $qty + $step;
                }
                $arr_amount[] = $qty;
                for($j=0;$j<4;$j++){
                    $arr_amount[] = $next_qty + $step * $j; 
                }
                $end_items  = end($product_addons);
                //$arr_amount = array(1,2,3,4,5);
                $html = "<table>";
                $html .= "<thead>";
                $html .= "<tr>";
                $html .= '<th>'. $end_items['name'].'</th>';
                foreach($arr_amount as $amount){
                    $html .= "<th>$amount</th>";
                }
                $html .= "</tr>";                
                
                if($end_items){
                    $options         = $end_items['options'];
                    $last_price_type = $end_items['price_type'];
                    
                    if(count($options)){
                        foreach($options as $option_index => $option){
                            $html .= '<tr>';
                            $html .= '<td>'.$option['label'].' ';
                            $option_price = ($option['price']>0) ? ' (+' . woocommerce_price($option['price']) . ')' : '';
                            $html .= $option_price;
                            $html .= '</td>';
                            foreach($arr_amount as $amount){
                                $single_price = $wc_product->get_price();
                                
                                $temp_total_adjust_price_x_qty = $total_adjust_price_x_qty;
                                $temp_total_adjust_price_add   = $total_adjust_price_add;
                                
                                switch($last_price_type){
                                    case '+':
                                            $temp_total_adjust_price_add += (float)esc_attr($option['price']);
                                        break;
                                    case 'x':
                                            $temp_total_adjust_price_x_qty += (float)esc_attr($option['price']);
                                        break;
                                }                                
                                
                                $price = $amount * ($single_price + $temp_total_adjust_price_x_qty) + $temp_total_adjust_price_add;
                                
                                $format_price = woocommerce_price($price);
                                $html.= "<td class='table-cell-price'>";
                                $html.= '<input type="checkbox" class="slt-table-price" data-price="'.sanitize_title( $option['label'] ).'-'.($option_index + 1).'" data-qty="'.$amount.'"/>';
                                $html.= "<b>{$format_price}</b>";
                                $html.= "</td>";
                            }
                            $html .= '</tr>';
                        }
                    }
                }
                $html.= "</table>";
                // add new addition info to origin product addon field
                if(count($cart_item_meta)):
                    foreach($cart_item_meta as $item_meta){
                        if(isset($item_meta['addition_info']) && $item_meta['addition_info']){
                            $meta_addition_tag = "addon-".sanitize_title($item_meta['name'])."-addition-info";
                            $html.= '<script type="text/javascript">
                                        jQuery(".'.$meta_addition_tag.'").html("'.addslashes($item_meta['addition_info']).'");
                                     </script>';
                        }
                    }
                endif;
            else:
                $html = "";
            endif;
            return $html;
        }        
    }

    new NemprintAjax();
}