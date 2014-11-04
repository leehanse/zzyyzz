;;;
/* 
 * Common variables and functions.
 */
jQuery(document).ready(function(){
	/* 
	 * mmpm_theme_palettes - default theme preset colors.
	mmpm_theme_palettes = ['#428bca', '#2a6496', '#2ecc71', '#27ae60', '#3498db', '#2980b9', '#e67e22', '#d35400', '#1abc9c', '#16a085', '#e74c3c', '#c0392b', '#95a5a6', '#7f8c8d'];
	 */
	/* 
	 * Function reset z-index for all "color_picker" containers (high to low order).
	zindex_counter = 400;
	jQuery( '.color_picker' ).each(function(){
		jQuery( this ).css({'z-index' : zindex_counter});
		zindex_counter = zindex_counter - 1;
	});
	 */
	/* 
	 * Function remove all "multiplied_example" containers on page before send request.
	 */
	jQuery('.button-primary').click(function(){
		jQuery('.multiplied_example').remove();
		jQuery('#menu-to-edit > li:not(.menu-item-depth-0) div[class*="submenu_"]').remove();
	});

});

/* 
 * Function call ither function which are necessary for "multiplier".
 */
function mmpm_multiplier( multiplier_selector, multiplied_example, containers_selector ){
	jQuery( multiplier_selector ).change(function(){
		mmpm_multiplier_changer( multiplier_selector, multiplied_example, containers_selector );
		mmpm_multiplier_numerator( multiplier_selector, multiplied_example, containers_selector );
	});
	jQuery( multiplier_selector ).keyup(function(){
		mmpm_multiplier_changer( multiplier_selector, multiplied_example, containers_selector );
		mmpm_multiplier_numerator( multiplier_selector, multiplied_example, containers_selector );
	});
	jQuery(function() {
		jQuery( containers_selector ).sortable({ 
			opacity: 0.6, 
			cursor: 'move', 
			distance: 15,
			revert: 150,
			update: function() {
				mmpm_multiplier_numerator( multiplier_selector, multiplied_example, containers_selector );
			}
		});
	});
};

/* 
 * Function check multiplier_value and Add/Removes the need to number of fields.
 */
function mmpm_multiplier_changer( multiplier_selector, multiplied_example, containers_selector ){
	multiplier_value = jQuery(multiplier_selector).val();
	if ( !isNaN(parseFloat(multiplier_value)) && isFinite(multiplier_value) ) {
		containemmpm_count = jQuery(containers_selector + ' > *').size();
		if ( containemmpm_count < multiplier_value ) {
			while ( containemmpm_count < multiplier_value ) {
				containemmpm_clone = jQuery(multiplied_example + ' > *').clone();
				jQuery(containers_selector).append(containemmpm_clone);
				containemmpm_count = containemmpm_count + 1;
			}
		} else if ( containemmpm_count > multiplier_value ) {
			while ( containemmpm_count > multiplier_value ) {
				jQuery(containers_selector + ' > *').last().remove();
				containemmpm_count = containemmpm_count - 1;
			}
		};
	};
};

/* 
 * Function select important multiplied containers id-values and set them current order.
 */
function mmpm_multiplier_numerator( multiplier_selector, multiplied_example, containers_selector ){
	classes_new_id = 1;
	jQuery( containers_selector + ' > div').each(function(index){
		// replace all href="" identificators
		jQuery(this).find('*[href]').each(function(index,element){
			element_href = jQuery(element).attr( 'href' );
			jQuery(element).attr( 'href', element_href.replace( /\d+/g, classes_new_id ) );
			element_text = jQuery(element).text();
			jQuery(element).text( element_text.replace( /\d+/g, classes_new_id ) );
		});
		// replace all id="" identificators
		jQuery(this).find('*[id]').each(function(index,element){
			element_id = jQuery(element).attr( 'id' );
			jQuery(element).attr( 'id', element_id.replace( /\d+/g, classes_new_id ) );
		});
		// replace all name="" identificators
		jQuery(this).find('*[name]').each(function(index,element){
			element_name = jQuery(element).attr( 'name' );
			jQuery(element).attr( 'name', element_name.replace( /\d+/g, classes_new_id ) );
		});
		// replace all data-imgprev="" identificators
		jQuery(this).find('*[data-imgprev]').each(function(index,element){
			element_data = jQuery(element).attr( 'data-imgprev' );
			jQuery(element).attr( 'data-imgprev', element_data.replace( /\d+/g, classes_new_id ) );
		});
		// replace all data-icon="" identificators
		jQuery(this).find('*[data-icon]').each(function(index,element){
			element_data = jQuery(element).attr( 'data-icon' );
			jQuery(element).attr( 'data-icon', element_data.replace( /\d+/g, classes_new_id ) );
		});
		// replace all data-target="" identificators
		jQuery(this).find('*[data-target]').each(function(index,element){
			element_data = jQuery(element).attr( 'data-target' );
			jQuery(element).attr( 'data-target', element_data.replace( /\d+/g, classes_new_id ) );
		});
		// replace all scripts identificators
		jQuery(this).find('script').each(function(index,element){
			element_html = jQuery(element).html();
			jQuery(element).html( element_html.replace( /\d+/g, classes_new_id ) );
		});

		classes_new_id = classes_new_id + 1;
	});
};


