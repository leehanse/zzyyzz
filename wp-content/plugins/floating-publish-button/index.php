<?php
/*
Plugin Name: Floating Publish Button
Plugin URI: http://wordpress.org/plugins/floating-publish-button/
Description: A WordPress plugin that alters the position and behavior of the Publish button, making it stick to the top of the page when scrolling down the page.
Version: 1.0.4
Author: Do Ha Son
Author URI: http://www.dollaa.com/
License: GPLv2 or later
*/
add_action( 'admin_enqueue_scripts', 'fpb_enqueue_scripts', 20 );
add_action( 'personal_options', 'fpb_options' );
add_action( 'personal_options_update', 'fpb_options_update' );
add_action( 'edit_user_profile_update', 'fpb_options_update' );

function fpb_options_update( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return;

	update_user_meta( $user_id, 'floating_publish_button', intval( isset( $_POST[ 'floating_publish_button' ] ) ) );

}

function fpb_enqueue_scripts() {

	$plugin = get_plugin_data( __FILE__, false, false );


	// float menu, unless explicitly turned off in user profile
	if ( get_user_meta( get_current_user_id(), 'floating_publish_button', true ) !== '0' ) {
		wp_register_script( 'floating-publish-button-hstick', plugin_dir_url( __FILE__ ) . 'jquery.hcsticky-min.js', array( 'jquery' ), $plugin[ 'Version' ] );		
		wp_register_script( 'floating-publish-button', plugin_dir_url( __FILE__ ) . 'floating-publish-button.js', array( 'jquery' ), $plugin[ 'Version' ] );		
		wp_enqueue_script( 'floating-publish-button-hstick' );
		wp_enqueue_script( 'floating-publish-button' );
	}

}

function fpb_options( $profileuser ) {
?>
	<tr class="float-admin-menu">
		<th scope="row"><?php _e( 'Publish/Update button', 'floating-publish-button' ); ?></th>
		<td>
			<fieldset>
				<legend class="screen-reader-text"><span><?php _e( 'Update button', 'floating-publish-button' ); ?></span></legend>
				<label for="floating_publish_button">
					<input type="checkbox" name="floating_publish_button" id="floating_publish_button" value="1"<?php checked( get_user_meta( $profileuser->ID, 'floating_publish_button', true ) !== '0' ); ?> />
					<?php _e( 'Float the Update button', 'floating-publish-button' ); ?>
				</label><br />
			</fieldset>
		</td>
	</tr>
<?php
}