<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	if ( is_admin() ) {
		$menu_locations = get_nav_menu_locations();
		$nav_menu_selected_id = ( isset( $_REQUEST['menu'] ) 
			? (int) $_REQUEST['menu'] 
			: ( ( get_user_option( 'nav_menu_recently_edited' ) != false ) 
				? absint( get_user_option( 'nav_menu_recently_edited' ) )
				: 0
			)
		);
		$current_menu_location = array_search( $nav_menu_selected_id, $menu_locations );
        $self_current_menu_location = str_replace( ' ', '-', strtolower( $current_menu_location ) );
		$mega_menu_locations = mmpm_get_option( 'mega_menu_locations' );
		if ( ( is_array( $mega_menu_locations ) && in_array( $self_current_menu_location, $mega_menu_locations ) ) || ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) ) {
			include_once( 'menu_options_array.php' );
			include_once( 'backend_walker.php' );
		}
	} else {
		include_once( 'handler.php' );
		include_once( 'frontend_walker.php' );
	}
?>