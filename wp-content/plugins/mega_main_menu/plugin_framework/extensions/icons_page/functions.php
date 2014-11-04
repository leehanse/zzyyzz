<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
if ( isset( $_GET['mmpm_page'] ) && !empty( $_GET['mmpm_page'] ) ) {
//	header("Content-type: text/css", true);
	if ( $_GET['mmpm_page'] == 'icons_list' ) {
		
		echo mmpm_ntab(1) . '
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(\'.all_icons_search_input\').keyup(function(){
				setTimeout(function () {
					search_query = jQuery(\'.all_icons_search_input\').val();
					if ( search_query != \'\' ) {
						jQuery(\'.all_icons_container label\').css({\'display\' : \'none\'});
						jQuery(\'.all_icons_container label[for*="\' + search_query + \'"]\').css({\'display\' : \'block\'});
					} else {
						jQuery(\'.all_icons_container label\').removeAttr(\'style\');
					}
				}, 1200 );
			});
		});
	</script>';
		echo mmpm_ntab(0) . '<div class="bootstrap">';
		echo mmpm_ntab(1) . '<div class="modal-dialog">';
		echo mmpm_ntab(2) . '<div class="modal-content">';
		echo mmpm_ntab(3) . '<div class="modal-body">';
		echo mmpm_ntab(4) . '<div class="holder">';
		echo mmpm_ntab(5) . '<div class="all_icons_control_panel">';
		echo mmpm_ntab(6) . '<input type="text" class="all_icons_search_input" placeholder="'.__( 'Search icon', MMPM_TEXTDOMAIN_ADMIN ).'">';
		echo mmpm_ntab(6) . '<span class="ok_button btn-primary" onclick="mmpm_icon_selector(\'' . ( isset( $_GET['input_name'] ) ? $_GET['input_name'] : '') . '\', \'' . ( isset( $_GET['modal_id'] ) ? $_GET['modal_id'] : '') . '\' );">'.__( 'OK', MMPM_TEXTDOMAIN_ADMIN ).'</span>';
		echo mmpm_ntab(5) . '</div><!-- class="all_icons_control_panel" -->';
		echo mmpm_ntab(5) . '<div class="all_icons_container">';
		$set_of_custom_icons = mmpm_get_option( 'set_of_custom_icons', array() );
		if ( is_array( $set_of_custom_icons ) && count( $set_of_custom_icons ) > 1 ) {
			unset( $set_of_custom_icons[0] );
			foreach ( $set_of_custom_icons as $value ) {
				$icon_name = str_replace( array( '/', strrchr( $value[ 'custom_icon' ], '.' ) ), '', strrchr( $value[ 'custom_icon' ], '/' ) );
				echo '<label for="ci-icon-' . $icon_name . '"><input name="icon" id="ci-icon-' . $icon_name . '" type="radio" value="ci-icon-' . $icon_name . '"><i class="ci-icon-' . $icon_name . '"></i></label>';
			}
		}
		foreach ( mmpm_get_all_icons() as $key => $value ) {
			echo '<label for="' . $value . '"><input name="icon" id="' . $value . '" type="radio" value="' . $value . '"><i class="' . $value . '"></i></label>';
//			echo '<label for="' . $value . '"><input name="icon" id="' . $value . '" type="radio" value="' . $value . '"><i class="' . $value . '"></i><div class="drop">' . $key . '<br />' . htmlentities('<i class="' . $value . '"></i>') . '</div></label>';
		}
		echo mmpm_ntab(5) . '</div><!-- class="all_icons_container" -->';
		echo mmpm_ntab(4) . '</div><!-- class="holder" -->';
		echo mmpm_ntab(3) . '</div><!-- class="modal-body" -->';
		echo mmpm_ntab(2) . '</div><!-- class="modal-content" -->';
		echo mmpm_ntab(1) . '</div><!-- class="modal-dialog" -->';
		echo mmpm_ntab(0) . '</div><!-- class="bootstrap" -->';
	}
	die();
}
?>