<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	function mmpm_get_post_thumbnail_id ( $post_id = false ) {
		if ( $post_id != false && is_numeric( $post_id ) ) {
			$post_id = $post_id;
		} else {
			global $post;
			$post_id = ( get_the_ID() ) ? get_the_ID() : $post->ID;
		}
		return get_post_thumbnail_id( $post_id );
	}

	function mmpm_get_post_image_src ( $post_id = false ) {
		if ( $post_id != false && is_numeric( $post_id ) ) {
			$attachment_id = mmpm_get_post_thumbnail_id( $post_id );
		} else {
			$attachment_id = mmpm_get_post_thumbnail_id();
		}
		if ( wp_get_attachment_image_src( $attachment_id, 'full' ) ) {
			$image_src = wp_get_attachment_image_src( $attachment_id, 'full' );
			$image_src = $image_src[0];
/* for better times
			if ( mmpm_uri_exist( $image_src ) == false ) {
				$image_src = MMPM_IMAGE_NOT_FOUND; 
			}
*/
		} else {
			$image_src = MMPM_NO_IMAGE_AVAILABLE;
		};
		return $image_src;
	}

	function mmpm_get_resized_image_src ( $original_image_uri = false, $width = false, $height = false ) {
		$wp_upload_dir = wp_upload_dir();
		if ( empty( $original_image_uri ) ){
			$original_image_uri = MMPM_NO_IMAGE_AVAILABLE; 
		}
/* for better times
		if ( mmpm_uri_exist( $original_image_uri ) == false ) {
			$original_image_uri = MMPM_IMAGE_NOT_FOUND; 
		}
*/
		$file_extension = strrchr( $original_image_uri, '.' );
		$file_name = strrchr( $original_image_uri, '/' );
		if ( is_numeric( $width ) || is_numeric( $height ) ) {
			$croped_file_name = str_replace( $file_extension, '', $file_name ) . '-' . $width . 'x' . $height . $file_extension;
		} else {
			$croped_file_name = $file_name;
		}
		if ( substr_count( $original_image_uri, $wp_upload_dir['baseurl'] ) ) {
			$subdir = str_replace( array( $wp_upload_dir['baseurl'], $file_name ), '', $original_image_uri );
		} elseif ( substr_count( $original_image_uri, home_url() ) ) {
			$subdir = '/undated_files';
		} else {
			$subdir = '/external_files';
		}
		$croped_img_path = $wp_upload_dir['basedir'] . $subdir . $croped_file_name;
		$croped_img_uri = $wp_upload_dir['baseurl'] . $subdir . $croped_file_name;
		if ( !file_exists( $croped_img_path ) ) {
			$img = wp_get_image_editor( $original_image_uri );
			if ( ! is_wp_error( $img ) ) {
				$img->resize( $width, $height, true );
				$img->save( $croped_img_path );
			}
		}
		return $croped_img_uri;
	}

	function mmpm_get_processed_image ( $args = array() ) {
		$defaults = array(
			'post_id' => false,
			'width' => false,
			'height' => false,
			'class' => false,
			'echo' => false,
			'placeholder' => false,
			'src' => true,
			'permalink' => true,
			'cover' => array('title','link'), // Available types: title, link, zoom, icon
			'title' => true,
			'icon' => true,
			'container' => true,
		);
		$args = wp_parse_args( $args, $defaults );
		extract( $args );
		// check and set variablesz
		$out = '';
		$src = ( ( is_string( $src ) ) 
			? mmpm_is_uri( $src ) 
			: mmpm_get_post_image_src( $post_id )
		);
		$icon = ( is_string( $icon ) 
			? $icon 
			: ( get_post_meta( get_the_ID(), MMPM_PREFIX . '_post_icon', true ) 
				? get_post_meta( get_the_ID(), MMPM_PREFIX . '_post_icon', true ) 
				: 'im-icon-plus-circle' 
			) 
		);
		$title = ( is_string( $title ) 
			? $title 
			: ( get_the_title( get_the_ID() ) 
				? get_the_title( get_the_ID() ) 
				: __( 'More', MMPM_TEXTDOMAIN_ADMIN ) ) 
		);					
		$permalink = ( is_string( $permalink ) 
			? $permalink 
			: ( ( $permalink != false && get_permalink( get_the_ID() ) ) 
				? get_permalink( get_the_ID() ) 
				: '' 
			) 
		);
		$attachment_object = get_post_thumbnail_id() 
			? (object) get_post( get_post_thumbnail_id() ) 
			: (object) 'image';
		$alt_attr = ( is_object( $attachment_object ) && isset( $attachment_object->ID ) && get_post_meta( $attachment_object->ID, '_wp_attachment_image_alt', true ) != '' ) 
			? get_post_meta( $attachment_object->ID, '_wp_attachment_image_alt', true ) 
			: $title ;
		$post_excerpt = ( isset( $attachment_object->post_excerpt ) && $attachment_object->post_excerpt != '' ) 
			? $attachment_object->post_excerpt
			: $title;
		// build image tag
		$img = '<img src="' . mmpm_get_resized_image_src( $src, $width, $height ) . '" alt="' . $alt_attr . '" title="' . $post_excerpt . '" />';
		// build additional containers
		if ( $container == true ) {
			$out .= mmpm_ntab(1) . '<' . ( is_string( $container ) ? $container : 'div' ) . ' class="processed_image' . ( is_string( $class ) ? ' ' . $class : '' ) . '">'; //  style="max-width:' . $width . 'px; max-height:' . $height . 'px;"
			$out .= mmpm_ntab(2) . $img;
			if ( $cover == true ) {
				$out .= mmpm_ntab(2) . '<div class="cover' . ( is_string( $cover ) ? ' ' . $cover : ( is_array( $cover ) ? ' ' . implode( ' ', $cover ) : '') ) . '">';
				if ( 
					$icon == true && 
					( 
						$cover == 'icon' 
						|| ( 
							is_array( $cover ) 
							&& ( 
								in_array( 'icon', $cover ) 
								|| ( !in_array( 'zoom', $cover ) && !in_array( 'link', $cover ) ) 
							) 
						)
					) 
				) {
					$link_href_atr = ( 
						( $permalink != '' && ( !is_array( $cover ) || ( is_array( $cover ) && !in_array( 'link', $cover ) ) ) ) 
						? 'href="' . $permalink . '"' 
						: '' 
					);
					$out .= mmpm_ntab(3) . '<a ' . $link_href_atr . ' class="icon">'; //' . ( is_array( $cover ) && ( in_array( 'zoom', $cover ) || in_array( 'link', $cover ) ) ? '' : ' without_controls' ) . '
					$out .= mmpm_ntab(4) . '<i class="' .$icon . '"></i>';					
					$out .= mmpm_ntab(3) . '</a>';
				}
				if ( $title == true && ( $cover == 'title' || ( is_array( $cover ) && in_array( 'title', $cover ) ) ) ) {
					$link_href_atr = ( ( $permalink != '' && ( is_array( $cover ) && !in_array( 'link', $cover ) ) ) 
						? 'href="' . $permalink . '"' 
						: '' 
					);
					$out .= mmpm_ntab(3) . '<a ' . $link_href_atr . ' class="title' . ( $permalink == '' ? ' single' : '' ) . '" title="' . $title . '">';
					$out .= mmpm_ntab(4) . $title;					
					$out .= mmpm_ntab(3) . '</a>';
				}
				if ( $cover == 'zoom' || ( is_array( $cover ) && in_array( 'zoom', $cover ) ) ) {
					$out .= mmpm_ntab(3) . '<a href="' . $src . '" data-rel="prettyPhoto" class="controls full_image' . ( ( $permalink != '' && in_array( 'link', $cover ) ) ? '' : ' single' ) . '">';
					$out .= mmpm_ntab(4) . '<i class="im-icon-zoom-in"></i>';
					$out .= mmpm_ntab(3) . '</a>';
				}
				if ( $cover == 'link' || ( is_array( $cover ) && in_array( 'link', $cover ) ) ) {
					if ( $permalink != '' ) {
						$out .= mmpm_ntab(3) . '<a href="' . $permalink . '" class="controls permalink' . ( ( in_array( 'zoom', $cover ) ) ? '' : ' single' ) . '">';
						$out .= mmpm_ntab(4) . '<i class="im-icon-link"></i>';
						$out .= mmpm_ntab(3) . '</a>';
					}
				}
				$out .= mmpm_ntab(2) . '</div><!-- class="cover' . ( is_string( $cover ) ? ' ' . $cover : ( is_array( $cover ) ? ' ' . implode( ' ', $cover ) : '') ) . '" -->';
			}
			$out .= mmpm_ntab(1) . '</' . ( is_string( $container ) ? $container : 'div' ) . '><!-- class="processed_image' . ( is_string( $class ) ? ' ' . $class : '' ) . '" -->';
		} else {
			$out .= mmpm_ntab(1) . $img;
		}
		// return echo or output
		if ( $echo != false ) {
			echo $out;
		} else {
			return $out;
		}
	}

?>
