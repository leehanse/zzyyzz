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
            
            $total_adjust_price    = 0;
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
                                                        'price' 	=> esc_attr( $option['price'] )
                                                );
                                                $total_adjust_price += (float)esc_attr( $option['price'] );

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
                                        'price' 	=> esc_attr( $chosen_option['price'] )
                                );	
                                $total_adjust_price += (float)esc_attr( $chosen_option['price'] );

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
                                                'price' 	=> esc_attr( $option['price'] )
                                        );			
                                        $total_adjust_price += (float)esc_attr( $option['price'] );

                                endforeach;

                            break;						
                    endswitch;

                endforeach;
                
                $qty        = isset($_POST['qty']) ? $_POST['qty'] : 1;
                $arr_amount = array();
                for($j=0;$j<5;$j++){
                    $arr_amount[] = $qty + $j;
                }
                //$arr_amount = array(1,2,3,4,5);
                $html = "<table>";
                $html .= "<thead>";
                $html .= "<tr>";
                $html .= '<th>Paper Type</th>';
                foreach($arr_amount as $amount){
                    $html .= "<th>$amount</th>";
                }
                $html .= "</tr>";                
                $end_items  = end($product_addons);
                if($end_items){
                    $options   = $end_items['options'];
                    if(count($options)){
                        foreach($options as $option){
                            $html .= '<tr>';
                            $html .= '<td>'.$option['label'].' ';
                            $option_price = ($option['price']>0) ? ' (+' . woocommerce_price($option['price']) . ')' : '';
                            $html .= $option_price;
                            $html .= '</td>';
                            foreach($arr_amount as $amount){
                                $single_price = $wc_product->get_price();
                                $price = $amount * ($single_price + $total_adjust_price + (float)esc_attr( $option['price'] ));
                                $format_price = woocommerce_price($price);
                                $html.="<td><b>{$format_price}</b></td>";
                            }
                            $html .= '</tr>';
                        }
                    }
                }
                $html.= "</table>";
            else:
                $html = "";
            endif;
            return $html;
        }        
    }

    new NemprintAjax();
}