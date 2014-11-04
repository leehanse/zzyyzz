 /*
 * Plugin Name: WP Mega Menu
 * Plugin URI: http://mythemeshop.com/
 * Description: WP MegaMenu is an easy to use plugin for creating beautiful, customized menus for your blog that show categories, subcategories and posts.
 * Author: MyThemeShop
 * Author URI: http://mythemeshop.com/
*/
jQuery(document).ready(function($) {
    // set up elements for mega menu
    if ($('.menu-item-' + wpmm.css_class + '-megamenu').length) {
        var $megamenus = [];
        var mmtimers = {};
        var clearTimers = function() {
            $.each(mmtimers, function(i, v) {
                clearTimeout(mmtimers[i]);
            });
            clearTimeout(mytimer);
        };
        var hide_megamenus = function(args) {
            var options = $.extend({except: ''}, args);
            $.each($megamenus, function(i, $this) {
                if (options.except === '' || !$this.is(options.except)) {
                    $this /*.hide()*/.removeClass(wpmm.css_class + '-visible').addClass(wpmm.css_class + '-hidden');
                }
            });
            $('.' + wpmm.css_class + '-megamenu-showing').removeClass(wpmm.css_class + '-megamenu-showing');
        };
        var load_megamenu = function($elem, type, customdata) {
            var data = $elem.data();
            var custom = customdata || {};
            data = $.extend(data, custom);
            
            data['action'] = 'get_megamenu';
            data['type'] = type;
            $elem.addClass(wpmm.css_class + '-loading');
            
            $elem.load(wpmm.ajaxurl, data, function() {
                $elem.removeClass(wpmm.css_class + '-loading');
            });
        };
        var preload_delay = 500;
        $('.menu-item-' + wpmm.css_class + '-taxonomy').each(function() {
            var $this_li = $(this);
            if ($this_li.closest('.widget_nav_menu').length)
                return true; // don't add megamenu in Custom Menu widgets
            
            var $a = $this_li.find('a').first();
            
            var $menu;
            if (wpmm.container_selector && $this_li.closest(wpmm.container_selector).length) {
                $menu = $a.closest(wpmm.container_selector);
            } else {
                $menu = $this_li.parent();
                $menu.css({position: 'relative',zIndex: '1000',perspective: '1500px'});
            }
            
            var el_id = 'menu-item-' + $a.data('menu_item') + '-megamenu';
            
            var $megamenu = $('<div id="wpmm-megamenu" class="' + $a.data('colorscheme') + ' ' + wpmm.css_class + '-megamenu-container ' + el_id + ' ' + wpmm.css_class + '-hidden"></div>')
            .appendTo($menu).data($a.data());
            $megamenus.push($megamenu);
            
            $a.hover(function(e) {
                clearTimers();
                hide_megamenus({except: '.' + el_id});
                //$megamenu.show();
                $megamenu.removeClass(wpmm.css_class + '-hidden').addClass(wpmm.css_class + '-visible');
                if (!$megamenu.data('isloaded')) {
                    //load_megamenu($megamenu, 'taxonomy', {'object_id': $a.data('object_id'), 'new_object_id': 0, 'page': 1});
                    $megamenu.empty();
                    $('.' + wpmm.css_class + '-preload-megamenu-' + $a.data('menu_item')).children().clone(true).appendTo($megamenu).find('img').each(function() {
                        $(this).attr('src', $(this).data('src'));
                    });
                    $megamenu.data('isloaded', true);
                }
                
                $('.' + wpmm.css_class + '-megamenu-showing').removeClass(wpmm.css_class + '-megamenu-showing');
                $(this).parent().addClass(wpmm.css_class + '-megamenu-showing');
            }, function(e) {
                var $this = $(this);
                mmtimers[$a.data('menu_item')] = setTimeout(function() {
                    $megamenu /*.hide()*/.removeClass(wpmm.css_class + '-visible').addClass(wpmm.css_class + '-hidden');
                    $this.parent().removeClass(wpmm.css_class + '-megamenu-showing');
                }, 400);
            });

        // autoload
        //			jQuery(window).load(function() {
        //				setTimeout(function() {
        //					load_megamenu($megamenu, 'taxonomy', {'object_id': $a.data('object_id'), 'new_object_id': 0, 'page': 1}, true);
        //					$megamenu.data('isloaded', true);
        //				}, preload_delay);
        //				preload_delay += 250;
        //			});
        
        });
        var mytimer;

        // sub taxonomies
        $('body').on({mouseenter: function(e) {
                var $this = $(this);
                var $megamenu = $this.closest('.' + wpmm.css_class + '-megamenu-container');
                var new_object_id = $this.data('new_object_id');
                if (!$this.hasClass(wpmm.css_class + '-current-subcategory')) {
                    mytimer = setTimeout(function() {
                        load_megamenu($megamenu, 'taxonomy', {'new_object_id': new_object_id,'page': 1});
                        $megamenu.data('isloaded', false);
                        $this.addClass(wpmm.css_class + '-current-subcategory').siblings().removeClass(wpmm.css_class + '-current-subcategory');
                    }, 1000);
                }
            },mouseleave: function(e) {
                clearTimeout(mytimer);
            }}, '.' + wpmm.css_class + '-subcategory');
        
        $('body').on('click', '.' + wpmm.css_class + '-pagination a', function(e) {
            e.preventDefault();
            var $this = $(this);
            var page = $this.data('page');
            var $megamenu = $this.closest('.' + wpmm.css_class + '-megamenu-container');
            var obj_id;
            var posts_per_page;
            if ($megamenu.find('.' + wpmm.css_class + '-current-subcategory').length) {
                obj_id = $megamenu.find('.' + wpmm.css_class + '-current-subcategory').data('new_object_id');
            } else {
                obj_id = $megamenu.data('object_id');
            }
            if ($megamenu.find('.' + wpmm.css_class + '-subcategories').length && $megamenu.data('show') == 'both') {
                posts_per_page = 3;
            } else {
                posts_per_page = 4;
            }
            $(this).closest('#wpmm-megamenu').addClass(wpmm.css_class + '-loading');
            load_megamenu($megamenu, 'taxonomy', {'page': page,'new_object_id': obj_id,'posts_per_page': posts_per_page});
        });
        
        $.each($megamenus, function(i, $this) {
            $this.hover(function(e) {
                clearTimers();
            }, function(e) {
                mytimer = setTimeout(function() {
                    $this /*.hide()*/.removeClass(wpmm.css_class + '-visible').addClass(wpmm.css_class + '-hidden');
                    $('.' + wpmm.css_class + '-megamenu-showing').removeClass(wpmm.css_class + '-megamenu-showing');
                }, 400); // time to hover out and back
            });
        });
        
        $('.menu-item-has-children').mouseenter(function(event) {
            hide_megamenus();
        });
    }
});