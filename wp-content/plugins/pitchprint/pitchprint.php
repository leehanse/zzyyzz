<?php 
        /*
        Plugin Name: PitchPrint
        Plugin URI: http://www.pitchprint.com
        Description: Plugin for integrating PitchPrint design app into WooCommerce
        Author: Isaac O. Coker
        Version: 7.1.1
        Author URI: http://www.pitchprint.com
        */
	if (!session_id()) session_start();	
	include('system/settings.php');

    define('SERVER_URLPATH', '//pitchprint.net');

	function pp_admin_actions() {
		add_menu_page( 'PitchPrint', 'PitchPrint', 'manage_options', 'w2p', 'show_w2p_admin');		
    }
	add_filter('woocommerce_add_cart_item_data', 'w2p_add_cart_item_data', 10, 2);
	add_filter('woocommerce_add_order_item_meta', 'w2p_add_order_item_meta', 10, 2);
	add_filter('woocommerce_get_cart_item_from_session', 'w2p_get_cart_item_from_session', 10, 2);
	add_filter('woocommerce_get_item_data', 'w2p_get_cart_mod', 10, 2);
	add_filter('woocommerce_single_product_image_html', 'w2p_change_image_url', 10, 2);
	add_filter('woocommerce_cart_item_thumbnail', 'w2p_cart_thumbnail', 10, 2);
		
    add_action('woocommerce_after_cart', 'w2p_get_cart_action');
    add_action('admin_menu', 'pp_admin_actions');
    add_action('wp_head', 'w2p_header_files');
	add_action('admin_head', 'w2p_admin_header_files');
	add_action('woocommerce_product_options_pricing', 'add_w2p_admin_tab');
	add_action('woocommerce_process_product_meta', 'write_panel_save');
	add_action('woocommerce_before_add_to_cart_button', 'add_w2p_edit_button');
	add_action('woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1);
    add_filter('woocommerce_before_my_account', 'my_recent_order');
	
	function w2p_header_files() {
		global $post, $product;
		$_w2p_set_option = get_post_meta($post->ID, '_w2p_set_option', true);
		if (!empty($_w2p_set_option)) {
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-selectable');
			wp_enqueue_script('pitchprint_editor', SERVER_URLPATH.'/javascripts/pitchprint.min.js');
			wp_enqueue_script('pitchprint_class', SERVER_URLPATH.'/javascripts/pp_wordpress.js');
		}
	}
	function w2p_admin_header_files() {
		wp_enqueue_script('pitchprint_admin', SERVER_URLPATH.'/javascripts/pp_wordpress_admin.js');
		$timestamp = time();
		$signature = md5(PITCH_APIKEY . PITCH_SECRETKEY . $timestamp);
		wc_enqueue_js("w2p_renderings_path = '" . plugins_url('image/data/renderings/', __FILE__) . "'; w2p_credentials = {timestamp:'" . $timestamp . "', apiKey:'" . PITCH_APIKEY . "', signature:'" . $signature . "'};");
	}
    function my_recent_order() {
        global $post, $woocommerce;
        wp_enqueue_script('pitchprint_class', SERVER_URLPATH.'/javascripts/pp_wordpress.js');
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
        wp_enqueue_script('prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
        wp_enqueue_script('prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery' ), $woocommerce->version, true );
        wp_enqueue_style('woocommerce_prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css' );
        
        echo '<div id="mydesigns_div"></div>';
        wc_enqueue_js(" w2p_pppluginroot='".plugins_url('/', __FILE__)."'; _w2p_apikey='".PITCH_APIKEY."'; _w2p_language_id='" . substr(get_bloginfo('language'), 0, 2) . "'; _w2p_uid='" . get_current_user_id() . "'; fetchUserDesigns();");
    }
	function add_w2p_admin_tab() {
		global $post, $woocommerce;
        echo '</div><div class="options_group show_if_simple show_if_variable"><input type="hidden" value="' . get_post_meta( $post->ID, '_w2p_set_option', true ) . '" id="w2p_values" name="w2p_values" >';
		
        $w2p_upload_selected_option = '';
		$w2p_selected_option = get_post_meta( $post->ID, '_w2p_set_option', true );
        $w2p_selected_option = explode(':', $w2p_selected_option);
        if (count($w2p_selected_option) === 2) {
            $w2p_upload_selected_option = ($w2p_selected_option[1] === '1' ? 'checked' : '');
        }
        
		woocommerce_wp_select( array(
				'id'            => 'w2p_pick',
				'value'			=>	$w2p_selected_option[0],
				'wrapper_class' => '',
				'options'       => array('' => 'None'),
				'label'         => 'PitchPrint Design',
				'desc_tip'    	=> true,
				'description' 	=> 'Visit the PitchPrint Admin Panel to create and edit designs'
			) );
        woocommerce_wp_checkbox( array(
				'id'            => 'w2p_pick_upload',
				'value'		    => $w2p_upload_selected_option,
                'cbvalue'		=> 'checked',
                'description' 	=> '&#8678; Check this to enable clients upload their files.'
			) );
		wc_enqueue_js("w2p_selected_option = '" . $w2p_selected_option[0] . "'; 	fetchDesigns();");
	}
	function write_panel_save( $post_id ) {
		$_w2p_set_option = $_POST['w2p_values'];
		update_post_meta( $post_id, '_w2p_set_option', $_w2p_set_option );
	}
	function w2p_add_cart_item_data($cart_item_meta, $product_id) {
		if (isset($_SESSION['w2p_projects'])) {
			if (isset($_SESSION['w2p_projects'][$product_id])) {
                if (isset($_SESSION['w2p_projects'][$product_id]['upload'])) {
                    $cart_item_meta['_w2p_set_option'] = '_@w2p@_|' . $_SESSION['w2p_projects'][$product_id]['uid'] . '|u|' . $_SESSION['w2p_projects'][$product_id]['upload'] . '|' . $_SESSION['w2p_projects'][$product_id]['previews'];
                } else {
				    $cart_item_meta['_w2p_set_option'] = '_@w2p@_|' . $_SESSION['w2p_projects'][$product_id]['uid'] . '|' . $_SESSION['w2p_projects'][$product_id]['projectid'] . '|' . $_SESSION['w2p_projects'][$product_id]['previews'] . '|' . $_SESSION['w2p_projects'][$product_id]['renderings'];
                }
				unset($_SESSION['w2p_projects'][$product_id]);
			}
		}
		return $cart_item_meta;
	}
	function w2p_add_order_item_meta($item_id, $cart_item) {
		global $woocommerce;
		if (!empty($cart_item['_w2p_set_option'])) woocommerce_add_order_item_meta($item_id, '_w2p_set_option', $cart_item['_w2p_set_option']);
	}
	function w2p_get_cart_item_from_session($cart_item, $values) {
		if (!empty($values['_w2p_set_option'])) $cart_item['_w2p_set_option'] = $values['_w2p_set_option'];
		return $cart_item;
	}
    function w2p_cart_thumbnail($img, $val) {
        if (!empty($val['_w2p_set_option'])) {
            $itm = $val['_w2p_set_option'];
            $itm = explode('|', $itm);
            if ($itm[2] !== 'u') {
                $prev = explode(',',$itm[3]);
                $prev = plugins_url('/', __FILE__) . 'image/data/previews/' . $prev[0];
                $img = '<img width="90" src="'.$prev.'" >';
            }
        }
        
        return $img;
    }
    function w2p_get_cart_action() {
        global $post, $woocommerce;
        wp_enqueue_script('pitchprint_class', SERVER_URLPATH.'/javascripts/pp_wordpress.js');
        wc_enqueue_js(" w2p_pppluginroot='".plugins_url('/', __FILE__)."'; _w2p_apikey='".PITCH_APIKEY."'; _w2p_language_id='" . substr(get_bloginfo('language'), 0, 2) . "'; _w2p_uid='" . get_current_user_id() . "'; jQuery(document).ready(function () { modCartPage(); }) ");
    }
	function w2p_get_cart_mod( $item_data, $cart_item ) {
		if (!empty($cart_item['_w2p_set_option'])) {
            $val = $cart_item['_w2p_set_option'];
            $val = explode('|', $val);
			$item_data[] = array(
				'name'    => '<span id="w2p-data-'.($val[2]==='u'?'file_upload':'design').'">Custom Design</span>',
				'display' => '&nbsp;&nbsp;<img style="width:14px; height:14px" src="'.plugins_url('/', __FILE__).'image/ok.png" border="0" >' . ($val[2]==='u' ? '' : '&nbsp;&nbsp; <a class="button" id="w2p-data-duplicate_design" href="'.$cart_item['_w2p_set_option'].'|'.$cart_item['product_id'].'" >Copy Design</a>')
			);
        }
		return $item_data;
	}
	function remove_add_to_cart_buttons() {
		//Function to remove add to cart button on the shop page...
		global $product;
		global $woocommerce;
		$_w2p_set_option = get_post_meta($product->id, '_w2p_set_option', true);
		if ($_w2p_set_option != '') {
			$handler = apply_filters('woocommerce_add_to_cart_handler', $product->product_type, $product);
			if ($handler != 'variable' && $handler != 'grouped' && $handler != 'external') {
				if ($product->is_purchasable()) {
					wc_enqueue_js("change_addtocart_button('{$product->id}', '{$product->get_sku()}', '" . apply_filters( 'not_purchasable_url', get_permalink($product->id) ) . "', '" . apply_filters( 'not_purchasable_text', __( 'Read More', 'woocommerce' ) ) . "');");
				}
			}
		}
	}
	function add_w2p_edit_button() {
		global $post;
		global $woocommerce;
		$_w2p_mode = 'new';
		$_w2p_set_option = get_post_meta( $post->ID, '_w2p_set_option', true );
        if (strpos($_w2p_set_option, ':') === false) $_w2p_set_option = $_w2p_set_option . ':0';
        $_w2p_set_option = explode(':', $_w2p_set_option);
		$_w2p_edit_label = '';
		$_w2p_project_id = '';
		$_w2p_uid = get_current_user_id();
		$_w2p_now_value = '';
        $_w2p_upload_ready = false;
		
		if (!isset($_SESSION)) session_start();
		if (isset($_SESSION['w2p_projects'])) {		
			if (isset($_SESSION['w2p_projects'][$post->ID])) {
                if (isset($_SESSION['w2p_projects'][$post->ID]['upload'])) {
                    $_w2p_now_value = '_@w2p@_|' . $_w2p_uid . '|u|' . $_SESSION['w2p_projects'][$post->ID]['upload'] . '|' . $_SESSION['w2p_projects'][$post->ID]['previews'];
                    $_w2p_previews = $_SESSION['w2p_projects'][$post->ID]['previews'];
                    $_w2p_upload_ready = true;
                } else if (isset($_SESSION['w2p_projects'][$post->ID]['projectid'])) {
                    $_w2p_mode = 'edit';
                    $_w2p_project_id = $_SESSION['w2p_projects'][$post->ID]['projectid'];
                    //$_w2p_uid = $_SESSION['w2p_projects'][$post->ID]['uid'];
                    $_w2p_now_value = '_@w2p@_|' . $_w2p_uid . '|' . $_w2p_project_id . '|' . $_SESSION['w2p_projects'][$post->ID]['previews'] . '|' . $_SESSION['w2p_projects'][$post->ID]['renderings'];
                    $_w2p_previews = explode(',', $_SESSION['w2p_projects'][$post->ID]['previews']);
                    array_walk($_w2p_previews, 'w2p_prepend_path');
                    $_w2p_previews = implode(',', $_w2p_previews);
                }
			}
		}
		
		wc_enqueue_js("_w2p_mode = '" . $_w2p_mode . "';  _w2p_url_prefix = '" . plugins_url('/', __FILE__) . "';  _w2p_language_id = '" . substr(get_bloginfo('language'), 0, 2) . "'; _w2p_upload=" . $_w2p_set_option[1] . ";   _w2p_designid = '" . $_w2p_set_option[0] . "';  _w2p_apikey = '" . PITCH_APIKEY . "';  _w2p_productid = '" . $post->ID . "'; _w2p_productname = '" . $post->post_name . "'; _w2p_edit_button_label = '" . $_w2p_edit_label . "'; _w2p_projectid = '" . $_w2p_project_id . "'; _w2p_uid = '" . $_w2p_uid . "'; _w2p_previews = ('" . $_w2p_previews . "').split(',');");
				
        echo '<input type="hidden" id="_w2p_set_option" name="_w2p_set_option" value="' . $_w2p_now_value . '" /> ';
        
		if ($_w2p_set_option[0] != '' && $_w2p_upload_ready === false) {
			echo '<div id="w2p-btns" style="padding-bottom:10px; padding-top:10px; visibility:hidden">';
			echo '<input w2p-action="' . $_w2p_mode . '" w2p-data="' . (($_w2p_mode == 'new') ? 'customize_design' : 'edit_design') . '" type="button" onclick="" class="w2p_button" id="w2p_button" value=""> ';
			echo '<input type="button" id="w2p_previewsbtn" w2p-data="view_design" value="" /> ';
			echo '<img style="cursor: pointer; display:none" title="Click to clear the design" src="' . plugins_url('image/', __FILE__) . 'clear_design.png" border="0" id="w2p_clear_img" />';
			echo '</div>';
			
			if (is_user_logged_in()) {
				global $current_user;
				get_currentuserinfo();
				wc_enqueue_js("_w2p_userData = {email:'" . $current_user->user_email . "', name:'" . $current_user->display_name . "'};");
			}
			
			wc_enqueue_js("w2p_setUpEditor(); w2p_setProductPref();");
		}
        
        wc_enqueue_js("_w2p_uploadurl='". plugins_url('uploader/', __FILE__) ."'; w2p_pppluginroot='".plugins_url('/', __FILE__)."';");
        
        if ($_w2p_set_option[1] == "1" && $_w2p_mode !== 'edit') {
            echo '<div id="w2p-btns" style="padding-bottom:20px;"><input type="button" onclick="showUploadPanel()" id="w2p_show_upload_btn" w2p-data="'. ($_w2p_upload_ready === true ? 'files_ok' : 'upload_files') .'" value="" /></div>';
        }
	}
	function w2p_prepend_path( & $itm, $key) {
		$itm = plugins_url('image/data/previews/', __FILE__) . $itm;
	}
	function w2p_change_image_url($url, $product_id) {
		global $woocommerce;
		if (isset($_SESSION['w2p_projects'])) {
			if (isset($_SESSION['w2p_projects'][$product_id])) { 
				$previews = $_SESSION['w2p_projects'][$product_id]['previews'];
				$previews = explode(',', $previews);
				$woocommerce->add_inline_js("woo_defaultImage_size = '" . apply_filters('single_product_large_thumbnail_size', 'shop_single') . "'; 
				w2p_swap_main_image('" . (isset($_SESSION['w2p_projects'][$product_id]['upload']) ? '' : plugins_url('image/data/previews/', __FILE__)) . "{$previews[0]}', '" . implode(',', $previews) . "', '" . (isset($_SESSION['w2p_projects'][$product_id]['upload']) ? '' : plugins_url('image/data/previews/', __FILE__)) . "');");
			}
		}
		return $url;
	}

	function show_w2p_admin() {
		$issues = '';
		$PITCH_APIKEY = defined('PITCH_APIKEY') ? PITCH_APIKEY : '';
		$PITCH_SECRETKEY = defined('PITCH_SECRETKEY') ? PITCH_SECRETKEY : '';
		
		if (!is_writable(plugin_dir_path(__FILE__) . 'image/data/previews')) {
			$issues .= '<br/><br/>Sorry, the folder "' . plugin_dir_path(__FILE__) . 'image/data/previews/" is not writable.';
		}
		if (!is_writable(plugin_dir_path(__FILE__) . 'image/data/renderings')) {
			$issues .= '<br/><br/>Sorry, the folder "' . plugin_dir_path(__FILE__) . 'image/data/renderings/" is not writable.';
		}
		if (!is_writable(plugin_dir_path(__FILE__) . 'system/settings.php')) {
			$issues .= '<br/><br/>Sorry, the file "' . plugin_dir_path(__FILE__) . 'system/settings.php" is not writable.';
		}
		
		if (isset($_POST['_w2p_inpt_apiKey']) && isset($_POST['_w2p_inpt_secretKey']) && $issues === '') {
			if (!empty($_POST['_w2p_inpt_apiKey']) && !empty($_POST['_w2p_inpt_secretKey'])) {
				$str = "<?php define('PITCH_APIKEY', '{$_POST['_w2p_inpt_apiKey']}');     define('PITCH_SECRETKEY', '{$_POST['_w2p_inpt_secretKey']}'); ?>";
				$handle = fopen(plugin_dir_path(__FILE__)."system/settings.php", "wb");
				fwrite($handle, $str);
				fclose($handle);
				$PITCH_APIKEY = $_POST['_w2p_inpt_apiKey'];
				$PITCH_SECRETKEY = $_POST['_w2p_inpt_secretKey'];
			}
		}
		if ($issues !== '') {
			echo '<div class="wrap" style="color:#F00">' . $issues . '</div>';
			exit();
		}
		
		echo '<div class="wrap">
				<div style="margin-top:20px; font-size:16px"><br/><b>PITCHPRINT SETTINGS:</b><br/></div><div style="margin:20px;">
				<form method="post" action="">
					<label style="display:inline-block; width:120px">API KEY:</label> <input style="width:280px" name="_w2p_inpt_apiKey" type="text" value="' . $PITCH_APIKEY . '" /><br/>
					<label style="display:inline-block; width:120px">SECRET KEY:</label> <input style="width:280px" name="_w2p_inpt_secretKey" type="text" value="' . $PITCH_SECRETKEY . '" /><br/>
					<label style="display:inline-block; width:120px"></label> <input style="width:120px" class="button action" type="submit" value="Update.." /><br/>
				</form></div></div>
				
				<div class="wrap">
					<div class="frm-section-inner-noline" style="padding-left: 140px; margin-top:40px;" >
						<span style="font-size:10px; font-style:italic">To generate keys, manage designs, pitcures, templates etc, please login to the pitchprint admin panel</span><br/><br/>
						<a href="http://pitchprint.net/admin/domains" target="_blank"><input type="submit" class="button action" value="LAUNCH PITCHPRINT ADMIN PANEL" /></a>
					</div>
				</div>';
	}
	
?>