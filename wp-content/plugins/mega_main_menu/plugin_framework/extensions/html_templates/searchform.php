<?php
/**
 * @package mmpm
 * @subpackage mmpm
 * @since mmpm 1.0
 */
	echo '<form method="get" id="mega_main_menu_searchform" action="' . esc_url( home_url( '/' ) ) . '">
		<i class="im-icon-search-3 icosearch"></i>
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="' . esc_attr__( 'Search', 'MMPM_TEXTDOMAIN' ) . '" />
		<input type="text" class="field" name="s" id="s" />
	</form>';
?>
