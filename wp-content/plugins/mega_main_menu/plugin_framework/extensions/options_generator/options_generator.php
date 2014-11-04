<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	/** 
	 * Build option row.
	 * @return $out
	 */
	function mmpm_options_generator( $option, $mmpm_saved_value = false ){
		/* Check and set all most variables */
		$option['name'] = isset( $option['name'] ) ? $option['name'] : '';
		$option['descr'] = isset( $option['descr'] ) ? $option['descr'] : '';
		$option['key'] = isset( $option['key'] ) ? $option['key'] : 'key_no_set';
		$option['type'] = isset( $option['type'] ) ? $option['type'] : '';
		$option['values'] = isset( $option['values'] ) ? $option['values'] : '';
		$tmp_key_var = explode( '[', $option['key'] );
		$clear_key = str_replace( array( MMPM_OPTIONS_NAME, '[',']'), '', end( $tmp_key_var ) );
		$clear_full_key = str_replace( array( MMPM_OPTIONS_NAME, '[',']'), '', $option['key'] );
		$out = '';
		/* check field "type" and return actual sting */
		switch ( $option['type'] ) {
			case 'just_html':
				$out .= ( isset( $option['default'] ) 
					? $option['default']  
					: ( isset( $option['values'] ) 
						? $option['values'] 
						: ''
					)
				);
				break;
			case 'textarea':
				$out .= mmpm_ntab(9) . '<textarea class="textarea" name="' . MMPM_PREFIX . '_' . $option['key'] . '" rows="5">' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
					? esc_textarea( $mmpm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_textarea( $option['default'] )  
						: ( isset( $option['values'] ) 
							? esc_textarea( $option['values'] ) 
							: ''
						)
					) 
				) . '</textarea>';
				break;
			case 'checkbox':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 4;
				$out .= mmpm_ntab(9) . '<input type="hidden" name="' . MMPM_PREFIX . '_' . $option['key'] . '[]" value="is_checkbox" />';
				$out .= mmpm_ntab(9) . '<div class="row no_left_margin">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= mmpm_ntab(10) . '<div class="checkbox col-xs-' . $col_width . '">';
						$out .= mmpm_ntab(11) . '<label><input type="checkbox" name="' . MMPM_PREFIX . '_' . $option['key'] . '[]" value="' . $value .'" ' . ( ( isset( $mmpm_saved_value ) && is_array( $mmpm_saved_value ) ) 
							? ( in_array( $value, $mmpm_saved_value ) 
								? 'checked="checked" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( in_array( $value, $option['default'] ) || $value == $option['default'] ) ) 
								? 'checked="checked" ' 
								: ''
							)
						) . '/>' . ( is_string( $key ) ? $key : $value ) .'</label>';
						$out .= mmpm_ntab(10) . '</div>';
					}
				}
				$out .= mmpm_ntab(9) . '</div>';
				break;
			case 'radio':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 6;
				$out .= mmpm_ntab(9) . '<div class="row no_left_margin">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= mmpm_ntab(10) . '<div class="radio col-xs-' . $col_width . '">';
						$out .= mmpm_ntab(11) . '<label><input type="radio" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . $value .'" ' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
							? ( $value == $mmpm_saved_value 
								? 'checked="checked" ' 
								: ''
							)
							: ( ( isset( $option['default'] ) && ( in_array( $value, $option['default'] ) || $value == $option['default'] ) ) 
								? 'checked="checked" ' 
								: ''
							)
						) . '/>' . ( is_string( $key ) ? $key : $value ) .'</label>';
						$out .= mmpm_ntab(10) . '</div>';
					}
				}
				$out .= mmpm_ntab(9) . '</div>';
					break;
			case 'select':
				$out .= mmpm_ntab(9) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
							? ( $value == $mmpm_saved_value 
								? 'selected="selected" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( ( is_array( $option['default'] ) && in_array( $value, $option['default'] ) ) || $value == $option['default'] ) ) 
								? 'selected="selected" ' 
								: ''
							)
						) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
					}
				}
				$out .= mmpm_ntab(9) . '</select>';
				break;
			case 'number':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 6;
				$step = isset( $option['step'] ) ? $option['step'] : 1;
				$min = isset( $option['min'] ) ? $option['min'] : 1;
				$max = isset( $option['max'] ) ? $option['max'] : 100;
				$input = '<input class="form-control input-sm col-xs-12" type="number" step="' . $step . '" min="' . $min . '" max="' . $max . '" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
					? esc_attr( $mmpm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: ( isset( $option['values'] ) 
							? $option['values'] 
							: ''
						)
					) 
				) . '" />';
				if ( isset( $option['units'] ) && !empty( $option['units'] ) ) {
					$out .= mmpm_ntab(9) . '<div class="row">';
					$out .= mmpm_ntab(10) . '<div class="input-group input-group-sm col-xs-' . $col_width . '">';
					$out .= mmpm_ntab(11) . $input;
					$out .= mmpm_ntab(11) . '<span class="input-group-addon">' . $option['units'] . '</span>';
					$out .= mmpm_ntab(10) . '</div><!-- class="input-group input-group-sm" -->';
					$out .= mmpm_ntab(9) . '</div><!-- class="row" -->';
				} else {
					$out .= mmpm_ntab(9) . $input;
				}
				break;
			case 'radio_html':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 4;
				$out .= mmpm_ntab(9) . '<div class="row no_left_margin">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= mmpm_ntab(10) . '<div class="radio col-xs-' . $col_width . '">';
						$out .= mmpm_ntab(11) . '<label><input type="radio" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . $value .'" ' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
							? ( $value == $mmpm_saved_value 
								? 'checked="checked" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( in_array( $value, $option['default'] ) || $value == $option['default'] ) ) 
								? 'checked="checked" ' 
								: ''
							)
						) . '/>' . ( is_string( $key ) ? $key : $value ) .'</label>';
						$out .= mmpm_ntab(10) . '</div>';
					}
				}
				$out .= mmpm_ntab(9) . '</div>';
					break;
			case 'checkbox_html':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 4;
				$out .= mmpm_ntab(9) . '<input type="hidden" name="' . MMPM_PREFIX . '_' . $option['key'] . '[]" value="is_checkbox" />';
				$out .= mmpm_ntab(9) . '<div class="row no_left_margin">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= mmpm_ntab(10) . '<div class="checkbox col-xs-' . $col_width . '">';
						$out .= mmpm_ntab(11) . '<label><input type="checkbox" name="' . MMPM_PREFIX . '_' . $option['key'] . '[]" value="' . $value .'" ' . ( ( isset( $mmpm_saved_value ) && is_array( $mmpm_saved_value ) ) 
							? ( in_array( $value, $mmpm_saved_value ) 
								? 'checked="checked" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( in_array( $value, $option['default'] ) || $value == $option['default'] ) ) 
								? 'checked="checked" ' 
								: ''
							)
						) . '/>' . ( is_string( $key ) ? $key : $value ) .'</label>';
						$out .= mmpm_ntab(10) . '</div>';
					}
				}
				$out .= mmpm_ntab(9) . '</div>';
				break;
			case 'file':
				// below calls scripts and styles for media library uploader.
				if ( !isset( $theme_option_file ) ) {
					static $theme_option_file = 1;
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_script('jquery');
					wp_enqueue_style('thickbox');
				}

				$out .= mmpm_ntab(9) . '<div class="row">';
				$out .= mmpm_ntab(10) . '<div class="input-group input-group-sm col-xs-9">';
				$out .= mmpm_ntab(10) . '<input class="upload form-control col-xs-8" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
											? $mmpm_saved_value 
											: ( isset( $option['default'] ) 
												? esc_attr( $option['default'] )  
												: ( isset( $option['values'] ) 
													? $option['values'] 
													: ''
												)
											) 
				) . '" />';
				/*  name="' . $option['key'] . '" */
				$out .= mmpm_ntab(11) . '<span class="input-group-btn">';
				$out .= mmpm_ntab(12) . '<input class="' . $clear_full_key . ' select_file_button btn btn-primary" type="button" value="' . __( 'Select Image', MMPM_TEXTDOMAIN_ADMIN ) . '" />';
				$out .= mmpm_ntab(11) . '</span><!-- class="input-group-btn" -->';
				$out .= mmpm_ntab(10) . '</div><!-- class="input-group" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(11) . '<img class="img_preview" data-imgprev="' . $clear_full_key . '" src="' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
											? $mmpm_saved_value 
											: ( isset( $option['default'] ) 
												? esc_attr( $option['default'] )  
												: ( isset( $option['values'] ) 
													? $option['values'] 
													: ''
												)
											) 
				) . '" />';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= '<script language="JavaScript"> mmpm_file_upload( \'' . MMPM_PREFIX . '_' . $option['key'] . '\', \'' . $clear_full_key . '\' ); </script>';
				$out .= mmpm_ntab(9) . '</div><!-- class="row" -->';
				break;
			case 'multiplier':
				$multiplier_value = ( ( isset( $mmpm_saved_value[0] ) && $mmpm_saved_value[0] !== false ) 
					? esc_attr( $mmpm_saved_value[0] ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: '1'
					) 
				);
				$out .= mmpm_ntab(9) . '<div class="input-group input-group-sm multipler_pieces">';
				$out .= mmpm_ntab(10) . '<input class="form-control input-sm" type="number" min="0" max="100" name="' . MMPM_PREFIX . '_' . $option['key'] . '[0]" value="' . $multiplier_value . '" />';
				$out .= mmpm_ntab(10) . '<span class="input-group-addon">' . __( 'Pieces', MMPM_TEXTDOMAIN_ADMIN ). '</span>';
				$out .= mmpm_ntab(9) . '</div><!-- class="input-group input-group-sm" -->';
				$out .= mmpm_ntab(9) . '<div class="hidden multiplied_example ' . $clear_full_key . '">';
				foreach ( $option['values'] as $key => $subvalue ) {
					$subvalue['key'] = $option['key'] . '[999][' . $subvalue['key'] . ']';
					$subvalue['name'] = str_replace( '1', '999', $subvalue['name']);
					$out .= mmpm_options_generator( $subvalue , false );
				}
				$out .= mmpm_ntab(9) . '</div><!-- class="multiplied_content" -->';
				$out .= mmpm_ntab(9) . '<div class="multiplied_content ' . $clear_full_key . '">';

				$counter = 1;
				while ( $multiplier_value >= $counter ) {
					foreach ( $option['values'] as $key => $subvalue ) {
						$mmpm_saved_subvalue = isset( $mmpm_saved_value[ $counter ][ $subvalue['key'] ] ) 
							? $mmpm_saved_value[ $counter ][ $subvalue['key'] ]
							: false;
						$subvalue['key'] = $option['key'] . '[' . $counter . '][' . $subvalue['key'] . ']';
						$subvalue['name'] = str_replace( '1', $counter, $subvalue['name']);
						$out .= mmpm_options_generator( $subvalue , $mmpm_saved_subvalue );
					}
					$counter ++;
				}
				$out .= mmpm_ntab(9) . '</div><!-- class="multiplied_content" -->';
				$out .= '
					<script language="JavaScript">
						mmpm_multiplier( \'input[name*="' . MMPM_PREFIX . '_' . $option['key'] . '[0]"]\', \'.multiplied_example.'. $clear_full_key . '\', \'.multiplied_content.'. $clear_full_key . '\' );
					</script>';
				break;
			case 'wpeditor':
				$content = ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
					? $mmpm_saved_value 
					: ( isset( $option['default'] ) 
						? $option['default']  
						: ( isset( $option['values'] ) 
							? $option['values'] 
							: ''
						)
					) 
				);
				ob_start();
				$args = array( 
					'textarea_name' => MMPM_PREFIX . '_' . $option['key'], 
					'wpautop' => false,
					'media_buttons' => false,
					'textarea_rows' => 5,
				);
				wp_editor( $content, MMPM_PREFIX . '_' . $clear_full_key, $args );
				$editor = ob_get_contents();
				ob_end_clean();
				$out .= mmpm_ntab(9) . '<div class="no_bootstrap">';
				$out .= $editor;
				$out .= mmpm_ntab(9) . '</div><!-- class="no_bootstrap" -->';
				break;
			case 'icons':
				$icon = ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false && $mmpm_saved_value != '' ) 
					? esc_attr( $mmpm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: array_rand( array_flip( mmpm_get_all_icons() ) )
					) 
				);
				$out .= mmpm_ntab(9) . '<div class="row">';
				$out .= mmpm_ntab(10) . '<div class="input-group input-group-sm col-xs-9">';
				$out .= mmpm_ntab(11) . '<input class="form-control input-sm" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . $icon . '" data-icon="icons_list_' . $clear_full_key . '" />';
				$out .= mmpm_ntab(11) . '<span class="input-group-btn">';
				$out .= mmpm_ntab(12) . '<a data-toggle="modal" href="' . admin_url() . '?mmpm_page=icons_list&input_name=' . MMPM_PREFIX . '_' . $option['key'] . '&modal_id=icons_list_' . $clear_full_key . '" data-target="#icons_list_' . $clear_full_key . '" class="btn btn-primary">' . __( 'Show Icons', MMPM_TEXTDOMAIN_ADMIN ) . '</a>';
				$out .= mmpm_ntab(11) . '</span><!-- class="input-group-btn" -->';
				$out .= mmpm_ntab(10) . '</div><!-- class="input-group input-group-sm col-xs-9" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3 icon_preview">';
				$out .= mmpm_ntab(11) . '<i class="' . $icon . '" data-icon="icons_list_' . $clear_full_key . '"></i>';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= mmpm_ntab(9) . '</div><!-- class="row" -->';
				$out .= mmpm_ntab(9) . '<div id="icons_list_' . $clear_full_key . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="icons_listLabel" aria-hidden="true"></div><!-- class="modal" -->';
				break;
			case 'caption':
				$out .= mmpm_ntab(7) . '<div class="bootstrap">';
				$out .= mmpm_ntab(8) . '<div class="option bootstrap row ' . $option['key'] . ' ' . $option['type'] . '">';
				$out .= mmpm_ntab(9) . '<div class="col-xs-12">';
				$out .= mmpm_ntab(10) . '<div class="h_separator">';
				$out .= mmpm_ntab(10) . '</div><!-- class="h_separator" -->';
				$out .= mmpm_ntab(9) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(9) . '<div class="col-xs-12">';
				$out .= mmpm_ntab(10) . '<div class="section_caption">';
				$out .= mmpm_ntab(11) . $option['name'];
				$out .= mmpm_ntab(10) . '</div><!-- class="section_caption" -->';
				$out .= mmpm_ntab(9) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(8) . '</div><!-- class="option row ' . $option['key'] . ' ' . $option['type'] . '" -->';
				$out .= mmpm_ntab(7) . '</div><!-- class="bootstrap" -->';
				break;
			case 'collapse_start':
				$out .= mmpm_ntab(5) . '<div class="panel bootstrap ' . str_replace( array('[',']'), array('',''), $option['key'] ) . '">';
				$out .= mmpm_ntab(6) . '<div class="panel-heading">';
				$out .= mmpm_ntab(7) . '<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent=".tab-pane" href="#' . str_replace( array('[',']',' '), array('','','-'), $option['key'] ) . '">' . $option['name'] . '</a>';
				$out .= mmpm_ntab(6) . '</div>';
				$out .= mmpm_ntab(6) . '<div id="' . str_replace( array('[',']',' '), array('','','-'), $option['key'] ) . '" class="panel-collapse collapse col-xs-12">';
				break;
			case 'collapse_end':
				$out .= mmpm_ntab(6) . '</div><!-- class="panel-collapse collapse col-xs-12" -->';
				$out .= mmpm_ntab(5) . '</div><!--  class="panel" -->';
				break;
			case 'devider':
				$out .= mmpm_ntab(7) . '<div class="option row devider ' . $option['key'] . ' ' . $option['type'] . '">';
				$out .= mmpm_ntab(8) . '<div class="col-xs-12">';
				$out .= mmpm_ntab(9) . '<div class="h_separator">';
				$out .= mmpm_ntab(9) . '</div><!-- class="h_separator" -->';
				$out .= mmpm_ntab(9) . '<div class="h_separator">';
				$out .= mmpm_ntab(9) . '</div><!-- class="h_separator" -->';
				$out .= mmpm_ntab(9) . '<div class="h_separator">';
				$out .= mmpm_ntab(9) . '</div><!-- class="h_separator" -->';
				$out .= mmpm_ntab(8) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(7) . '</div><!-- class="option row devider ' . $option['key'] . ' ' . $option['type'] . '" -->';
				break;
			case 'skin_options_generator':
				$out .= mmpm_skin_options_generator();
				break;
			case 'color':
				$value = ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
					? esc_attr( $mmpm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: ( isset( $option['values'] ) 
							? esc_attr( $option['values'] ) 
							: '#808080'
						)
					) 
				);

				$out .= mmpm_ntab(7) . '<div class="color_picker">';
				$out .= mmpm_ntab(8) . '<div class="row">';
				$out .= mmpm_ntab(9) . '<div class="input-append color input-group input-group-sm col-xs-3" data-color="' . $value . '" data-color-format="rgba" id="' . $clear_key . '_colorpicker">';
				$out .= mmpm_ntab(10) . '<input class="form-control col-xs-12" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . $value . '">';
				$out .= mmpm_ntab(10) . '<span class="input-group-addon add-on"><i style="background-color: ' . $value . ';"> &nbsp; </i></span>';
				$out .= mmpm_ntab(9) . '</div>';
				$out .= mmpm_ntab(8) . '</div><!-- class="row" -->';
				$out .= mmpm_ntab(7) . '</div><!-- class="color_picker" -->';
				$out .= '
					<script language="JavaScript">
						jQuery(document).ready(function($){
						    jQuery(\'#' . $clear_key . '_colorpicker\').colorpicker();
						});	
					</script>';
				break;
			case 'font':
				$out .= mmpm_ntab(7) . '<div class="font_selector row">';
				if ( $option['values'] == '' || ( is_array( $option['values'] ) && in_array( 'font_family', $option['values'] ) ) ) {
					$out .= mmpm_ntab(8) . '<div class="col-md-3 col-sm-6 col-xs-3 family">';
					$out .= mmpm_ntab(9) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_family]">';

					$set_of_google_fonts = ( mmpm_get_option( 'set_of_google_fonts' ) ) ? mmpm_get_option( 'set_of_google_fonts' ) : array();
					unset( $set_of_google_fonts['0'] );
					$set_of_google_fonts[] = array( 'family' => 'Arial' );
					$set_of_google_fonts[] = array( 'family' => 'Courier New' );
					$set_of_google_fonts[] = array( 'family' => 'Tahoma' );
					$set_of_google_fonts[] = array( 'family' => 'Times New Roman' );
					$set_of_google_fonts[] = array( 'family' => 'Verdana' );

					$out .= mmpm_ntab(10) . '<optgroup label="' . __( 'Installed Google Fonts', MMPM_TEXTDOMAIN_ADMIN ). '">';
					foreach ( $set_of_google_fonts as $key => $value ) {
						if ( $value['family'] == 'Arial' ) {
							$out .= mmpm_ntab(10) . '</optgroup>';
							$out .= mmpm_ntab(10) . '<optgroup label="' . __( 'Safe Web Fonts (Recommended)', MMPM_TEXTDOMAIN_ADMIN ). '">';
						}
						$out .= mmpm_ntab(10) . '<option value="' . $value['family'] .'" ' . ( ( isset( $mmpm_saved_value['font_family'] ) && $mmpm_saved_value['font_family'] !== false ) 
							? ( $value['family'] == $mmpm_saved_value['font_family'] 
								? 'selected="selected" ' 
								: ''
							)
							: ( ( isset( $option['default']['font_family'] ) && $value['family'] == $option['default']['font_family'] ) 
								? 'selected="selected" ' 
								: ''
							)
						) . '>' . $value['family'] .'</option>';
					}
					$out .= mmpm_ntab(10) . '</optgroup>';
					$out .= mmpm_ntab(9) . '</select>';
					$out .= mmpm_ntab(8) . '</div><!-- class="col-md-3 col-sm-6 col-xs-3 family" -->';
				}
				if ( $option['values'] == '' || ( is_array( $option['values'] ) && in_array( 'font_color', $option['values'] ) ) ) {
					$out .= mmpm_ntab(8) . '<div class="col-md-3 col-sm-6 col-xs-3 color">';
					$value = ( ( isset( $mmpm_saved_value['font_color'] ) && $mmpm_saved_value['font_color'] !== false ) 
						? esc_attr( $mmpm_saved_value['font_color'] ) 
						: ( isset( $option['default']['font_color'] ) 
							? esc_attr( $option['default']['font_color'] )  
							: ( isset( $option['values']['font_color'] ) 
								? esc_attr( $option['values']['font_color'] ) 
								: '#808080'
							)
						) 
					);
					$out .= mmpm_ntab(9) . '<div class="color_picker">';
					$out .= mmpm_ntab(10) . '<div class="row">';
					$out .= mmpm_ntab(11) . '<div class="input-append color input-group input-group-sm col-xs-12" data-color="' . $value . '" data-color-format="rgba" id="' . $clear_key . '_colorpicker">';
					$out .= mmpm_ntab(12) . '<input class="form-control col-xs-12" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_color]" value="' . $value . '">';
					$out .= mmpm_ntab(12) . '<span class="input-group-addon add-on"><i style="background-color: ' . $value . ';"> &nbsp; </i></span>';
					$out .= mmpm_ntab(11) . '</div>';
					$out .= mmpm_ntab(10) . '</div><!-- class="row" -->';
					$out .= mmpm_ntab(9) . '</div><!-- class="color_picker" -->';
					$out .= '
					<script language="JavaScript">
						jQuery(document).ready(function($){
						    jQuery(\'#' . $clear_key . '_colorpicker\').colorpicker();
						});	
					</script>';
/*
					$out .= mmpm_ntab(9) . '<div class="color_picker no_bootstrap">';
					$out .= mmpm_ntab(10) . '<input type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_color]" value="' . ( ( isset( $mmpm_saved_value['font_color'] ) && $mmpm_saved_value['font_color'] !== false ) 
						? esc_attr( $mmpm_saved_value['font_color'] ) 
						: ( isset( $option['default']['font_color'] ) 
							? esc_attr( $option['default']['font_color'] )  
							: ( isset( $option['values']['font_color'] ) 
								? esc_attr( $option['values']['font_color'] ) 
								: '#808080'
							)
						) 
					) . '" />';
					$out .= mmpm_ntab(9) . '</div><!-- class="color_picker no_bootstrap" -->';
					$out .= '
						<script language="JavaScript">
							jQuery(document).ready(function($){
							    jQuery(\'input[name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_color]"]\').wpColorPicker({
									palettes: mmpm_theme_palettes
								});
							});	
						</script>';
*/
					$out .= mmpm_ntab(8) . '</div><!-- class="col-md-3 col-sm-6 col-xs-3 color" -->';
				}
				if ( $option['values'] == '' || ( is_array( $option['values'] ) && in_array( 'font_size', $option['values'] ) ) ) {
					$out .= mmpm_ntab(8) . '<div class="input-group input-group-sm col-lg-3 col-md-4 col-sm-6 col-xs-3 size">';
					$out .= mmpm_ntab(9) . '<input class="form-control col-xs-12" type="number" step="1" min="4" max="120" name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_size]" value="' . ( ( isset( $mmpm_saved_value['font_size'] ) && $mmpm_saved_value['font_size'] !== false ) 
						? esc_attr( $mmpm_saved_value['font_size'] ) 
						: ( isset( $option['default']['font_size'] ) 
							? esc_attr( $option['default']['font_size'] )  
							: ( isset( $option['values']['font_size'] ) 
								? $option['values']['font_size']
								: '14'
							)
						) 
					) . '" />';
					$out .= mmpm_ntab(9) . '<span class="input-group-addon">px</span>';
					$out .= mmpm_ntab(8) . '</div><!-- class="input-group input-group-sm col-lg-3 col-md-4 col-sm-6 col-xs-3 size" -->';
				}
				if ( $option['values'] == '' || ( is_array( $option['values'] ) && in_array( 'font_weight', $option['values'] ) ) ) {
					$out .= mmpm_ntab(8) . '<div class="col-lg-3 col-md-2 col-sm-6 col-xs-3 weight">';
					$out .= mmpm_ntab(9) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[font_weight]">';
					foreach ( range( 300, 900, 100 ) as $key => $value ) {
						$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['font_weight'] ) && $mmpm_saved_value['font_weight'] !== false ) 
							? ( $value == $mmpm_saved_value['font_weight'] 
								? 'selected="selected" ' 
								: ''
							)
							: ( ( isset( $option['default']['font_weight'] ) && $value == $option['default']['font_weight'] ) 
								? 'selected="selected" ' 
								: ''
							)
						) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
					}
					$out .= mmpm_ntab(9) . '</select>';
					$out .= mmpm_ntab(8) . '</div><!-- class="col-lg-3 col-md-2 col-sm-6 col-xs-3 weight" -->';
				}
				$out .= mmpm_ntab(7) . '</div><!-- class="font_selector row" -->';
				break;
			case 'background_image':
				// below calls scripts and styles for media library uploader.
				if ( !isset( $theme_option_file ) ) {
					static $theme_option_file = 1;
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_script('jquery');
					wp_enqueue_style('thickbox');
				}

				$out .= mmpm_ntab(9) . '<div class="row background_image_selcetor">';
				$out .= mmpm_ntab(10) . '<div class="input-group input-group-sm col-xs-9">';
				$out .= mmpm_ntab(10) . '<input class="upload form-control col-xs-8" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[background_image]" value="' . ( ( isset( $mmpm_saved_value['background_image'] ) && $mmpm_saved_value['background_image'] !== false ) 
											? $mmpm_saved_value['background_image'] 
											: ( isset( $option['default']['background_image'] ) 
												? esc_attr( $option['default']['background_image'] )  
												: ( isset( $option['values']['background_image'] ) 
													? $option['values']['background_image'] 
													: ''
												)
											) 
				) . '" />';
				/*  name="' . $option['key'] . '" */
				$out .= mmpm_ntab(11) . '<span class="input-group-btn">';
				$out .= mmpm_ntab(12) . '<input class="' . $clear_full_key . ' select_file_button btn btn-primary" type="button" value="' . __( 'Select Image', MMPM_TEXTDOMAIN_ADMIN ) . '" />';
				$out .= mmpm_ntab(11) . '</span><!-- class="input-group-btn" -->';
				$out .= mmpm_ntab(10) . '</div><!-- class="input-group" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(11) . '<img class="img_preview" data-imgprev="' . $clear_full_key . '" src="' . ( ( isset( $mmpm_saved_value['background_image'] ) ) 
											? $mmpm_saved_value['background_image'] 
											: ( isset( $option['default']['background_image'] ) 
												? esc_attr( $option['default']['background_image'] )  
												: ( isset( $option['values']['background_image'] ) 
													? $option['values']['background_image'] 
													: ''
												)
											) 
				) . '" />';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-12 pull-left">&nbsp;';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(11) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[background_repeat]">';
				foreach ( array('repeat','no-repeat','repeat-x','repeat-y') as $key => $value ) {
					$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['background_repeat'] ) && $mmpm_saved_value['background_repeat'] !== false ) 
						? ( $value == $mmpm_saved_value['background_repeat'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_repeat'] ) && $value == $option['default']['background_repeat'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= mmpm_ntab(1) . '</select>';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(1) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[background_attachment]">';
				foreach ( array('scroll','fixed') as $key => $value ) {
					$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['background_attachment'] ) && $mmpm_saved_value['background_attachment'] !== false ) 
						? ( $value == $mmpm_saved_value['background_attachment'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_attachment'] ) && $value == $option['default']['background_attachment'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= mmpm_ntab(1) . '</select>';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(1) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[background_position]">';
				foreach ( array('center','center left','center right','top left','top center','top righ','bottom left','bottom center','bottom right') as $key => $value ) {
					$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['background_position'] ) && $mmpm_saved_value['background_position'] !== false ) 
						? ( $value == $mmpm_saved_value['background_position'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_position'] ) && $value == $option['default']['background_position'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= mmpm_ntab(1) . '</select>';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-3">';
				$out .= mmpm_ntab(1) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[background_size]">';
				foreach ( array( __( 'Keep original', MMPM_TEXTDOMAIN_ADMIN ) => 'auto', __( 'Stretch to width', MMPM_TEXTDOMAIN_ADMIN ) => '100% auto', __( 'Stretch to height', MMPM_TEXTDOMAIN_ADMIN ) => 'auto 100%','cover','contain') as $key => $value ) {
					$out .= mmpm_ntab(10) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['background_size'] ) && $mmpm_saved_value['background_size'] !== false ) 
						? ( $value == $mmpm_saved_value['background_size'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_size'] ) && $value == $option['default']['background_size'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= mmpm_ntab(1) . '</select>';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-3" -->';
				$out .= '<script language="JavaScript"> mmpm_file_upload( \'' . MMPM_PREFIX . '_' . $option['key'] . '[background_image]\', \'' . $clear_full_key . '\' ); </script>';
				$out .= mmpm_ntab(9) . '</div><!-- class="row" -->';
				break;
			case 'gradient':
				if ( !isset( $theme_option_color ) ) {
					static $theme_option_color = 1;
					wp_enqueue_style( 'wp-color-picker' );
					wp_enqueue_script( 'wp-color-picker' );
				}			
				$out .= mmpm_ntab(9) . '<div class="row gradient_selcetor">';
				$out .= mmpm_ntab(10) . '<div class="col-xs-8">';
				$out .= mmpm_ntab(11) . '<div class="row">';
				$out .= mmpm_ntab(12) . '<div class="col-xs-5">';
				$value = ( ( isset( $mmpm_saved_value['color1'] ) && $mmpm_saved_value['color1'] !== false ) 
					? esc_attr( $mmpm_saved_value['color1'] ) 
					: ( isset( $option['default']['color1'] ) 
						? esc_attr( $option['default']['color1'] )  
						: ( isset( $option['values']['color1'] ) 
							? esc_attr( $option['values']['color1'] ) 
							: '#808080'
						)
					) 
				);
				$out .= mmpm_ntab(9) . '<div class="color_picker">';
				$out .= mmpm_ntab(10) . '<div class="row">';
				$out .= mmpm_ntab(11) . '<div class="input-append color input-group input-group-sm col-xs-11" data-color="' . $value . '" data-color-format="rgba" id="' . $clear_key . '_1_colorpicker">';
				$out .= mmpm_ntab(12) . '<input class="form-control col-xs-12" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[color1]" value="' . $value . '">';
				$out .= mmpm_ntab(12) . '<span class="input-group-addon add-on"><i style="background-color: ' . $value . ';"> &nbsp; </i></span>';
				$out .= mmpm_ntab(11) . '</div>';
				$out .= mmpm_ntab(10) . '</div><!-- class="row" -->';
				$out .= mmpm_ntab(9) . '</div><!-- class="color_picker" -->';
				$out .= '
				<script language="JavaScript">
					jQuery(document).ready(function($){
					    jQuery(\'#' . $clear_key . '_1_colorpicker\').colorpicker();
					});	
				</script>';
/*
				$out .= mmpm_ntab(13) . '<div class="color_picker no_bootstrap">';
				$out .= mmpm_ntab(14) . '<input type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[color1]" value="' . ( ( isset( $mmpm_saved_value['color1'] ) && $mmpm_saved_value['color1'] !== false ) 
					? esc_attr( $mmpm_saved_value['color1'] ) 
					: ( isset( $option['default']['color1'] ) 
						? esc_attr( $option['default']['color1'] )  
						: ( isset( $option['values']['color1'] ) 
							? esc_attr( $option['values']['color1'] ) 
							: '#808080'
						)
					) 
				) . '" />';
				$out .= mmpm_ntab(13) . '</div><!-- class="color_picker no_bootstrap" -->';
				$out .= '
					<script language="JavaScript">
						jQuery(document).ready(function($){
						    jQuery(\'input[name="' . MMPM_PREFIX . '_' . $option['key'] . '[color1]"]\').wpColorPicker({
								palettes: mmpm_theme_palettes
							});
						});	
					</script>';
*/
				$out .= mmpm_ntab(12) . '</div><!-- class="col-xs-5" -->';
				$out .= mmpm_ntab(12) . '<div class="col-xs-2 start_end">';
				$out .= mmpm_ntab(13) . __( 'Start', MMPM_TEXTDOMAIN_ADMIN );
				$out .= mmpm_ntab(12) . '</div><!-- class="col-xs-2" -->';
				$out .= mmpm_ntab(12) . '<div class="input-group input-group-sm col-xs-5">';
				$out .= mmpm_ntab(13) . '<input class="form-control col-xs-12" type="number" step="1" min="0" max="100" name="' . MMPM_PREFIX . '_' . $option['key'] . '[start]" value="' . ( ( isset( $mmpm_saved_value['start'] ) && $mmpm_saved_value['start'] !== false ) 
					? esc_attr( $mmpm_saved_value['start'] ) 
					: ( isset( $option['default']['start'] ) 
						? esc_attr( $option['default']['start'] )  
						: ( isset( $option['values']['start'] ) 
							? $option['values']['start']
							: '0'
						)
					) 
				) . '" />';
				$out .= mmpm_ntab(13) . '<span class="input-group-addon">%</span>';
				$out .= mmpm_ntab(12) . '</div><!-- class="input-group input-group-sm col-xs-5" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-12 vertical_padding pull-left">';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(12) . '<div class="col-xs-5">';
				$value = ( ( isset( $mmpm_saved_value['color2'] ) && $mmpm_saved_value['color2'] !== false ) 
					? esc_attr( $mmpm_saved_value['color2'] ) 
					: ( isset( $option['default']['color2'] ) 
						? esc_attr( $option['default']['color2'] )  
						: ( isset( $option['values']['color2'] ) 
							? esc_attr( $option['values']['color2'] ) 
							: '#808080'
						)
					) 
				);
				$out .= mmpm_ntab(9) . '<div class="color_picker">';
				$out .= mmpm_ntab(10) . '<div class="row">';
				$out .= mmpm_ntab(11) . '<div class="input-append color input-group input-group-sm col-xs-11" data-color="' . $value . '" data-color-format="rgba" id="' . $clear_key . '_2_colorpicker">';
				$out .= mmpm_ntab(12) . '<input class="form-control col-xs-12" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[color2]" value="' . $value . '">';
				$out .= mmpm_ntab(12) . '<span class="input-group-addon add-on"><i style="background-color: ' . $value . ';"> &nbsp; </i></span>';
				$out .= mmpm_ntab(11) . '</div>';
				$out .= mmpm_ntab(10) . '</div><!-- class="row" -->';
				$out .= mmpm_ntab(9) . '</div><!-- class="color_picker" -->';
				$out .= '
				<script language="JavaScript">
					jQuery(document).ready(function($){
					    jQuery(\'#' . $clear_key . '_2_colorpicker\').colorpicker();
					});	
				</script>';
/*
				$out .= mmpm_ntab(13) . '<div class="color_picker no_bootstrap">';
				$out .= mmpm_ntab(14) . '<input type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '[color2]" value="' . ( ( isset( $mmpm_saved_value['color2'] ) && $mmpm_saved_value['color2'] !== false ) 
					? esc_attr( $mmpm_saved_value['color2'] ) 
					: ( isset( $option['default']['color2'] ) 
						? esc_attr( $option['default']['color2'] )  
						: ( isset( $option['values']['color2'] ) 
							? esc_attr( $option['values']['color2'] ) 
							: '#808080'
						)
					) 
				) . '" />';
				$out .= mmpm_ntab(13) . '</div><!-- class="color_picker no_bootstrap" -->';
				$out .= '
					<script language="JavaScript">
						jQuery(document).ready(function($){
						    jQuery(\'input[name="' . MMPM_PREFIX . '_' . $option['key'] . '[color2]"]\').wpColorPicker({
								palettes: mmpm_theme_palettes
							});
						});	
					</script>';
*/
				$out .= mmpm_ntab(12) . '</div><!-- class="col-xs-5" -->';
				$out .= mmpm_ntab(12) . '<div class="col-xs-2 start_end">';
				$out .= mmpm_ntab(13) . __( 'End', MMPM_TEXTDOMAIN_ADMIN );
				$out .= mmpm_ntab(12) . '</div><!-- class="col-xs-2" -->';
				$out .= mmpm_ntab(12) . '<div class="input-group input-group-sm col-xs-5">';
				$out .= mmpm_ntab(13) . '<input class="form-control col-xs-12" type="number" step="1" min="0" max="100" name="' . MMPM_PREFIX . '_' . $option['key'] . '[end]" value="' . ( ( isset( $mmpm_saved_value['end'] ) && $mmpm_saved_value['end'] !== false ) 
					? esc_attr( $mmpm_saved_value['end'] ) 
					: ( isset( $option['default']['end'] ) 
						? esc_attr( $option['default']['end'] )  
						: ( isset( $option['values']['end'] ) 
							? $option['values']['end']
							: '100'
						)
					) 
				) . '" />';
				$out .= mmpm_ntab(13) . '<span class="input-group-addon">%</span>';
				$out .= mmpm_ntab(12) . '</div><!-- class="input-group input-group-sm col-xs-5" -->';
				$out .= mmpm_ntab(11) . '</div><!-- class="row" -->';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-8" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-4">';
				$out .= mmpm_ntab(11) . '<select class="col-xs-12 form-control input-sm" name="' . MMPM_PREFIX . '_' . $option['key'] . '[orientation]">';
				foreach ( array( __( 'Vertical', MMPM_TEXTDOMAIN_ADMIN ) => 'top', __( 'Horizontal', MMPM_TEXTDOMAIN_ADMIN ) => 'left', __( 'Radial', MMPM_TEXTDOMAIN_ADMIN ) => 'radial') as $key => $value ) {
					$out .= mmpm_ntab(12) . '<option value="' . $value .'" ' . ( ( isset( $mmpm_saved_value['orientation'] ) && $mmpm_saved_value['orientation'] !== false ) 
						? ( $value == $mmpm_saved_value['orientation'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['orientation'] ) && $value == $option['default']['orientation'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= mmpm_ntab(11) . '</select>';
				$out .= mmpm_ntab(10) . '<div class="col-xs-12 vertical_padding pull-left">';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-12" -->';
				$out .= mmpm_ntab(10) . '<div class="col-xs-12 gradient_example pull-left">';
				$out .= mmpm_ntab(11) . __( 'Click Here For View Result', MMPM_TEXTDOMAIN_ADMIN );
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-12 gradient_example" -->';
				$out .= mmpm_ntab(10) . '</div><!-- class="col-xs-4" -->';
				$out .= '
					<script language="JavaScript">
						mmpm_gradient_example( \'' . $clear_full_key . '\' );
					</script>';
				$out .= mmpm_ntab(9) . '</div><!-- class="row" -->';
				break;
			default /* 'textfield' */:
				$out .= mmpm_ntab(9) . '<input class="col-xs-12 form-control input-sm" type="text" name="' . MMPM_PREFIX . '_' . $option['key'] . '" value="' . ( ( isset( $mmpm_saved_value ) && $mmpm_saved_value !== false ) 
					? esc_attr( $mmpm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: ( isset( $option['values'] ) 
							? esc_attr( $option['values'] ) 
							: ''
						)
					) 
				) . '" />';
				break;
		}

		if ( isset( $option['dependency'] ) && is_array( $option['dependency'] ) && isset( $option['dependency']['element'] ) && isset( $option['dependency']['value'] ) ) {
			static $dependency_id = -1;
			$dependency_id ++;
			$GLOBALS['dependency_element'] = $option['dependency']['element'];
			$GLOBALS['dependency_id'] = $dependency_id;
			$out .= mmpm_ntab(8) . '<script language="JavaScript">';
			$out .= mmpm_ntab(8) . 'dependency_selector_' . $dependency_id . ' = \'*[name*="' . MMPM_PREFIX . '_' . $option['key'] . '"]\';';
			if ( is_array( $option['dependency']['value'] ) ) {
				$out .= mmpm_ntab(8) . 'dependency_value_' . $dependency_id . ' = [\'' . implode( '\',\'', $option['dependency']['value'] ). '\'];';
			} else {
				$out .= mmpm_ntab(8) . 'dependency_value_' . $dependency_id . ' = \'' . $option['dependency']['value'] . '\';';
			}
			if ( is_array( $option['dependency']['element'] ) ) {
				$out .= mmpm_ntab(8) . 'childrens_selector_' . $dependency_id . ' = [\'' . implode( $dependency_id . '\',\'', $option['dependency']['element'] ) . $dependency_id . '\'];';
			} else {
				$out .= mmpm_ntab(8) . 'childrens_selector_' . $dependency_id . ' = \'' . $option['dependency']['element'] . $dependency_id . '\';';
			}
			$out .= mmpm_ntab(8) . 'mmpm_dependency( dependency_selector_' . $dependency_id . ', dependency_value_' . $dependency_id . ', childrens_selector_' . $dependency_id . ' );'; 
			$out .= mmpm_ntab(8) . '</script>';
		}

		if ( $option['type'] != 'collapse_start' && $option['type'] != 'collapse_end' && $option['type'] != 'skin_options_generator' && $option['type'] != 'caption' ) {
			$section = '';
			$section .= mmpm_ntab(6) . '<div class="bootstrap">';
			$section .= mmpm_ntab(7) . '<div class="option row ' . str_replace( array( MMPM_OPTIONS_NAME, '[',']'), '', $option['key'] ) . ' ' .  $option['type'] . '_type" id="' . $clear_key . ( ( isset( $GLOBALS['dependency_element'] ) && ( $GLOBALS['dependency_element'] == $clear_key || (is_array( $GLOBALS['dependency_element'] ) && in_array( $clear_key, $GLOBALS['dependency_element'] ) ) ) ) ? $GLOBALS['dependency_id'] : '' ) . '">';
			$section .= mmpm_ntab(8) . '<div class="col-xs-12">';
			$section .= mmpm_ntab(9) . '<div class="h_separator">';
			$section .= mmpm_ntab(9) . '</div><!-- class="h_separator" -->';
			$section .= mmpm_ntab(8) . '</div><!-- class="col-xs-12" -->';
			$section .= mmpm_ntab(8) . '<div class="option_header col-md-3 col-sm-12">';
			$section .= mmpm_ntab(9) . '<div class="caption">';
			$section .= mmpm_ntab(10) . $option['name'];
			$section .= mmpm_ntab(9) . '</div><!-- class="caption" -->';
			$section .= mmpm_ntab(9) . '<div class="descr">';
			$section .= mmpm_ntab(10) . $option['descr'];
			$section .= mmpm_ntab(9) . '</div><!-- class="descr" -->';
			$section .= mmpm_ntab(8) . '</div><!-- class="option_header col-3" -->';
			$section .= mmpm_ntab(8) . '<div class="option_field col-md-9 col-sm-12">';
			$section .= $out;
			$section .= mmpm_ntab(8) . '</div><!-- class="option_field col-9" -->';
			$section .= mmpm_ntab(7) . '</div><!-- class="option row ' . str_replace( array( MMPM_OPTIONS_NAME, '[',']'), '', $option['key'] ) . '" -->';
			$section .= mmpm_ntab(6) . '</div><!-- class="bootstrap" -->';
			$out = $section;
		}
		return $out;
	}
?>