<?php

class WCML_WC_Strings{
    
    function __construct(){
        
        add_action('init', array($this, 'init'));
        add_action('plugins_loaded', array($this, 'pre_init'));
        add_filter('query_vars', array($this, 'translate_query_var_for_product'));
        add_filter('wp_redirect', array($this, 'encode_shop_slug'),10,2);
        
    }

    function pre_init(){
        // Slug translation
        add_filter('gettext_with_context', array($this, 'translate_default_slug'), 2, 4);
    }
    
    function init(){
        global $pagenow;
         
        add_filter('woocommerce_package_rates', array($this, 'register_shipping_methods'));
        add_action('option_woocommerce_tax_rates', array($this, 'translate_tax_rates'));
        
        add_filter('woocommerce_gateway_title', array($this, 'translate_gateway_title'), 10, 2);
        add_filter('woocommerce_gateway_description', array($this, 'translate_gateway_description'), 10, 2);
        add_action( 'woocommerce_thankyou_bacs', array( $this, 'translate_bacs_instructions' ),9 );
        add_action( 'woocommerce_thankyou_cheque', array( $this, 'translate_cheque_instructions' ),9 );
        add_action( 'woocommerce_thankyou_cod', array( $this, 'translate_cod_instructions' ),9 );
        //translate attribute label
        add_filter('woocommerce_attribute_label',array($this,'translated_attribute_label'),10,2);
        add_filter('woocommerce_cart_item_name',array($this,'translated_cart_item_name'),10,3);
        add_filter('woocommerce_checkout_product_title',array($this,'translated_checkout_product_title'),10,2);
        add_filter('woocommerce_countries_tax_or_vat', array($this, 'register_tax_label'));
        
        if(is_admin() && $pagenow == 'options-permalink.php'){
            add_filter('gettext_with_context', array($this, 'category_base_in_strings_language'), 99, 3);
            add_action('admin_footer', array($this, 'show_custom_url_base_language_requirement'));    
        }
        
        if(is_admin() && $pagenow == 'edit.php' && isset($_GET['page']) && $_GET['page'] == 'woocommerce_attributes'){
            add_action('admin_footer', array($this, 'show_attribute_label_language_warning'));    
        }
        
        add_filter('woocommerce_rate_label',array($this,'translate_woocommerce_rate_label'));
        
        add_action( 'woocommerce_before_template_part', array( $this, 'woocommerce_before_template_part' ), 10, 4 );
        
        add_action( 'woocommerce_product_options_attributes', array ( $this, 'notice_after_woocommerce_product_options_attributes' ) );
    }
    
