<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	include_once( 'handler.php' );
	if ( is_admin() ) {
		include_once( 'only_backend.php' );
	}
?>