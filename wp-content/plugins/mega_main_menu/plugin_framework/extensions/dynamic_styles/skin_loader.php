<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	add_action( 'wp_head', 'mmpm_ie9_gradient_fix', 80, 5 );
	add_action( 'init', 'mmpm_enqueue_styles', 20, 5 );

	function mmpm_ie9_gradient_fix ( $args ) {
		echo '
<!--[if gte IE 9]>
	<style type="text/css">
		.#mega_main_menu,
		.#mega_main_menu *
		{
			filter: none;
		}
	</style>
<![endif]-->
';
	}

	function mmpm_css_font( $args = array() ) {
		$args = wp_parse_args($args, $defaults = array( 'font_family' => '', 'font_color' => '', 'font_size' => '', 'font_weight' => '' ) );
		extract( $args );

		$font = '';
		if ( $font_family != '' && $font_family != false ) {
			$font .= 'font-family: "' . $font_family . '";';
		}
		if ( $font_color != '' && $font_color != false ) {
			$font .= 'color: ' . $font_color . ';';
		}
		if ( $font_size != '' && $font_size != false ) {
			$font .= 'font-size: ' . $font_size . 'px;';
		}
		if ( $font_weight != '' && $font_weight != false ) {
			$font .= 'font-weight: ' . $font_weight . ';';
		}
		return $font;
	}

	function mmpm_css_gradient( $args = array() ) {
		$args = wp_parse_args($args, $defaults = array( 'color1' => 'transparent', 'color2' => 'transparent', 'start' => '0', 'end' => '100', 'orientation' => 'top' ) );
		extract( $args );
		$color1 = ( $color1 == '' || $color1 == false ) ? 'transparent' : $color1;
		$color2 = ( $color2 == '' || $color2 == false ) ? 'transparent' : $color2;
		$gradient = '';
		if ( ( $color1 == $color2 ) || ( $color2 != 'transparent' ) ) {
			$gradient .= 'background-color: ' . $color1 . ';';
		}
		if ( ( $color1 != 'transparent' ) || ( $color2 != 'transparent' ) ) {
			if ( $color1 != $color2 ) {
				if ( $orientation == 'radial' ) {
					$orient1 = 'radial-gradient(center, ellipse cover';
					$orient2 = 'radial, center center, 0px, center center, 100%';
					$orient3 = 'radial-gradient(ellipse at center';
				} else if ( $orientation == 'left' ) {
					$orient1 = 'linear-gradient(left';
					$orient2 = 'linear, left top, right top';
					$orient3 = 'linear-gradient(to right';
				} else {
					$orient1 = 'linear-gradient(top';
					$orient2 = 'linear, left top, left bottom';
					$orient3 = 'linear-gradient(to bottom';
				}
				$gradient .= 'background: -moz-' . $orient1 . ', ' . $color1 . ' ' . $start . '%, ' . $color2 . ' ' . $end . '%);';
				$gradient .= 'background: -webkit-' . $orient1 . ', ' . $color1 . ' ' . $start . '%, ' . $color2 . ' ' . $end . '%);';
				$gradient .= 'background: -o-' . $orient1 . ', ' . $color1 . ' ' . $start . '%, ' . $color2 . ' ' . $end . '%);';
				$gradient .= 'background: -ms-' . $orient1 . ', ' . $color1 . ' ' . $start . '%, ' . $color2 . ' ' . $end . '%);';
				$gradient .= 'background: -webkit-gradient(' . $orient2 . ', color-stop(' . $start . '%, ' . $color1 . '), color-stop(' . $end . '%,' . $color2 . '));';
				$gradient .= 'background: ' . $orient3 . ', ' . $color1 . ' ' . $start . '%, ' . $color2 . ' ' . $end . '%);';
				$gradient .= 'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' . $color1 . '", endColorstr="' . $color2 . '",GradientType=0 );';
			}
		}
		return $gradient;
	}

	function mmpm_css_bg_image( $args = array() ) {
		$args = wp_parse_args($args, $defaults = array( 'background_image' => '', 'background_repeat' => 'repeat-x', 'background_position' => 'center right', 'background_attachment' => 'fixed', 'background_size' => '' ) );
		extract( $args );

		$bg_image = '';
		if ( $background_image != '' && $background_image != false ) {
			$bg_image .= 'background-image: url("' . $background_image . '");';
			$bg_image .= 'background-repeat: ' . $background_repeat . ';';
			$bg_image .= 'background-position: ' . $background_position . ';';
			$bg_image .= 'background-attachment: ' . $background_attachment . ';';
			$bg_image .= 'background-size: ' . $background_size . ';';
		}
		return $bg_image;
	}

	function mmpm_enqueue_styles( ) {
		// remove later
		include_once( MMPM_EXTENSIONS_DIR . '/common_tools/init.php' ); 

		/* check cache or dynamic file enqueue */
		if( file_exists( MMPM_CSS_DIR . '/cache.skin.css' ) ) {
			$options_last_modified = mmpm_get_option( 'last_modified' );
			$cache_status[] = 'exist';
			if ( $options_last_modified > filemtime( MMPM_CSS_DIR . '/cache.skin.css' ) ) {
				$cache_status[] = 'old';
			} else {
				$cache_status[] = 'actual';
			}
		} else {
			$cache_status[] = 'no-exist';
		};

		if ( in_array( 'actual', $cache_status ) ) {
			$skin_css[] = array( 'name' => MMPM_PREFIX . '_mega_main_menu', 'path' => MMPM_CSS_URI . '/cache.skin.css' );
		} else {
			if ( mmpm_get_uri_content( MMPM_CSS_DIR . '/frontend/mega_main_menu.css' ) && $cache_file = @fopen( MMPM_CSS_DIR . '/cache.skin.css', 'w' ) ) {
				include( 'skin.php' );
				$static_css = mmpm_get_uri_content( MMPM_CSS_DIR . '/frontend/mega_main_menu.css' );
				$out = $static_css . $out;
				if ( $set_of_google_fonts = mmpm_get_option( 'set_of_google_fonts' ) ) {
					unset( $set_of_google_fonts['0'] );
					if ( count( $set_of_google_fonts ) > 0 ) {
						foreach ( $set_of_google_fonts as $key => $value ) {
							$font_family = str_replace(' ', '+', $value['family'] ) . ':400italic,600italic,300,400,600,700,800&subset=latin,latin-ext,cyrillic,cyrillic-ext';
							$additional_font = mmpm_get_uri_content( 'http://fonts.googleapis.com/css?family=' . $font_family );
							$out = $additional_font . $out;
						}
					}
				}
				if ( in_array( 'true', mmpm_get_option( 'coercive_styles' , array() ) ) ) {
					$out = str_replace( array( ";
", " !important !important" ), array( " !important;", " !important" ), $out );
				}
				$out = str_replace( array( "\t", "
", ), array( "", " ", ), $out ) . ' /*' . date("Y-m-d H:i") . '*/';
				if ( @fwrite( $cache_file, $out ) ) {
					$skin_css = array( array( 'name' => MMPM_PREFIX . '_cache.skin', 'path' => MMPM_CSS_URI . '/cache.skin.css' ) );
					touch( MMPM_CSS_DIR . '/cache.skin.css', time(), time() );
				}
			} else {
				$skin_css[] = array( 'name' => MMPM_PREFIX . '_common_styles', 'path' => MMPM_CSS_URI . '/frontend/mega_main_menu.css' );
				$skin_css[] = array( 'name' => MMPM_PREFIX . '_dynamic.skin', 'path' => '/?mega_main_menu_style=skin' );
				if ( $set_of_google_fonts = mmpm_get_option( 'set_of_google_fonts' ) ) {
					unset( $set_of_google_fonts['0'] );
					if ( count( $set_of_google_fonts ) > 0 ) {
						foreach ( $set_of_google_fonts as $key => $value ) {
							$font_family = str_replace(' ', '+', $value['family'] ) . ':400italic,600italic,300,400,600,700,800&subset=latin,latin-ext,cyrillic,cyrillic-ext';
							$skin_css[] = array( 'name' => MMPM_PREFIX . '_' . $value['family'], 'path' => 'http://fonts.googleapis.com/css?family=' . $font_family );
						}
					}
				}
			}
		}

		/* check and enqueue google fonts */
		/* register and enqueue styles */
		foreach ( $skin_css as $single_css ) {
			wp_register_style( $single_css[ 'name' ], $single_css[ 'path' ] );
			wp_enqueue_style( $single_css[ 'name' ] );
		}

		if ( isset( $_GET['mega_main_menu_style'] ) && !empty( $_GET['mega_main_menu_style'] ) ) {
			header("Content-type: text/css", true);
			//echo '/* CSS Generator  */';
			$generated = microtime(true);
			$style = $_GET['mega_main_menu_style'];
			if ( file_exists( dirname( __FILE__ ) . '/' . $style . '.php' ) ) {
				include( $style . '.php' );
				echo $out;
			} else {
				echo '/* Not have called CSS */';
			}
			die('/* CSS Generator Execution Time: ' . floatval( ( microtime(true) - $generated ) ) . ' seconds */');
		}
	}

?>