    function translated_attribute_label($label, $name){
        global $sitepress;

        if(is_admin() && !wpml_is_ajax()){
            global $wpdb,$sitepress_settings;

            $string_id = icl_get_string_id('taxonomy singular name: '.$label,'WordPress');

            if ( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {
                $strings_language = icl_st_get_string_language( $string_id );
            }else{
                $strings_language = $sitepress_settings['st']['strings_language'];
            }

            if($string_id && $sitepress_settings['admin_default_language'] != $strings_language){
                $string = $wpdb->get_var($wpdb->prepare("SELECT value FROM {$wpdb->prefix}icl_string_translations WHERE string_id = %s and language = %s", $string_id, $sitepress_settings['admin_default_language']));
                if($string){
                    return $string;
                }
            }else{
                return $label;
            }

        }
        $name = sanitize_title($name);
        $lang = $sitepress->get_current_language();
        $trnsl_labels = get_option('wcml_custom_attr_translations');

        if(isset($trnsl_labels[$lang][$name])){
            return $trnsl_labels[$lang][$name];
        }

        return icl_t('WordPress','taxonomy singular name: '.$label,$label);
    }

    function translated_cart_item_name($title, $values, $cart_item_key){

        $parent = $values['data']->post->post_parent;
        if($values){
            $tr_product_id = icl_object_id( $values['product_id'], 'product', true );
            $title = get_the_title($tr_product_id);    
            
            if($parent){
                $tr_parent = icl_object_id( $parent, 'product', true );
                $title = get_the_title( $tr_parent ) . ' &rarr; ' . $title;    
            }
            
            
            $title = sprintf( '<a href="%s">%s</a>', $values['data']->get_permalink(), $title );
                        
        }
        return $title;
    }

    function translated_checkout_product_title($title,$product){
        global $sitepress;
        if(isset($product->id)){
            $tr_product_id = icl_object_id($product->id,'product',true,$sitepress->get_current_language());
            $title = get_the_title($tr_product_id);
        }
        return $title;
    }
    
    
    function translate_query_var_for_product($public_query_vars){ 
        global $wpdb, $sitepress, $sitepress_settings;

        $strings_language = $this->get_wc_context_language();

        if($sitepress->get_current_language() != $strings_language){
            $product_permalink  = $this->product_permalink_slug();

            $translated_slug = $this->get_translated_product_base_by_lang(false,$product_permalink);
            
            if(isset($_GET[$translated_slug])){
                $buff = $_GET[$translated_slug];
                unset($_GET[$translated_slug]);
                $_GET[$product_permalink] = $buff;
            }
            
        }
        
        return $public_query_vars;
    }
    
    function get_translated_product_base_by_lang($language = false, $product_permalink = false){
        if(!$language){
            global $sitepress;
            $language = $sitepress->get_current_language();

        }

        if(!$product_permalink){
            $product_permalink  = $this->product_permalink_slug();
        }

        global $wpdb;

        $translated_slug = $wpdb->get_var($wpdb->prepare("
                SELECT t.value FROM {$wpdb->prefix}icl_string_translations t
                JOIN {$wpdb->prefix}icl_strings s ON t.string_id = s.id
                WHERE s.name=%s AND s.value = %s AND t.language = %s AND t.status = %d",
            'URL slug: ' . $product_permalink, $product_permalink, $language, ICL_STRING_TRANSLATION_COMPLETE ));

        return $translated_slug;

    }

    // Catch the default slugs for translation
    function translate_default_slug($translation, $text, $context, $domain) {
        global $sitepress_settings, $sitepress;

        if ($context == 'slug' || $context == 'default-slug') {
            $wc_slug = get_option('woocommerce_product_slug') != false ? get_option('woocommerce_product_slug') : 'product';
            if(is_admin()){
                $admin_language = $sitepress->get_admin_language();
            }
            $current_language = $sitepress->get_current_language();
            $strings_language = false;
            if ( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {
                $context_ob = icl_st_get_context( 'URL slugs - product' );
                if($context_ob){
                    $strings_language = $context_ob->language;
                }
            }elseif(isset($sitepress_settings['st'])){
                $strings_language = $sitepress_settings['st']['strings_language'];
            }

            if ($text == $wc_slug && $domain == 'woocommerce' && $strings_language) {
                $sitepress->switch_lang($strings_language);
                $translation = _x($text, 'URL slug', $domain);
                $sitepress->switch_lang($current_language);
                if(is_admin()){
                    $sitepress->set_admin_language($admin_language);
                }
            }else{
               $translation = $text;
            }

            if(!is_admin()){
                $sitepress->switch_lang($current_language);
            }
        }

        return $translation;

    }

    function register_shipping_methods($available_methods){
        foreach($available_methods as $method){
            $method->label = icl_translate('woocommerce', $method->label .'_shipping_method_title', $method->label);
        }

        return $available_methods;
    }

    function translate_tax_rates($rates){
        if (!empty($rates)) {
            foreach ($rates as &$rate) {
                $rate['label'] = icl_translate('woocommerce', 'tax_label_' . esc_url_raw($rate['label']), $rate['label']);
            }
        }

        return $rates;
    }

    function translate_gateway_title($title, $gateway_title) {
        if (function_exists('icl_translate')) {
            $title = icl_translate('woocommerce', $gateway_title .'_gateway_title', $title);
        }
        return $title;
    }

    function translate_gateway_description($description, $gateway_title) {
        if (function_exists('icl_translate')) {
            $description = icl_translate('woocommerce', $gateway_title .'_gateway_description', $description);
        }
        return $description;
    }

    function translate_bacs_instructions(){
        $this->translate_payment_instructions('bacs');
    }

    function translate_cheque_instructions(){
        $this->translate_payment_instructions('cheque');
    }

    function translate_cod_instructions(){
        $this->translate_payment_instructions('cod');
    }

    function translate_payment_instructions($id){
        if (function_exists('icl_translate')) {
            $gateways = WC()->payment_gateways();
            foreach($gateways->payment_gateways as $key => $gateway){
                if($gateway->id == $id && isset(WC_Payment_Gateways::instance()->payment_gateways[$key]->instructions)){
                    WC_Payment_Gateways::instance()->payment_gateways[$key]->instructions = icl_translate('woocommerce', $gateway->id .'_gateway_instructions', $gateway->instructions);
                    break;
                }
            }
        }
    }

    function register_tax_label($label){
        global $sitepress;

        if(function_exists('icl_translate')){
            $label = icl_translate('woocommerce', 'VAT_tax_label', $label);
        }

        return $label;
    }

    function show_custom_url_base_language_requirement(){
        global $sitepress_settings, $sitepress;

        echo '<div id="wpml_wcml_custom_base_req" style="display:none"><br /><i>';
        if( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '<' )){
            $strings_language = $sitepress->get_language_details($sitepress_settings['st']['strings_language']);
            echo sprintf(__('Please enter string in %s (the strings language)', 'wpml-wcml'), '<strong>' . $strings_language['display_name'] . '</strong>');
        }
        echo '</i></div>';
        ?>
        <script>
            if(jQuery('#woocommerce_permalink_structure').length){
                jQuery('#woocommerce_permalink_structure').parent().append(jQuery('#wpml_wcml_custom_base_req').html());
            }
            if(jQuery('input[name="woocommerce_product_category_slug"]').length){
                jQuery('input[name="woocommerce_product_category_slug"]').parent().append('<br><i><?php _e('Please use a different product category base than "category"', 'wpml-wcml') ?></i>');
            }
        </script>
        <?php

    }

    function show_attribute_label_language_warning(){
        global $sitepress_settings, $sitepress;

        if(defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '<' ) && $sitepress_settings['st']['strings_language'] != $sitepress->get_default_language()){
            $default_language = $sitepress->get_language_details($sitepress->get_default_language());
            $strings_language = $sitepress->get_language_details($sitepress_settings['st']['strings_language']);
            echo '<div id="wpml_wcml_attr_language" style="display:none"><div class="icl_cyan_box"><i>';
            echo sprintf(__("You need to enter attribute names in %s (even though your site's default language is %s). Then, translate it to %s and the rest of the site's languages using in the %sWooCommerce Multlingual admin%s.", 'wpml-wcml'),
                 $strings_language['display_name'],
                 $default_language['display_name'],  $default_language['display_name'],
                '<strong><a href="' . admin_url('admin.php?page=wpml-wcml') . '">', '</a></strong>');
            echo '</i></div><br /></div>';
            ?>
            <script>
                if(jQuery('#attribute_label').length){
                    jQuery('#attribute_label').parent().prepend(jQuery('#wpml_wcml_attr_language').html());
                }
            </script>
            <?php

        }

    }


