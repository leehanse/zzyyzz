<?php
if ( ! class_exists( 'VinaprintAjax' ) ) {
    class VinaprintAjax {

        private $actions = array(
                'calculateTablePrice',
                'getWidthHeightPrice'
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
                    break;
                case 'getWidthHeightPrice':
                        $select_addons  = $_POST['addons'];
                        $qty            = $_POST['qty'];
                        $product_id     = $_POST['product_id'];
                        
                        $cart_item_meta = getAddonCartItemMeta($product_id, $qty , $select_addons);
                        echo json_encode($cart_item_meta);
                        die;
                        //calculatePriceCell($product_id, 1, $select_attributes = array(), $select_addons = array(), $available_variations = null, $product_addons = null);
                    break;
                default:
                        echo 'No ajax action found';
                    die;
                    break;
            }
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
                            $price = calculatePriceCell($product_id, $amount, $tmp_select_attributes, $tmp_select_addons, $available_variations, $product_addons);
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
                if(is_array($product_addons) && count($product_addons)){ // product addons -> remove lass select addon to build table price
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
                                $price = calculatePriceCell($product_id, $amount, $tmp_select_attributes, $tmp_select_addons, $available_variations, $product_addons);
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
                    return '<p class="error">'.__( 'This product is currently out of stock and unavailable.', 'woocommerce' ).'</p>';
                }
            }
            
               
            return $html;
        }
    }

    new VinaprintAjax();
}