/* 
 * 
 */
function mmpm_dependency( parent_name, values, childrens_id ){
	jQuery(document).ready(function(){
		mmpm_dependency_changer( parent_name, values, childrens_id );
	});
	jQuery( parent_name ).change(function(){
		mmpm_dependency_changer( parent_name, values, childrens_id );
	});
	jQuery( parent_name ).keyup(function(){
		mmpm_dependency_changer( parent_name, values, childrens_id );
	});
};

/* 
 * 
 */
function mmpm_dependency_changer( parent_name, values, childrens_id ){
	parent_value = jQuery( parent_name ).val();

	flag = 'hidden';
	if ( jQuery.isArray( values ) ) {
		jQuery.each( values, function() {
			if ( this == parent_value ) {
				flag = 'displayed';
			} 
		});
	} else {
		if ( values == parent_value || ( values == 'not_empty' && parent_value != '' ) ) {
			flag = 'displayed';
		} 
	}
	if ( flag == 'displayed' ) {
		if ( jQuery.isArray( childrens_id ) ) {
			jQuery.each( childrens_id, function(){
				jQuery( 'div#'+this ).removeClass( 'hidden_important' );
			});
		} else {
			jQuery( 'div#'+childrens_id ).removeClass( 'hidden_important' );
		}
	} else {
		if ( jQuery.isArray( childrens_id ) ) {
			jQuery.each( childrens_id, function(){
				jQuery( 'div#'+this ).addClass( 'hidden_important' );
			});
		} else {
			jQuery( 'div#'+childrens_id ).addClass( 'hidden_important' );
		}
	}
};

/* 
 * 
 */
function mmpm_icon_selector( input_name, modal_id ) {
	checked_icon = jQuery( '#' + modal_id + ' .all_icons_container input:checked' ).val(); 
	jQuery( 'i[data-icon="' + modal_id + '"]' ).removeClass(); 
	jQuery( 'i[data-icon="' + modal_id + '"]' ).addClass( checked_icon ); 
	jQuery( 'input[data-icon="' + modal_id + '"]' ).val( checked_icon ); 
	jQuery( '#' + modal_id ).modal('hide'); 
};

/* 
 * 
 */
function mmpm_file_upload( input_name, option_id ) {
	jQuery(document).ready(function() {
		jQuery( '.select_file_button.' + option_id ).click(function() {
			rsUploadID = jQuery( 'input[name="' + input_name + '"]' );
			rsPrewImage = jQuery( 'img[data-imgprev="' + option_id + '"]' );
			tb_show("Select file", "media-upload.php?type=image&amp;TB_iframe=true");
			return false;
		});
		window.send_to_editor = function(html) {
			imgurl = jQuery("img",html).attr("src");
			rsUploadID.val(imgurl);
			rsPrewImage.attr({src: imgurl});
			tb_remove();
		};
	});
};

/* 
 * 
 */
function mmpm_gradient_example( option_id ) {
	jQuery( '.' + option_id + '  .gradient_example' ).click(function(){
		color1 = jQuery( '.' + option_id + ' input[name*="[color1]"]' ).val();
		color2 = jQuery( '.' + option_id + ' input[name*="[color2]"]' ).val();
		start = jQuery( '.' + option_id + ' input[name*="[start]"]' ).val();
		end = jQuery( '.' + option_id + ' input[name*="[end]"]' ).val();
		orientation = jQuery( '.' + option_id + ' *[name*="[orientation]"]' ).val();
		if ( orientation == 'radial' ) {
			orient1 = 'radial-gradient(center, ellipse cover';
			orient2 = 'radial, center center, 0px, center center, 100%';
			orient3 = 'radial-gradient(ellipse at center';
		} else if ( orientation == 'left' ) {
			orient1 = 'linear-gradient(left';
			orient2 = 'linear, left top, right top';
			orient3 = 'linear-gradient(to right';
		} else {
			orient1 = 'linear-gradient(top';
			orient2 = 'linear, left top, left bottom';
			orient3 = 'linear-gradient(to bottom';
		}
		gradient = 'background-color: ' + color1 + ';';
		gradient += 'background: -moz-' + orient1 + ',  ' + color1 + ' ' + start + '%, ' + color2 + ' ' + end + '%);';
		gradient += 'background: -webkit-' + orient1 + ',  ' + color1 + ' ' + start + '%,' + color2 + ' ' + end + '%);';
		gradient += 'background: -o-' + orient1 + ',  ' + color1 + ' ' + start + '%,' + color2 + ' ' + end + '%);';
		gradient += 'background: -ms-' + orient1 + ',  ' + color1 + ' ' + start + '%,' + color2 + ' ' + end + '%);';
		gradient += 'background: -webkit-gradient(' + orient2 + ', color-stop(' + start + '%,' + color1 + '), color-stop(' + end + '%,' + color2 + '));';
		gradient += 'background: ' + orient3 + ',  ' + color1 + ' ' + start + '%,' + color2 + ' ' + end + '%);';
		gradient += 'filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="' + color1 + '", endColorstr="' + color2 + '",GradientType=0 );';
		jQuery( '.' + option_id + ' .gradient_example' ).attr( 'style', gradient );
	});
};
