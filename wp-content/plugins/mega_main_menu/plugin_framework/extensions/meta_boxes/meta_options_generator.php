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
	add_action( 'add_meta_boxes', 'mmpm_meta_box_generator', 1 );
	add_action( 'save_post', 'mmpm_save_meta_options', 10, 2 );

	/** 
	 * Save the meta box's post metadata.
	 * @return void
	 */
	function mmpm_save_meta_options( $post_id, $post ) {
		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[MMPM_PREFIX . '_meta_nonce'] ) || !wp_verify_nonce( $_POST[MMPM_PREFIX . '_meta_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}
		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );
		/* Check if the current user has permission to edit the post. */
		if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return $post_id;
		}
		foreach ( mmpm_meta_options_array() as $meta_box ) {
			/* Check if current post_type isset in meta options array. */
			if ( $meta_box['post_type'] == $post->post_type || $meta_box['post_type'] == 'all_post_types' || ( is_array( $meta_box['post_type'] ) && in_array( $post->post_type, $meta_box['post_type'] ) ) ) {
				foreach ( $meta_box['options'] as $key => $option ) {
					/* Get the posted data and sanitize it for use as an HTML class. */
					$new_meta_value = ( isset( $_POST[MMPM_PREFIX . '_' . $option['key']] ) ? $_POST[MMPM_PREFIX . '_' . $option['key']] : '' );
					/* Get the meta key. */
					$meta_key = MMPM_PREFIX . '_' . $option['key'];
					/* Get the meta value of the custom field key. */
					$meta_value = get_post_meta( $post_id, $meta_key, true );
					/* If a new meta value was added and there was no previous value, add it. */
					if ( $new_meta_value && '' == $meta_value ) {
						add_post_meta( $post_id, $meta_key, $new_meta_value, true );
					}
					/* If the new meta value does not match the old value, update it. */
					elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
						update_post_meta( $post_id, $meta_key, $new_meta_value );
					}
					/* If there is no new meta value but an old value exists, delete it. */
					elseif ( '' == $new_meta_value && $meta_value ) {
						delete_post_meta( $post_id, $meta_key, $meta_value );
					}
				}
			}
		}
	}

	/** 
	 * Register (add) meta boxes.
	 * @return void
	 */
	function mmpm_meta_box_generator(){
		$mmpm_meta_options_array = mmpm_meta_options_array();
		foreach ( $mmpm_meta_options_array as $key => $meta_box ) {
			/* if "post_type" variable is array do foreach */
			if ( is_array( $meta_box['post_type'] ) ) {
				foreach ( $meta_box['post_type'] as $post_type ) {
					add_meta_box( 
						$meta_box['key'],
						$meta_box['title'],
						'mmpm_meta_options_generator',
						$post_type,
						$meta_box['context'],
						$meta_box['priority'], 
						$meta_box['options']
					);
				}
			/* if "post_type" variable set "all_post_types" add this meta box for all types of posts */
			} elseif ( $meta_box['post_type'] == 'all_post_types' && get_post_type() != 'attachment' ) {
				add_meta_box( 
					$meta_box['key'],
					$meta_box['title'],
					'mmpm_meta_options_generator',
					get_post_type(),
					$meta_box['context'],
					$meta_box['priority'], 
					$meta_box['options']
				);
			/* else "post_type" variable contain sting value and we add this meta box for one type of posts */
			} else {
				add_meta_box( 
					$meta_box['key'],
					$meta_box['title'],
					'mmpm_meta_options_generator',
					$meta_box['post_type'],
					$meta_box['context'],
					$meta_box['priority'], 
					$meta_box['options']
				);
			}
		}
	}

	/** 
	 * Generator for meta fields.
	 * @return $out
	 */
	function mmpm_meta_options_generator( $object, $options ) {
		$out = '';
		foreach ( $options['args'] as $key => $option ) {
			$option['key'] = ( isset( $option['key'] ) ) ? $option['key'] : '';
			$option['name'] = ( isset( $option['name'] ) ) ? $option['name'] : '';
			$option['descr'] = ( isset( $option['descr'] ) ) ? $option['descr'] : '';
			$option['type'] = ( isset( $option['type'] ) ) ? $option['type'] : '';
			$option['values'] = ( isset( $option['values'] ) ) ? $option['values'] : '';
			$option['default'] = ( isset( $option['default'] ) ) ? $option['default'] : '';
			$mmpm_saved_value = get_post_meta( $object->ID, MMPM_PREFIX . '_' . $option['key'], true ) 
				? get_post_meta( $object->ID, MMPM_PREFIX . '_' . $option['key'], true ) 
				: false;
			$out .= mmpm_options_generator( $option, $mmpm_saved_value );
		}
		echo $out;
		wp_nonce_field( basename( __FILE__ ), MMPM_PREFIX . '_meta_nonce' );
	}

?>