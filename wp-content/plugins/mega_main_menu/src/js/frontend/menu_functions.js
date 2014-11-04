/* 
 * Function for Mega Main Menu.
 */
jQuery(document).ready(function(){

	/* 
	 * Mobile toggle menu
	 */
	jQuery( '.mobile_toggle' ).click(function() {
		jQuery( this ).parent().toggleClass( 'mobile_menu_active' );
	});



	/* 
	 * Mobile Double tap to go
	 */
;(function( $, window, document, undefined )
{
	$.fn.doubleTapToGo = function( params )
	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
		) { return false; }
/*
			!navigator.userAgent.toLowerCase().match( /windows os 7/i ) 
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
/////////
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;
*/

		this.each( function()
		{
			var curItem = false;

			$( this ).on( 'click', function( e )
			{
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] )
				{
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e )
			{
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};
})( jQuery, window, document );
jQuery( '#mega_main_menu li:has(ul)' ).doubleTapToGo();


	/* 
	 * Sticky menu
	 */
	jQuery(window).on('scroll', function(){
		menu_holder = jQuery( '#mega_main_menu > .menu_holder' );
		menu_inner = menu_holder.find( '.menu_inner' );
		if ( menu_holder.attr( 'data-sticky' ) == '1' ) {
			stickyoffset = menu_holder.data( 'stickyoffset' ) * 1;
			scrollpath = jQuery(window).scrollTop();
			if ( scrollpath > stickyoffset ) {
				if ( !menu_holder.hasClass( 'sticky_container' ) ) {
					menu_inner_width = menu_inner.width();
					menu_inner.attr( 'style' , 'width:' + menu_inner_width + 'px;' );
					menu_holder.addClass( 'sticky_container' );
				}
			} else {
				menu_holder.removeClass( 'sticky_container' );
				style_attr = jQuery( menu_inner ).attr( 'style' );
				if ( typeof style_attr !== 'undefined' && style_attr !== false ) {
					menu_inner.removeAttr( 'style' );
				}
			}
		} else {
			menu_holder.removeClass( 'sticky_container' );
		}
	});

});
