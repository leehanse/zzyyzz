<?php
  
// Our case:
// customize display currencies
//     
  
class WCML_CurrencySwitcher{

    function __construct(){
        
        add_action('init', array($this, 'init'), 5);

    }
    
    function init(){        

        add_action('wp_ajax_wcml_currencies_order', array($this,'wcml_currencies_order'));
        add_action('wp_ajax_wcml_currencies_switcher_preview', array($this,'wcml_currencies_switcher_preview'));
    }

    function wcml_currencies_order(){
        if(!wp_verify_nonce($_POST['wcml_nonce'], 'set_currencies_order_nonce')){
            die('Invalid nonce');
        }
        global $woocommerce_wpml;

        $woocommerce_wpml->settings['currencies_order'] = explode(';', $_POST['order']);
        $woocommerce_wpml->update_settings();
        echo json_encode(array('message' => __('Currencies order updated', 'wpml-wcml')));
        die;
    }

    function wcml_currencies_switcher_preview(){
        if(!wp_verify_nonce($_POST['wcml_nonce'], 'wcml_currencies_switcher_preview')){
            die('Invalid nonce');
        }
        global $woocommerce_wpml;

        echo $woocommerce_wpml->multi_currency_support->currency_switcher(array('format' => $_POST['template']?$_POST['template']:'%name% (%symbol%) - %code%','switcher_style' => $_POST['switcher_type'],'orientation'=> $_POST['orientation']));

        die();
    }

}