    function translate_woocommerce_rate_label($label){
        if (function_exists('icl_translate')) {
            $label = icl_translate('woocommerce taxes', $label , $label);
        }
        return $label;
    }

    function category_base_in_strings_language($text, $original_value, $context){
        if($context == 'slug' && ($original_value == 'product-category' || $original_value == 'product-tag')){
            $text = $original_value;
        }
        return $text;
    }

    function encode_shop_slug($location, $status){
        if(get_post_type(get_query_var('p')) == 'product'){
            global $sitepress;
            $language = $sitepress->get_language_for_element(get_query_var('p'), 'post_product');
            $base_slug = $this->get_translated_product_base_by_lang($language);

            $location = str_replace($base_slug , urlencode($base_slug),$location);
        }
        return $location;
    }


    function get_missed_product_slag_translations_languages(){
        global $sitepress,$wpdb,$sitepress_settings;

        $slug = $this->product_permalink_slug();
        $default_language = $sitepress->get_default_language();

        $slug_translation_languages = $wpdb->get_col($wpdb->prepare("SELECT tr.language FROM {$wpdb->prefix}icl_strings AS s LEFT JOIN {$wpdb->prefix}icl_string_translations AS tr ON s.id = tr.string_id WHERE s.name = %s AND s.value = %s AND tr.status = %s", 'URL slug: ' . $slug, $slug, ICL_STRING_TRANSLATION_COMPLETE));
        $miss_slug_lang = array();

        if ( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {

            $context_ob = icl_st_get_context( 'WordPress' );
            if($context_ob){
                $strings_language = $context_ob->language;
            }else{
                $strings_language = false;
            }
        }else{
            $strings_language = $sitepress_settings['st']['strings_language'];
        }

        foreach( $sitepress->get_active_languages() as $lang_info ){
            if( !in_array( $lang_info['code'], $slug_translation_languages ) && $lang_info['code'] != $strings_language ){
                $miss_slug_lang[] = ucfirst($lang_info['display_name']);
            }
        }

        return $miss_slug_lang;
    }


    function product_permalink_slug(){
        $permalinks         = get_option( 'woocommerce_permalinks' );
        $slug = empty( $permalinks['product_base'] ) ? 'product' : trim($permalinks['product_base'], '/');

        return $slug;
    }

    function get_wc_context_language(){

        if ( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {

            $context_ob = icl_st_get_context( 'plugin woocommerce' );
            if($context_ob){
                $context_language = $context_ob->language;
            }else{
                $context_language = false;
            }

            return $context_language;
        }else{
            global $sitepress_settings;

            return $sitepress_settings['st']['strings_language'];
        }

    }


    /*
     * Add filter before include global/breadcrumb.php template
     *
     */
    function woocommerce_before_template_part( $template_name, $template_path, $located, $args ){
        if( $template_name == 'global/breadcrumb.php'){
            add_filter('option_woocommerce_permalinks', array($this, 'filter_woocommerce_permalinks_option_breadcrumb_page' ), 11 );
        }

    }


    /*
     * Filter product base only on global/breadcrumb.php template page
     *
     */
    function filter_woocommerce_permalinks_option_breadcrumb_page( $value ){
        global $sitepress;

        if(isset($value['product_base']) && !is_admin() && $sitepress->get_current_language() != $this->get_wc_context_language() ){
            remove_filter('option_woocommerce_permalinks', array($this, 'filter_woocommerce_permalinks_option_breadcrumb_page'), 11);
            $value['product_base'] = '/'.strtolower(urlencode($this->get_translated_product_base_by_lang()));

        }

        return $value;

    }

    /*
     * Add notice message to users
     */
    function notice_after_woocommerce_product_options_attributes(){
        global $sitepress;

        if( isset( $_GET['post'] ) && $sitepress->get_default_language() != $sitepress->get_current_language() ){
            $original_product_id = icl_object_id( $_GET['post'], 'product', true, $sitepress->get_default_language() );

            printf( '<p>'.__('In order to edit custom attributes you need to use the <a href="%s">custom product translation editor</a>', 'wpml-wcml').'</p>', admin_url('admin.php?page=wpml-wcml&tab=products&prid='.$original_product_id ) );
        }
    }
}