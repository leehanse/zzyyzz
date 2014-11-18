<?php
/*
Plugin Name: WooCommerce Filter Variations
Plugin URI: http://facebook.com/mr_leehanse
Description: Filter product variations
Version: 1.1.0
Author: Cong Ngo
Author URI: http://facebook.com/mr_leehanse
License: GPLv2 or later
License URI: http://opensource.org/licenses/GPL-2.0
*/

if ( ! function_exists( 'is_woocommerce_active' ) ) require_once( 'woo-includes/woo-functions.php');
        
if (is_woocommerce_active()) {    
    /**
     * Localisation
     **/
    load_plugin_textdomain('wc_product_filter_variations', false, dirname( plugin_basename( __FILE__ ) ) . '/');
    
    /**
     * woocommerce_product_addons class
     **/
    if (!class_exists('woocommerce_product_filter_variations')) {
     
        class woocommerce_product_filter_variations {
            private $ajax_action = "filterVarations";
            public function __construct() {
                add_action('pre_get_posts', array($this,'pre_get_post_product_variations'));
                add_action('woocommerce_admin_css', array(&$this, 'enqueue_css'));
                add_action('admin_enqueue_scripts', array(&$this, 'enqueue_js'));
                add_action( 'wp_ajax_' . $this->ajax_action, array( $this, 'filterVariations' ) );
            }
            public function enqueue_css(){
                global $typenow;
                if ($typenow=='product') wp_enqueue_style( 'woocommerce_product_filter_variations', plugins_url(basename(dirname(__FILE__))) . '/css/admin.css' );
            }
            public function enqueue_js(){
                global $typenow;
                if ($typenow=='product'){
                        wp_enqueue_script(
                            'woocommerce_product_filter_variations',
                            plugins_url(basename(dirname(__FILE__))) . '/js/ajax.js',
                            array( 'jquery' )
                        );               
                        wp_localize_script(
                            'woocommerce_product_filter_variations', 'productFilterVariationAjax', array(
                            'ajaxurl' => admin_url('admin-ajax.php'),
                            'action'  => $this->ajax_action
                        ));
                }
            }            
            /* Modify first query and add filter top nav to product variations */
            function pre_get_post_product_variations( $query ) {
                global $post;

                if (!is_admin())
                    return $query;

                if($query->get( 'pre_get_post_product_variations' ))
                    return $query;

                if($query->get('post_type')!="product_variation" || $_GET['action']!="edit")
                    return $query;    

                if($_POST['slt_filter_variation']){

                }else{
                    $filter_attributes = array();                    
                    $product= new WC_Product($post->ID);
                    $attributes = $product->get_attributes();
                    if(count($attributes)){
                        $html_filter ='<div id="product_filter_variations_wrapper" style="background-color:#F5F5F5;border-radius:5px;">';
                        $html_filter .= '<input type="hidden" name="filter_variation_product_id" value="'.$post->ID.'"/>';
                        $html_filter .= '<table>';
                        $html_filter .= '<tr>';                                          
                        foreach($attributes as $attribute){
                            $post_terms  = wp_get_post_terms( $post->ID, $attribute['name'] );
                            $first_value = reset($post_terms);

                            $filter_attributes["attribute_".sanitize_title($attribute['name'])] = $first_value->slug;
                            $html_filter .= '<td width="'.(95/count($attributes)).'%">';      
                            $html_filter .= '<select style="width:100% !important;" name="slt_filter_variation[attribute_' . sanitize_title( $attribute['name'] ).']">';
                            $html_filter.= '<option value="">' . __( 'Any', 'woocommerce' ) . ' ' . esc_html( wc_attribute_label( $attribute['name'] ) ) . '&hellip;</option>';
                            foreach ( $post_terms as $term ) {
                                $selected = '';
                                if($term == reset($post_terms)){
                                    if($attribute != end($attributes)) $selected='selected="selected"';
                                }
                                $html_filter.= '<option '.$selected.' value="' . $term->slug . '">' . apply_filters( 'woocommerce_variation_option_name', esc_html( $term->name ) ) . '</option>';
                            }
                            $html_filter.= '</select>';
                            $html_filter.= '</td>';
                        }        
                        $html_filter.= '<td>';
                        $html_filter.= '<a id="product_filter_variation_button" class="button">Filter</a>';
                        $html_filter.= '</td>';
                        $html_filter.= '</tr>';
                        $html_filter.= '</table>';
                        $html_filter.= '</div>';
                        array_pop($filter_attributes);
                        $query->set( 'posts_per_page', -1);

                        $filter_meta_query = array();
                        if(count($filter_attributes)){
                            foreach($filter_attributes as $meta_key => $meta_value){
                                $filter_meta_query[] = array(
                                    "key"   => $meta_key,
                                    "value" => $meta_value
                                );
                            }
                        }
                        $meta_query = array();
                        if(count($filter_meta_query)){
                            $meta_query = $filter_meta_query;
                            $meta_query["relation"] = "AND";
                        }
                        $query->set("meta_query", $meta_query);        
                        echo $html_filter;        
                    }
                }
                return $query;
            }

            function admin_filter_variation_get_html($post_id, $filters = array()){
                $post = get_post($post_id);
                $attributes = maybe_unserialize( get_post_meta( $post->ID, '_product_attributes', true ) );
                $filters = array_filter($filters);
                // See if any are set
                $variation_attribute_found = false;

                if ( $attributes ) {

                    foreach ( $attributes as $attribute ) {

                        if ( isset( $attribute['is_variation'] ) ) {
                            $variation_attribute_found = true;
                            break;
                        }
                    }
                }

                // Get tax classes
                $tax_classes           = array_filter( array_map('trim', explode( "\n", get_option( 'woocommerce_tax_classes' ) ) ) );
                $tax_class_options     = array();
                $tax_class_options[''] = __( 'Standard', 'woocommerce' );

                if ( $tax_classes ) {

                    foreach ( $tax_classes as $class ) {
                        $tax_class_options[ sanitize_title( $class ) ] = esc_attr( $class );
                    }
                }

                $backorder_options = array(
                    'no'     => __( 'Do not allow', 'woocommerce' ),
                    'notify' => __( 'Allow, but notify customer', 'woocommerce' ),
                    'yes'    => __( 'Allow', 'woocommerce' )
                );

                $stock_status_options = array(
                    'instock'    => __( 'In stock', 'woocommerce' ),
                    'outofstock' => __( 'Out of stock', 'woocommerce' )
                );            
                // Get parent data
                $parent_data = array(
                    'id'                   => $post->ID,
                    'attributes'           => $attributes,
                    'tax_class_options'    => $tax_class_options,
                    'sku'                  => get_post_meta( $post->ID, '_sku', true ),
                    'weight'               => wc_format_localized_decimal( get_post_meta( $post->ID, '_weight', true ) ),
                    'length'               => wc_format_localized_decimal( get_post_meta( $post->ID, '_length', true ) ),
                    'width'                => wc_format_localized_decimal( get_post_meta( $post->ID, '_width', true ) ),
                    'height'               => wc_format_localized_decimal( get_post_meta( $post->ID, '_height', true ) ),
                    'tax_class'            => get_post_meta( $post->ID, '_tax_class', true ),
                    'backorder_options'    => $backorder_options,
                    'stock_status_options' => $stock_status_options
                );

                if ( ! $parent_data['weight'] ) {
                    $parent_data['weight'] = wc_format_localized_decimal( 0 );
                }

                if ( ! $parent_data['length'] ) {
                    $parent_data['length'] = wc_format_localized_decimal( 0 );
                }

                if ( ! $parent_data['width'] ) {
                    $parent_data['width'] = wc_format_localized_decimal( 0 );
                }

                if ( ! $parent_data['height'] ) {
                    $parent_data['height'] = wc_format_localized_decimal( 0 );
                }

                // Get variations
                $args = array(
                    'post_type'   => 'product_variation',
                    'post_status' => array( 'private', 'publish' ),
                    'numberposts' => -1,
                    'orderby'     => 'menu_order',
                    'order'       => 'asc',
                    'post_parent' => $post->ID                                                
                );
                $filter_meta_query = array();
                if(count($filters)){
                    foreach($filters as $meta_key => $meta_value){
                        $filter_meta_query[] = array(
                            "key"   => $meta_key,
                            "value" => $meta_value
                        );
                    }
                }

                if(count($filter_meta_query)){
                    $args["meta_query"] = $filter_meta_query;
                    $args["meta_query"]["relation"] = "AND";
                }
                $variations = get_posts( $args );
                $loop = 0;

                if ( $variations ) {

                    foreach ( $variations as $variation ) {

                        $variation_id                        = absint( $variation->ID );
                        $variation_post_status               = esc_attr( $variation->post_status );
                        $variation_data                      = get_post_meta( $variation_id );
                        $variation_data['variation_post_id'] = $variation_id;

                        // Grab shipping classes
                        $shipping_classes = get_the_terms( $variation_id, 'product_shipping_class' );
                        $shipping_class   = ( $shipping_classes && ! is_wp_error( $shipping_classes ) ) ? current( $shipping_classes )->term_id : '';

                        $variation_fields = array(
                            '_sku',
                            '_stock',
                            '_regular_price',
                            '_sale_price',
                            '_weight',
                            '_length',
                            '_width',
                            '_height',
                            '_download_limit',
                            '_download_expiry',
                            '_downloadable_files',
                            '_downloadable',
                            '_virtual',
                            '_thumbnail_id',
                            '_sale_price_dates_from',
                            '_sale_price_dates_to',
                            '_manage_stock',
                            '_stock_status'
                        );

                        foreach ( $variation_fields as $field ) {
                            $$field = isset( $variation_data[ $field ][0] ) ? maybe_unserialize( $variation_data[ $field ][0] ) : '';
                        }

                        $_backorders = isset( $variation_data['_backorders'][0] ) ? $variation_data['_backorders'][0] : null;
                        $_tax_class  = isset( $variation_data['_tax_class'][0] ) ? $variation_data['_tax_class'][0] : null;
                        $image_id    = absint( $_thumbnail_id );
                        $image       = $image_id ? wp_get_attachment_thumb_url( $image_id ) : '';

                        // Locale formatting
                        $_regular_price = wc_format_localized_price( $_regular_price );
                        $_sale_price    = wc_format_localized_price( $_sale_price );
                        $_weight        = wc_format_localized_decimal( $_weight );
                        $_length        = wc_format_localized_decimal( $_length );
                        $_width         = wc_format_localized_decimal( $_width );
                        $_height        = wc_format_localized_decimal( $_height );

                        // Stock BW compat
                        if ( '' !== $_stock ) {
                            $_manage_stock = 'yes';
                        }

                        include($dir = ABSPATH . 'wp-content/plugins/woocommerce/includes/admin/meta-boxes/views/html-variation-admin.php' );

                        $loop++;
                    }
                }
            }

            public function filterVariations(){
                $slt_filter_variation = $_POST['slt_filter_variation'];
                $product_id           = $_POST['filter_variation_product_id'];
                global $post;
                $post                 = get_post($product_id);
                $this->admin_filter_variation_get_html($product_id, $slt_filter_variation);
                die;
            }
        }

        $woocommerce_product_filter_variations = new woocommerce_product_filter_variations();
    }
}
