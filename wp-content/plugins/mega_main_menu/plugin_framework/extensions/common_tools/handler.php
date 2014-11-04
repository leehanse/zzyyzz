<?php
/**
 * Tools Functions
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	/** 
	 * The function return variable which contain only one key from global theme options.
	 * @return $mmpm_single_option - one vareable from global theme options.
	 */
	function mmpm_get_option( $key = false, $default_value = false ) {
		if ( $key != false ) {
			global $mmpm_theme_options;
			if ( is_array( $mmpm_theme_options ) && array_key_exists( $key, $mmpm_theme_options ) ) {
				$mmpm_single_option = $mmpm_theme_options[ $key ];
/*
			} elseif ( $default_value != false ) {
				$mmpm_single_option = $default_value;
*/
			} else {
				$mmpm_single_option = $default_value;
			}
		} else {
			$mmpm_single_option = false;
		}
		return $mmpm_single_option;
	}

	/** 
	 * The function return variable which contain only one key from global theme skin.
	 * @return $mmpm_single_option - one vareable from global theme options.
	 */
	function mmpm_get_skin( $key = false, $default_value = false ) {
		if ( $key != false ) {
			global $mmpm_theme_skin;
			if ( is_array( $mmpm_theme_skin ) && array_key_exists( $key, $mmpm_theme_skin ) ) {
				$mmpm_single_option = $mmpm_theme_skin[ $key ];
			} elseif ( $default_value != false ) {
				$mmpm_single_option = $default_value;
			} else {
				$mmpm_single_option = false;
			}
		} else {
			$mmpm_single_option = false;
		}
		return $mmpm_single_option;
	}

	/** 
	 * The function return a newline (set any value in second argument to block newline) 
	 * and the number of tabs specified in the first argument.
	 * Function has a small name and is available in any theme file.
	 * @return $ntab - newline and tabs sumbols (example:\n\t\t).
	 */
	function mmpm_ntab( $number_of_tabs = 0, $newline = 'true' ) {
		$ntab = ( $newline === 'true' ) ? "\n" : "";
		for ($i = 0; $number_of_tabs > $i; $i++) {
			$ntab .= "\t";
		}
		return $ntab;
	}

	/** 
	 * The function return a vareable where only numbers.
	 * @return $only_numbers - vareable where only numbers.
	 */
	function mmpm_get_only_numbers( $variable = false ) {
		$only_numbers = preg_replace( '([^0-9,.]{1,})', '', $variable );
		return $only_numbers;
	}

	/** 
	 * The function return url if url is valid or return false if url is no valid.
	 * @return $url.
	 */
	function mmpm_is_uri( $variable = false ) { 
		if( filter_var( $variable, FILTER_VALIDATE_URL ) === FALSE ) {
			return false;
		} else {
			return true;
		}
	}

	/** 
	 * The function return true if url exist or return false if url no exist.
	 * @return boolean value.
	 */
	function mmpm_uri_exist( $url = false ) { 
		if ( !( $url = @parse_url( $url ) ) ) {
			return false;
		}
		$url['port'] = ( !isset( $url['port'] ) ) ? 80 : (int) $url['port'];
		$url['path'] = ( !empty( $url['path'] ) ) ? $url['path'] : '/';
		$url['path'] .= ( isset( $url['query'] ) ) ? "?$url[query]" : '';
		if ( isset( $url['host'] ) && $url['host'] != @gethostbyname( $url['host'] ) ) {
			if ( PHP_VERSION >= 5 ) {
				$headers = @implode( '', @get_headers( "$url[scheme]://$url[host]:$url[port]$url[path]" ) );
			} else {
				if ( !( $fp = @fsockopen( $url['host'], $url['port'], $errno, $errstr, 10 ) ) ) {
					return false;
				}
				fputs( $fp, "HEAD $url[path] HTTP/1.1\r\nHost: $url[host]\r\n\r\n" );
				$headers = fread( $fp, 4096 );
				fclose( $fp );
			}
			return (bool)preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers);
		}
		return false;
	}

	/** 
	 * The function return new unique script id on page.
	 * @return integer value.
	 */
	function mmpm_script_id () { 
		static $script_id = 0;
		$script_id ++;
		return $script_id;
	}

	/** 
	 * The function return excerpted text.
	 * @return integer value.
	 */
	function mmpm_excerpt( $text = '', $length = 200, $ellipsis = '...' ) {
		$out = $text;
		if ( is_string( $text ) && strlen( $text ) > (int)$length ) {
			$snip = substr( strip_tags( $text ), 0, $length );
			$out = substr( $snip, 0, strrpos( $snip, ' ' ) ) . $ellipsis;
		}
		return $out;
	}

	/** 
	 * The function return full content of the file from URI.
	 * @return integer value.
	 */
	function mmpm_get_uri_content( $uri ) {
		if ( ini_get( 'allow_url_fopen' ) && function_exists( 'file_get_contents' ) ){
			$out = file_get_contents( $uri );
		} elseif ( function_exists('curl_init') ) {
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $uri );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			$out = curl_exec( $ch );
			curl_close($ch);
		} else {
			$out = false;
		}
		return $out;
	}

?>