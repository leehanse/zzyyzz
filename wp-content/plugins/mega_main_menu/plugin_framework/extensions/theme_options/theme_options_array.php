<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	function mmpm_theme_options_array(){
		foreach ( get_nav_menu_locations() as $key => $value ){
			$key = str_replace( ' ', '-', strtolower( $key ) );
			$theme_menu_locations[ $key ] = $key;
		}
		$locations_options = array(
			array(
				'name' => __( 'Below are all the locations, which are supported this theme. Toggle for change their settings.', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'primary_settings',
				'type' => 'caption',
			),
		);
		if ( isset( $theme_menu_locations ) && is_array( $theme_menu_locations ) ) {
			$locations_options[] = array(
				'name' => __( 'You can activate Mega Main Menu in such locations:', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( 'Mega Main Menu and its settings will be displayed in selected locations only after the activation of this location.', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'mega_menu_locations',
				'type' => 'checkbox',
				'values' => $theme_menu_locations,
			);
		} else {
			$locations_options[] = array(
				'name' => __( 'Firstly, You need to create at least one menu', MMPM_TEXTDOMAIN_ADMIN ) . ' (<a href="' . home_url() . '/wp-admin/nav-menus.php">' . __( 'Theme Menu Settings', MMPM_TEXTDOMAIN_ADMIN ) . '</a>) ' . __( 'and set theme-location for him', MMPM_TEXTDOMAIN_ADMIN ) . ' (<a href="' . home_url() . '/wp-admin/nav-menus.php?action=locations">' . __( 'Theme Menu Locations', MMPM_TEXTDOMAIN_ADMIN ) . '</a>).',
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'no_locations',
				'type' => 'caption',
			);
		}

		foreach ( get_nav_menu_locations() as $key => $value ){
			$key = str_replace( ' ', '-', strtolower( $key ) );
			$locations_options = array_merge( 
				$locations_options, array(
					array(
						'name' =>  __( 'Layout Options For: ', MMPM_TEXTDOMAIN_ADMIN ) . '&nbsp; <strong>' . $key . '</strong>',
						'key' => $key . '_menu_options',
						'type' => 'collapse_start',
					),
					array(
						'name' => __( 'Add to Mega Main Menu:', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'You can add to the primary menu container: logo and search.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_included_components',
						'type' => 'checkbox',
						'values' => array(
							__( 'Company Logo (on left side)', MMPM_TEXTDOMAIN_ADMIN ) => 'company_logo',
							__( 'Search Box (on right side)', MMPM_TEXTDOMAIN_ADMIN ) => 'search_box',
						),
						'default' => array( 'lefcompany_logot', 'search_box', ),
					),
					array(
						'name' => __( 'Height of the initial container and menu items of the first level.', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Set the extent for the initial menu container and items of the first level.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_first_level_item_height',
						'type' => 'number',
						'min' => 34,
						'max' => 300,
						'units' => 'px',
						'values' => '50',
					),
					array(
						'name' => __( 'Alignment of the first level items:', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Choose how to locate menu elements of the first level.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_first_level_item_align',
						'type' => 'select',
						'values' => array(
							__( 'Left', MMPM_TEXTDOMAIN_ADMIN ) => 'left',
							__( 'Center', MMPM_TEXTDOMAIN_ADMIN ) => 'center',
							__( 'Right', MMPM_TEXTDOMAIN_ADMIN ) => 'right',
						),
						'default' => array( 'left', ),
					),
					array(
						'name' => __( 'Location of icon in first level elements', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Choose where to locate icon for first level items.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_first_level_icons_position',
						'type' => 'select',
						'values' => array(
							__( 'Left', MMPM_TEXTDOMAIN_ADMIN ) => 'left',
							__( 'Above', MMPM_TEXTDOMAIN_ADMIN ) => 'top',
							__( 'Right', MMPM_TEXTDOMAIN_ADMIN ) => 'right',
							__( 'Disable Icons', MMPM_TEXTDOMAIN_ADMIN ) => 'disable',
						),
						'default' => array( 'left', ),
					),
					array(
						'name' => __( 'Separator:', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select type of separator between the first level items of this menu.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_first_level_separator',
						'type' => 'select',
						'values' => array(
							__( 'None', MMPM_TEXTDOMAIN_ADMIN ) => 'none',
							__( 'Smooth', MMPM_TEXTDOMAIN_ADMIN ) => 'smooth',
							__( 'Sharp', MMPM_TEXTDOMAIN_ADMIN ) => 'sharp',
						),
						'default' => array( 'smooth', ),
					),
					array(
						'name' => __( 'Rounded corners', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select the value of corners radius.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_corners_rounding',
						'type' => 'number',
						'min' => 0,
						'max' => 100,
						'units' => 'px',
						'default' => 0,
					),
					array(
						'name' => __( 'Dropdowns Animation:', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select the type of animation to displaying dropdowns. <span style="color: #f11;">Warning:</span> Animation correctly works only in the latest versions of progressive browsers.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_dropdowns_animation',
						'type' => 'select',
						'values' => array(
							__( 'None', MMPM_TEXTDOMAIN_ADMIN ) => 'none',
							__( 'Unfold', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_1',
							__( 'Fading', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_2',
							__( 'Scale', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_3',
							__( 'Down to Up', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_4',
							__( 'Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'anim_5',
						),
						'default' => array( 'none', ),
					),
					array(
						'name' => __( 'Minimized on Handheld Devices', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'If this option is activated you get the folded menu on handheld devices.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_mobile_minimized',
						'type' => 'checkbox',
						'values' => array(
							__( 'Activate', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
						),
						'default' => array( 'true', ),
					),
					array(
						'name' => __( 'Direction', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Here you can determine the direction of the menu. Horizontal for classic top menu bar. Vertical for sidebar menu.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_direction',
						'type' => 'select',
						'values' => array(
							__( 'Horizontal', MMPM_TEXTDOMAIN_ADMIN ) => 'horizontal',
							__( 'Vertical', MMPM_TEXTDOMAIN_ADMIN ) => 'vertical',
						),
						'default' => array( 'horizontal' ),
	                    'dependency' => array(
	                        'element' => array( 
	                            $key . '_sticky_status', 
	                            $key . '_sticky_offset', 
	                        ),
	                        'value' => 'horizontal',
	                    ),
					),
					array(
						'name' => __( 'Sticky', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Check this option to make the menu sticky.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_sticky_status',
						'type' => 'checkbox',
						'values' => array(
							__( 'Enable', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
						),
					),
					array(
						'name' => __( 'Sticky scroll offset', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Set the length of the scroll for each user to pass before the menu will stick to the top of the window.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_sticky_offset',
						'type' => 'number',
						'min' => 0,
						'max' => 2000,
						'units' => 'px',
						'default' => 340,
					),
					array(
						'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'type' => 'collapse_end',
					),
				) // 'options' => array
			);
		};

		$locations_options = array_merge( 
			$locations_options, array(
				array(
					'name' => __( 'Logo Settings', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'mega_menu_logo',
					'type' => 'caption',
				),
				array(
					'name' => __( 'The logo file', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( "Select image to be used as logo in Main Mega Menu. It's recommended to use image with transparent background (.PNG) and sizes from 200 to 800 px.", MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'logo_src',
					'type' => 'file',
					'default' => MMPM_IMG_URI . '/megamain-logo-120x120.png',
				),
				array(
					'name' => __( 'Maximum logo height', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'Maximum logo height in terms of percentage in regard to the height of the initial container.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'logo_height',
					'min' => 10,
					'max' => 99,
					'units' => '%',
					'type' => 'number',
					'default' => 90,
				),
			) // 'options' => array
		);

		$skins_options = array(
			array(
				'name' => __( 'You can change any properties for any menu location', MMPM_TEXTDOMAIN_ADMIN ),
				'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
				'key' => 'mega_menu_skins',
				'type' => 'caption',
			)
		);
		foreach ( get_nav_menu_locations() as $key => $value ){
			$key = str_replace( ' ', '-', strtolower( $key ) );
			$skins_options = array_merge( 
				$skins_options, array(
					array(
						'name' =>  __( 'Skin Options for: ', MMPM_TEXTDOMAIN_ADMIN ) . '&nbsp; <strong>' . $key . '</strong>',
						'key' => $key . '_menu_skin',
						'type' => 'collapse_start',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the primary container ', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_bg_gradient',
						'type' => 'gradient',
						'default' => array( 'color1' => '#428bca', 'color2' => '#2a6496', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( 'Background image for the primary container', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'You can choose and tune the background image for the primary container.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_bg_image',
						'type' => 'background_image',
						'default' => '',
					),
					array(
						'name' => __( 'Font of the First Level Items', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'You can change size and weight of the font for first level items.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_link_font',
						'type' => 'font',
						'values' => array( 'font_family', 'font_size', 'font_weight' ),
						'default' => array( 'font_family' => 'Verdana', 'font_size' => '13', 'font_weight' => '400' ),
					),
					array(
						'name' => __( 'Size of icons in the first level items', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_icon_font',
						'type' => 'font',
						'values' => array( 'font_size', ),
						'default' => array( 'font_size' => '15', ),
					),
					array(
						'name' => __( 'Text color of the first level item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_link_color',
						'type' => 'color',
						'default' => '#f8f8f8',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the first level item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_link_bg',
						'type' => 'gradient',
						'default' => array( 'color1' => '#428bca', 'color2' => '#2a6496', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( 'Text color of the active first level item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_link_color_hover',
						'type' => 'color',
						'default' => '#f8f8f8',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the active first level item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_first_level_link_bg_hover',
						'type' => 'gradient',
						'default' => array( 'color1' => '#3498db', 'color2' => '#2980b9', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( 'Background color of the Search Box', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_search_bg',
						'type' => 'color',
						'default' => '#3498db',
					),
					array(
						'name' => __( 'Text and icon color of the Search Box', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_search_color',
						'type' => 'color',
						'default' => '#f8f8f8',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the Dropdown elements', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_wrapper_gradient',
						'type' => 'gradient',
						'default' => array( 'color1' => '#ffffff', 'color2' => '#ffffff', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( 'Font of the dropdown menu item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_font',
						'type' => 'font',
						'values' => array( 'font_family', 'font_size', 'font_weight' ),
						'default' => array( 'font_family' => 'Verdana', 'font_size' => '12', 'font_weight' => '400' ),
					),
					array(
						'name' => __( 'Text color of the dropdown menu item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_color',
						'type' => 'color',
						'default' => '#428bca',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the dropdown menu item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_bg',
						'type' => 'gradient',
						'default' => array( 'color1' => 'rgba(255,255,255,0)', 'color2' => 'rgba(255,255,255,0)', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( 'Border color between dropdown menu items', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_border_color',
						'type' => 'color',
						'default' => '#f0f0f0',
					),
					array(
						'name' => __( 'Text color of the dropdown active menu item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_color_hover',
						'type' => 'color',
						'default' => '#f8f8f8',
					),
					array(
						'name' => __( 'Background Gradient (Color) of the dropdown active menu item', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => $key . '_menu_dropdown_link_bg_hover',
						'type' => 'gradient',
						'default' => array( 'color1' => '#3498db', 'color2' => '#2980b9', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
					),
					array(
						'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'type' => 'collapse_end',
					),
				) // 'options' => array
			);
		};
		$skins_options = array_merge( 
			$skins_options, array(
				array(
					'name' => __( 'Set of Installed Fonts', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'Select the fonts to be included on the site. Remember that a lot of fonts affect on the speed of load page. Always remove unnecessary fonts. Font faces can see on this page - ', MMPM_TEXTDOMAIN_ADMIN ) . '<a href="http://www.google.com/fonts" target="_blank">Google fonts</a>',
					'key' => 'set_of_google_fonts',
					'type' => 'multiplier',
					'default' => '1',
					'values' => array(
						array(
							'name' => __( 'Font 1', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'font_item',
							'type' => 'collapse_start',
						),
						array(
							'name' => __( 'Fonts Faily', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'family',
							'type' => 'select',
							'values' => mmpm_get_googlefonts_list(),
							'default' => 'Open Sans'
						),
						array(
							'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'font_item',
							'type' => 'collapse_end',
						),
					),
				),
				array(
					'name' =>  __( 'Additional Styles: ', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'Here you can add and edit highlighting styles.', MMPM_TEXTDOMAIN_ADMIN )	,
					'key' => 'additional_styles_presets',
					'type' => 'multiplier',
					'default' => '1',
					'values' => array(
						array(
							'name' => __( 'Style 1', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'additional_style_item',
							'type' => 'collapse_start',
						),
						array(
							'name' => __( 'Style Name', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'style_name',
							'type' => 'textfield',
							'default' => 'My Highlight Style'
						),
						array(
							'name' => __( 'Text color', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'text_color',
							'type' => 'color',
							'default' => '#f8f8f8',
						),
						array(
							'name' => __( 'Background Gradient (Color) ', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'bg_gradient',
							'type' => 'gradient',
							'default' => array( 'color1' => '#34495E', 'color2' => '#2C3E50', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
						),
						array(
							'name' => __( 'Text color of the active item', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'text_color_hover',
							'type' => 'color',
							'default' => '#f8f8f8',
						),
						array(
							'name' => __( 'Background Gradient (Color) of the active item', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'bg_gradient_hover',
							'type' => 'gradient',
							'default' => array( 'color1' => '#3d566e', 'color2' => '#354b60', 'start' => '0', 'end' => '100', 'orientation' => 'top' ),
						),
						array(
							'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'additional_style_item',
							'type' => 'collapse_end',
						),
					),
				),
				array(
					'name' => __( 'Custom Icons', MMPM_TEXTDOMAIN_ADMIN ),
					'descr' => __( 'You can add custom raster icons. After saving these settings, icons will become available in a modal window of icons selection. Recommended size 64x64 pixels.', MMPM_TEXTDOMAIN_ADMIN ),
					'key' => 'set_of_custom_icons',
					'type' => 'multiplier',
					'default' => '1',
					'values' => array(
						array(
							'name' => __( 'Custom Icon 1', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'icon_item',
							'type' => 'collapse_start',
						),
						array(
							'name' => __( 'Icon File', MMPM_TEXTDOMAIN_ADMIN ),
							'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'custom_icon',
							'type' => 'file',
							'default' => MMPM_IMG_URI . '/megamain-logo-120x120.png',
						),
						array(
							'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
							'key' => 'icon_item',
							'type' => 'collapse_end',
						),
					),
				),
			)
		);

		return array(
			array(
				'title' => 'General',
				'key' => 'general',
				'icon' => 'im-icon-wrench-3',
				'options' => $locations_options,
			),
			array(
				'title' => 'Skins',
				'key' => 'skins',
				'icon' => 'im-icon-brush',
				'options' => $skins_options, // 'options' => array
			),
/*
			array(
				'title' => 'Google Fonts',
				'key' => 'custom_fonts',
				'icon' => 'im-icon-font',
				'options' => array(
					array(
						'name' => __( 'Set of Installed Fonts', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select the fonts to be included on the site. Remember that a lot of fonts affect on the speed of load page. Always remove unnecessary fonts. Font faces can see on this page - ', MMPM_TEXTDOMAIN_ADMIN ) . '<a href="http://www.google.com/fonts" target="_blank">Google fonts</a>',
						'key' => 'set_of_google_fonts',
						'type' => 'multiplier',
						'default' => '1',
						'values' => array(
							array(
								'name' => __( 'Font 1', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'contact_item',
								'type' => 'collapse_start',
							),
							array(
								'name' => __( 'Fonts Faily', MMPM_TEXTDOMAIN_ADMIN ),
								'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'family',
								'type' => 'select',
								'values' => mmpm_get_googlefonts_list(),
								'default' => 'Open Sans'
							),
							array(
								'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
								'key' => 'contact_item',
								'type' => 'collapse_end',
							),
						),
					),
				), // 'options' => array
			),
*/
			array(
				'title' => 'Specific Options',
				'key' => 'specific_options',
				'icon' => 'im-icon-hammer',
				'options' => array(
					array(
						'name' => __( 'Custom CSS', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'You can place here any necessary custom CSS properties.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'custom_css',
						'type' => 'textarea',
					),
					array(
						'name' => __( 'Responsive for Handheld Devices', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Enable responsive properties. If this option is enabled, then the menu will be transformed, if the user uses the handheld device.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'responsive_styles',
						'type' => 'checkbox',
						'values' => array(
							__( 'Activate', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
						),
						'default' => array( 'true', ),
					),
					array(
						'name' => __( 'Use Coercive Styles', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'If this option is checked - all CSS properties for this plugin will be have "!important" priority.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'coercive_styles',
						'type' => 'checkbox',
						'values' => array(
							__( 'Activate', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
						),
					),
					array(
						'name' => __( '"Indefinite location" mode', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'If this option is checked - all menus will be replaced by the mega menu. This will be useful for templates in which are not defined locations of the menu.', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'indefinite_location_mode',
						'type' => 'checkbox',
						'values' => array(
							__( 'Activate', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
						),
					),
				), // 'options' => array
			),
			array(
				'title' => 'Support & Suggestions',
				'key' => 'support',
				'icon' => 'im-icon-support',
				'options' => array(
					array(
						'name' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'support',
						'type' => 'just_html',
						'default' => '<br /><br /> <a href="http://manual.menu.megamain.com/" target="_blank">Online documentation</a>. <br /><br /> If you need support, <br /> If you have a question or suggestion - <br /> Leave a message on our support page <br /> <a href="http://support.megamain.com/?ref=' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '" target="_blank">Support.MegaMain.com</a> (in new window).',
					),
				), // 'options' => array
			),
		); // END FRIMARY ARRAY
	}
?>
