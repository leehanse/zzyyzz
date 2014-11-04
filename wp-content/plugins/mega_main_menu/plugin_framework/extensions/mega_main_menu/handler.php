<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	/** 
	 * actions what we need for call all functions in this file.
	 * @return void
	 */
	if ( is_array( mmpm_get_option( 'coercive_styles' ) ) && in_array( 'true', mmpm_get_option( 'coercive_styles', array() ) ) ) {
		remove_all_filters( 'wp_nav_menu_items', 60 ); 
		remove_all_filters( 'wp_nav_menu_args', 60 ); 
	}
	add_filter( 'wp_nav_menu_items', 'mmpm_nav_search', 2015, 8 );
    add_filter( 'wp_nav_menu_args', 'mmpm_set_walkers', 2014, 8 ); 

	/** 
	 * Check current location and set args.
	 * @return $items
	 */
    function mmpm_set_walkers ( $args ){
        $args = (array)$args;
        $mega_menu_locations = mmpm_get_option( 'mega_menu_locations' );
        if ( isset( $args['theme_location'] ) && $args['theme_location'] == '' && isset( $mega_menu_locations[1] ) ) {
        	$args['theme_location'] = $mega_menu_locations[ 1 ];
        }
        $original_theme_location_name = $args['theme_location'];
        $args['theme_location'] = str_replace( ' ', '-', strtolower( $args['theme_location'] ) );
        $indefinite_location_mode = ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) ? true : false;
        if ( ( is_array( $mega_menu_locations ) && in_array( $args['theme_location'], $mega_menu_locations ) ) || ( $indefinite_location_mode === true ) ) {
            $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s</ul>';
            $args['walker'] = new Mega_Main_Walker_Nav_Menu;
            $args['container'] = 'div';
            $args['container_id'] = 'mega_main_menu';
            $args['container_class'] = 'nav_menu ' . $args['theme_location'] . 
            ' icons-' . mmpm_get_option( $args['theme_location'] . '_first_level_icons_position', 'left' ) . 
           	' first-lvl-align-' . mmpm_get_option( $args['theme_location'] . '_first_level_item_align', 'left' ) . 
           	' first-lvl-separator-' . mmpm_get_option( $args['theme_location'] . '_first_level_separator', 'none' ) . 
           	' direction-' . mmpm_get_option( $args['theme_location'] . '_direction', 'horizontal' ) . 
           	' responsive-' . ( ( is_array( mmpm_get_option( 'responsive_styles' ) ) && in_array( 'true', mmpm_get_option( 'responsive_styles' ) ) ) ? 'enable' : 'disable' ) . 
           	' mobile_minimized-' . ( ( is_array( mmpm_get_option( $args['theme_location'] . '_mobile_minimized' ) ) && in_array( 'true', mmpm_get_option( $args['theme_location'] . '_mobile_minimized' ) ) || ( $indefinite_location_mode === true ) ) ? 'enable' : 'disable' ) . 
           	' dropdowns_animation-' . mmpm_get_option( $args['theme_location'] . '_dropdowns_animation', 'none' ) . 
            ' version-' . str_replace('.', '-', MMPM_PLUGIN_VERSION );
            $args['menu_id'] = 'mega_main_menu_ul';
            $args['menu_class'] = 'mega_main_menu_ul';
            $args['before'] = '';
            $args['after'] = '';
            $args['link_before'] = '';
            $args['link_after'] = '';
            $args['depth'] = 5;
			$items_wrap = '';
			$data_sticky = ( (is_array( mmpm_get_option( $args['theme_location'] . '_sticky_status' ) ) && in_array( 'true', mmpm_get_option( $args['theme_location'] . '_sticky_status', array() ) ) ) || ( $indefinite_location_mode === true ) ) 
				? ' data-sticky="1"' 
				: '';
			$data_sticky .= ( ( mmpm_get_option( $args['theme_location'] . '_sticky_offset' ) && is_array( mmpm_get_option( $args['theme_location'] . '_sticky_status' ) ) && in_array( 'true', mmpm_get_option( $args['theme_location'] . '_sticky_status', array() ) ) ) || ( $indefinite_location_mode === true ) ) 
				? ' data-stickyoffset="' . mmpm_get_option( $args['theme_location'] . '_sticky_offset' ) . '"' 
				: '';
			$items_wrap .= mmpm_ntab(1) . '<div class="menu_holder"' . $data_sticky . '>';
			$items_wrap .= mmpm_ntab(1) . '<div class="menu_inner">';
			$items_wrap .= mmpm_ntab(1) . '<span class="nav_logo">';
			if( ( is_array( mmpm_get_option( $args['theme_location'] . '_included_components' ) ) && in_array( 'company_logo', mmpm_get_option( $args['theme_location'] . '_included_components' ) ) ) || ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) && mmpm_get_option( 'logo_src' ) ) {
					$items_wrap .= mmpm_ntab(1) . '<a class="logo_link" href="' . home_url() . '" title="' . get_bloginfo( 'name' ) . '"><img src="' . mmpm_get_option( 'logo_src' ) . '" alt="' . get_bloginfo( 'name' ) . '" /></a>';
				$args['container_class'] .= ' include-logo';
			} else {
				$args['container_class'] .= ' no-logo';
			}
			$items_wrap .= mmpm_ntab(1) . '<a class="mobile_toggle"><span class="mobile_button">' . __( 'Menu', MMPM_TEXTDOMAIN_ADMIN ) . '&nbsp; &#9660;</span></a>';
			$items_wrap .= mmpm_ntab(1) . '</span><!-- /class="nav_logo" -->';
			$items_wrap .= mmpm_ntab(1) . $args['items_wrap'];
			$items_wrap .= mmpm_ntab(1) . '</div><!-- /class="menu_inner" -->';
			$items_wrap .= mmpm_ntab(1) . '</div><!-- /class="menu_holder" -->';
			$args['items_wrap'] = $items_wrap;
			if( ( is_array( mmpm_get_option( $args['theme_location'] . '_included_components' ) ) && in_array( 'search_box', mmpm_get_option( $args['theme_location'] . '_included_components', array() ) ) ) || ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) ) {
				$args['container_class'] .= ' include-search';
			} else {
				$args['container_class'] .= ' no-search';
			}
        $args['theme_location'] = $original_theme_location_name;
        }
        return $args;
    }

	/** 
	 * Include logo or search box in menu.
	 * @return $items
	 */
	function mmpm_nav_search( $items, $args ) {
		$args = (object) $args;
        $args->theme_location = str_replace( ' ', '-', strtolower( $args->theme_location ) );
		if( isset( $args->theme_location ) && is_array( mmpm_get_option( $args->theme_location . '_included_components' ) ) && in_array( 'search_box', mmpm_get_option( $args->theme_location . '_included_components' ) ) ) {
				ob_start();
				include( MMPM_EXTENSIONS_DIR . '/html_templates/searchform.php' );
				$searchform = ob_get_contents();
				ob_end_clean();
				$items = mmpm_ntab(1) . '<li class="nav_search_box">' . mmpm_ntab(0) . $searchform . mmpm_ntab(1,0) . '</li>' . mmpm_ntab(1) . $items;
		}
		return $items;
	}
?>