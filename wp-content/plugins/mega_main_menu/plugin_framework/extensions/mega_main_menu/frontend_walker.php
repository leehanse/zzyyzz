<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
    class Mega_Main_Walker_Nav_Menu extends Walker_Nav_Menu {
        /**
         * default_menu_item 
         */
        function default_menu_item( &$output, $args, $item, $depth ) {
            $args = (object)$args;
            $item = (object)$item;
            $indent = str_repeat("\t", $depth);
            $class_names = $value = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names .= ' ' . implode(' ', array( str_replace( array('first_','second_'), '', $args->_submenu_type ), $args->_item_style, $args->_submenu_drops_side, $args->_submenu_disable_icons, $args->_submenu_enable_full_width, 'columns' . $args->_submenu_columns ) );
            $class_names = str_replace( ' dropdown ', ' ', $class_names );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
            if ( $depth == '1' && get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_type', true) == 'multicolumn_dropdown' ) {
                $columns = get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_columns', true) 
                    ? get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_columns', true) 
                    : 1;
                $item_width = ' style="width:' . floor( 100 / $columns ) . '%;"'; 
            } else {
                $item_width = '';
            }

            $output .= $indent . '<li' . $id . $value . $class_names . $item_width .'>';

            $_disable_text = get_post_meta( $item->ID, MMPM_PREFIX . '_disable_text', true );
            $link_class = ( is_array( $_disable_text ) && in_array( 'true', $_disable_text ) ) ? ' menu_item_without_text' : '';

            $link_before = '<span>' . $args->link_before;
            $link_after = $args->link_after . '</span>';

            $item->icon = get_post_meta( $item->ID, MMPM_PREFIX . '_item_icon', true)
                ? get_post_meta( $item->ID, MMPM_PREFIX . '_item_icon', true)
                : 'im-icon-checkmark-3';

            $_disable_icon = get_post_meta( $item->ID, MMPM_PREFIX . '_disable_icon', true );
            $_disable_link = ( is_array( get_post_meta( $item->ID, MMPM_PREFIX . '_disable_link', true ) ) && in_array( 'true', get_post_meta( $item->ID, MMPM_PREFIX . '_disable_link', true ) ) ) ? true : false ;
            $link_class .= ( is_array( $_disable_icon ) && in_array( 'true', $_disable_icon ) ) ? ' disable_icon' : ' with_icon';

            $item_icon = '<i class="' . $item->icon . '"></i> ';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
//            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ( !empty( $item->url ) && $_disable_link !== true ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ! empty( $link_class ) ? ' class="item_link ' . $link_class . '"' : '';

            $item_output = '';
            $item_output .= $args->before;
            $item_output .= '<' . ( $_disable_link !== true ? 'a' : 'span' ) . $attributes .'>';
            $item_output .= $item_icon;
            $item_output .= $link_before;
            $item_output .= '<span class="link_text">' . apply_filters( 'the_title', $item->title, $item->ID ) . '</span>';
            $item_output .= $link_after;
            $item_output .= '</' . ( $_disable_link !== true ? 'a' : 'span' ) . '>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * grid_dropdown 
         */
        function grid_dropdown( &$output, $args, $item, $depth ) {
            $args = (object)$args;
            $item = (object)$item;
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $class_names = $value = '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names .= ' ' . implode(' ', array( $args->_submenu_type, $args->_submenu_drops_side, $args->_submenu_disable_icons, 'columns' . $args->_submenu_columns ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $columns = get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_columns', true) 
                ? get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_columns', true) 
                : 2;
            $enable_full_width = get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_columns', true);
            $_submenu_enable_full_width = is_array( get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_enable_full_width', true ) ) 
                ? get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_enable_full_width', true ) 
                : array();
            $dropdown_width = ( in_array( 'true', $_submenu_enable_full_width ) ) 
                ? 1140
                : 450;
            $item_width_height = 100 / $columns;
            $img_width_height = floor( 1140 / $columns ); 
            $details_height = floor( $dropdown_width / 3 );
            $item->icon = get_post_meta( $item->ID, MMPM_PREFIX . '_item_icon', true)
                ? get_post_meta( $item->ID, MMPM_PREFIX . '_item_icon', true)
                : 'im-icon-checkmark-3';

            $output .= $indent . '<li' . $id . $value . $class_names .' style="width:' . $item_width_height . '%;">';

            if ( get_the_post_thumbnail( $item->object_id, 'thumbnail' ) != false ) {
                $item_icon = mmpm_get_processed_image( $img_args = array( 'post_id' => $item->object_id, 'width'=> $img_width_height, 'height' => $img_width_height, 'permalink' => get_permalink( $item->object_id ), 'icon' => $item->icon, 'cover' => 'icon' ) );
            } else {
                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
//                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ( !empty( $item->url ) && get_post_meta( $item->ID, MMPM_PREFIX . '_disable_link', true) != '1' ) ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
                $attributes .= ' class="item_link ' . ( !empty( $link_class ) ? $link_class : '' ) . ' witout_img"';

                $item_icon = '<a'. $attributes .'>';
                $item_icon .= '<i class="' . $item->icon . '"></i> ';            
                $item_icon .= '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABdJREFUeNpi/P//PwM6YGLAAigUBAgwADZQAwcsn51XAAAAAElFTkSuQmCC" alt="placeholder"/>';
                $item_icon .= '</a>';
            }

            $item_output = '';
            $item_output .= $args->before;
            $item_output .= $item_icon;
            $item_output .= $args->after;
            $item_output .= '<div class="post_details">';
            if ( get_the_post_thumbnail( $item->object_id, 'thumbnail' ) != false ) {
                $item_output .= mmpm_get_processed_image( $img_args = array( 'post_id' => $item->object_id, 'width'=> $dropdown_width, 'height' => $details_height, 'permalink' => get_permalink( $item->object_id ), 'icon' => $item->icon, 'cover' => 'icon' ) );
            }
            $item_output .= '<div class="post_icon pull-left"><i class="' . $item->icon . '"></i></div>';
            $item_output .= '<div class="post_title">';
            $item_output .= '<a rel="bookmark" href="' . esc_url( get_permalink($item->object_id) ) . '" title="' . esc_attr( get_the_title($item->object_id) ) . '">' . get_the_title($item->object_id) . '</a>';
            $item_output .= '</div>';
            if ( isset( $item->description ) && $item->description != '' ) {
                $item_output .= '<div class="post_description">';
                $item_output .= mmpm_excerpt( $item->description );
                $item_output .= '</div>';
            }
            $item_output .= '</div><!-- /.post_details -->';

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * post_type_dropdown 
         */
        function post_type_dropdown( &$output, $args ) {
            $args = (array)$args;
            global $wpdb; //, $shortname 
            $showposts = get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_columns', true) * 2;
            $post_type = get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_post_type', true);
            $recent_query = get_posts(array(
                'post_type' => $post_type,
                'showposts' => $showposts,
                'nopaging' => 0,
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1
            ));

            if ( count( $recent_query ) ) {
                $columns = get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_columns', true) ? get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_columns', true) : 2;
                $enable_full_width = get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_columns', true);
                $_submenu_enable_full_width = is_array( get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_enable_full_width', true ) ) 
                    ? get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_enable_full_width', true ) 
                    : array();
                $dropdown_width = ( in_array( 'true', $_submenu_enable_full_width ) ) 
                    ? 1140 
                    : 450;
                $item_width_height = 100 / $columns;
                $img_width_height = floor( 1140 / $columns ); 
                $details_height = floor( $dropdown_width / 3 );

                foreach ( $recent_query as $key => $post_object ) {
                    $post_icon = get_post_meta( $post_object->ID, MMPM_PREFIX . '_post_icon', true)
                        ? get_post_meta( $post_object->ID, MMPM_PREFIX . '_post_icon', true)
                        : 'im-icon-checkmark-3';
                    $output .= '<li class="post_item" style="width:' . $item_width_height . '%;">';
                    if ( wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), 'full' ) ) {
                        $output .= mmpm_get_processed_image( $img_args = array( 'post_id' => $post_object->ID, 'width'=> $img_width_height, 'height' => $img_width_height, 'permalink' => get_permalink( $post_object->ID ), 'icon' => $post_icon, 'cover' => 'icon' ) );
                    } else {
                        $output .= '<a class="item_link" href="' . get_permalink( $post_object->ID ) . '" title="' . get_the_title( $post_object->ID ) . '">';
                        $output .= '<i class="' . $post_icon . '"></i>';
                        $output .= '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAUAAAAFCAYAAACNbyblAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAABdJREFUeNpi/P//PwM6YGLAAigUBAgwADZQAwcsn51XAAAAAElFTkSuQmCC" alt="placeholder"/>';
                        $output .= '</a>';
                    }
                    $output .= '<div class="post_details">';
                    if ( wp_get_attachment_image_src( get_post_thumbnail_id( $post_object->ID ), 'full' ) ) {
                        $output .= mmpm_get_processed_image( $img_args = array( 'post_id' => $post_object->ID, 'width'=> $dropdown_width, 'height' => $details_height, 'permalink' => get_permalink( $post_object->ID ), 'icon' => $post_icon, 'cover' => false ) );
                    }
                    $output .= '<div class="post_icon"><i class="' .$post_icon . '"></i></div>';
                    $output .= '<div class="post_title">';
                    $output .=  $post_object->post_title;
                    $output .= '</div>';
                    $output .= '<div class="post_description">';
                    $output .= mmpm_excerpt( $post_object->post_content );
                    $output .= '</div>';
                    $output .= '</div><!-- /.post_details -->';
                    $output .= '</li><!-- /.post_item -->';
                } 
            }
//            $output .= '<span class="clearboth"></span><!-- /.clearboth -->';
        }

        /**
         * custom_dropdown 
         */
/* for better times
        function custom_dropdown( &$output, $args ) {
                $output .= '<div class="submenu_custom_content">' . do_shortcode( get_post_meta( $args['menu_main_parent'], MMPM_PREFIX . '_submenu_custom_content', true) ) . '</div><!-- /.submenu_custom_content -->';
        }
*/
        /**
         * widgets_dropdown 
         */
        function widgets_first_dropdown( &$output, $args ) {
            ob_start();
                dynamic_sidebar( MMPM_PREFIX . '_menu_first_widgets_area' );
                $output .= ob_get_contents();
            ob_end_clean();
        }
        function widgets_second_dropdown( &$output, $args ) {
            ob_start();
                dynamic_sidebar( MMPM_PREFIX . '_menu_second_widgets_area' );
                $output .= ob_get_contents();
            ob_end_clean();
        }

        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $args = (object)$args;
            $img = ( (string)$depth == '0' && get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_bg_image', true) ) 
                ? get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_bg_image', true) 
                : 'no-img';
            $style = ( is_array( $img ) && $img['background_image'] != '') ? ' style="background-image:url(' . $img['background_image'] . ');background-repeat:' . $img['background_repeat'] . ';background-attachment:' . $img['background_attachment'] . ';background-position:' . $img['background_position'] . ';background-size:' . $img['background_size'] . ';"': '';
            $indent = str_repeat("\t", $depth);
            $output .= "\n" . $indent . '<ul class="mega_dropdown"' . $style . '>' . "\n";
        }

        function end_lvl( &$output, $depth = 0, $args = array() ) {
            $args = (object)$args;
            $indent = str_repeat( "\t", $depth );
                $mmpm_submenu_type = ( get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_type', true) ) ? get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_type', true) : 'default_dropdown';
                if ( $mmpm_submenu_type == 'post_type_dropdown' ) {
                    $args_submenu_type = array( 'menu_item_id' => $args->menu_item_id, 'menu_main_parent' => $args->menu_main_parent );
                    call_user_func_array ( array( $this, 'post_type_dropdown' ), array( &$output, $args_submenu_type ) );
                }
                if ( $mmpm_submenu_type == 'widgets_first_dropdown' || $mmpm_submenu_type == 'widgets_second_dropdown' ) {
                    $args_submenu_type = array( 'menu_item_id' => $args->menu_item_id, 'menu_main_parent' => $args->menu_main_parent );
                    call_user_func_array ( array( $this, $mmpm_submenu_type ), array( &$output, $args_submenu_type ) );
                }
/* for better times
                if ( $mmpm_submenu_type != 'default_dropdown' && $mmpm_submenu_type != 'multicolumn_dropdown' ) {
                    $output .= '<div class="submenu_custom_content">' . do_shortcode( get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_custom_content', true) ) . '</div><!-- /.submenu_custom_content -->';
                } elseif ( $mmpm_submenu_type == 'multicolumn_dropdown' && $args->menu_main_parent == $args->menu_item_parent && $depth == 0 ) {
                    $output .= '<div class="submenu_custom_content">' . do_shortcode( get_post_meta( $args->menu_main_parent, MMPM_PREFIX . '_submenu_custom_content', true) ) . '</div><!-- /.submenu_custom_content -->';
                }
*/
            $output .= "\n" . $indent . "</ul>";
        }

        function start_el( &$output, $item, $depth = 0, $args = '', $id = 0 ) {
            $args = (object)$args;
            $item = (object)$item;
            if ( get_post_meta( $item->menu_item_parent, MMPM_PREFIX . '_submenu_type', true) == 'grid_dropdown' ) {
                call_user_func_array ( array( $this, 'grid_dropdown' ), array( &$output, $args, $item, $depth ) );
            } else {
                call_user_func_array ( array( $this, 'default_menu_item' ), array( &$output, $args, $item, $depth ) );
            }
        }

        function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
            $args[0] = (object)$args[0];
            $element = (object)$element;

            if ( !$element and !isset( $args[0]->menu_main_parent ) )
                return;

            $id_field = $this->db_fields['id'];

            //display this element
            if ( is_array( $args[0] ) ) {
                $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
            }

            $args[0]->menu_item_id = $element->ID;
            $args[0]->menu_item_parent = $element->menu_item_parent;
            if ( $element->menu_item_parent == 0 ) {
                $args[0]->menu_main_parent = $element->ID;
            }
            if ( (string) $depth == '0' ) {
                $args[0]->_submenu_type = ( get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_type', true) ) 
                    ? get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_type', true) 
                    : 'default_dropdown';
                $args[0]->_submenu_drops_side = ( get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_drops_side', true) ) 
                    ? get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_drops_side', true) 
                    : 'drop_to_right';
                $args[0]->_submenu_drops_side = ( $args[0]->_submenu_type == 'default_dropdown' && $args[0]->_submenu_drops_side == 'drop_to_center' )
                    ? 'drop_to_right'
                    : $args[0]->_submenu_drops_side;
                $_submenu_disable_icons = is_array( get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_disable_icons', true ) ) 
                    ? get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_disable_icons', true ) 
                    : array();
                $args[0]->_submenu_disable_icons = ( in_array( 'true', $_submenu_disable_icons ) ) 
                    ? 'submenu_disable_icons' 
                    : '';
                $_submenu_enable_full_width = is_array( get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_enable_full_width', true ) ) 
                    ? get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_enable_full_width', true ) 
                    : array();
                $args[0]->_submenu_enable_full_width = ( in_array( 'true', $_submenu_enable_full_width ) ) 
                    ? 'submenu_full_width' 
                    : 'submenu_default_width';
                $args[0]->_submenu_columns = ( get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_columns', true) ) 
                    ? get_post_meta( $element->ID, MMPM_PREFIX . '_submenu_columns', true)
                    : '';
            } else {
                $args[0]->_submenu_type = $args[0]->_submenu_drops_side = $args[0]->_submenu_disable_icons = $args[0]->_submenu_columns = '';
            }
            $args[0]->_item_style = ( get_post_meta( $element->ID, MMPM_PREFIX . '_item_style', true ) != false ) 
                ? get_post_meta( $element->ID, MMPM_PREFIX . '_item_style', true ) 
                : '';

            $mmpm_submenu_type = ( get_post_meta( $args[0]->menu_main_parent, MMPM_PREFIX . '_submenu_type', true) ) ? get_post_meta( $args[0]->menu_main_parent, MMPM_PREFIX . '_submenu_type', true) : 'default_dropdown';

            if ( ( $mmpm_submenu_type != 'post_type_dropdown' ) || $element->ID == $args[0]->menu_main_parent ) {
                $cb_args = array_merge( array(&$output, $element, $depth), $args);
                call_user_func_array(array($this, 'start_el'), $cb_args);

                $id = $element->$id_field;

                // descend only when the depth is right and there are childrens for this element
                if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

                    foreach( $children_elements[ $id ] as $child ){

                        if ( !isset($newlevel) ) {
                            $newlevel = true;
                            //start the child delimiter
                            $cb_args = array_merge( array(&$output, $depth), $args);
                            call_user_func_array(array($this, 'start_lvl'), $cb_args);
                        }
                        $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
                    }
                    unset( $children_elements[ $id ] );
                } elseif ( $mmpm_submenu_type == 'widgets_first_dropdown' || $mmpm_submenu_type == 'widgets_second_dropdown' || $mmpm_submenu_type == 'post_type_dropdown' /* || $mmpm_submenu_type == 'custom_dropdown' || get_post_meta( $args[0]->menu_item_id, MMPM_PREFIX . '_submenu_custom_content', true) != '' */ ) {
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array($this, 'start_lvl'), $cb_args);
                    call_user_func_array(array($this, 'end_lvl'), $cb_args);
                }

                if ( isset($newlevel) && $newlevel ){
                    //end the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array($this, 'end_lvl'), $cb_args);
                }
            } 

            //end this element
            $cb_args = array_merge( array(&$output, $element, $depth), $args);
            call_user_func_array(array($this, 'end_el'), $cb_args);
        }
    }
?>
