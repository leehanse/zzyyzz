<?php
/*
Plugin Name: WooCommerce Paginate Variations
Plugin URI: http://danielberges.es/woocommerce-paginate-variations
Description: If you have many variations, with this plugin you can prevent the product page will load slow. This plugin inserts a pagination for variations, thus only load 30 variations on each page.
Version: 1.1.0
Author: Daniel Berges
Author URI: http://danielberges.es
License: GPLv2 or later
License URI: http://opensource.org/licenses/GPL-2.0
*/


/**
 * Crear función para limitar el número de resultados.
 * Se ejecuta antes de la petición "query" de todas las variaciones
 * @param $query
 * @return mixed
 */
function variations_paginate( $query ) {
    global $post;

    $PostxPage=30;

    //Comprueba si está en el panel de administración
    if (!is_admin())
        return $query;

    //Comprueba si es una consulta desde esta misma función para evitar un bucle infinito
    if($query->get( 'variations_paginate' ))
        return $query;

    //comprueba que estamos en la edición del producto.
    if($query->get('post_type')!="product_variation" || $_GET['action']!="edit")
        return $query;    
        
    $filter_attributes = array();
    
    $html_filter = '';
    $product= new WC_Product($post->ID);
    $attributes = $product->get_attributes();
    if(count($attributes)){
        foreach($attributes as $attribute){
            $post_terms  = wp_get_post_terms( $post->ID, $attribute['name'] );
            $first_value = reset($post_terms);
            $input_name_filter = 'filter_variation_'.sanitize_title( $attribute['name'] );
            
            if(!isset($_GET[$input_name_filter])){
                $filter_attributes[sanitize_title($attribute['name'])] = $first_value->term_id;
            }else{
                $filter_attributes[sanitize_title($attribute['name'])] = $_GET[$input_name_filter];
            }
            
            $html_filter.= '<select name="filter_variation_' . sanitize_title( $attribute['name'] ).'">';
            $html_filter.= '<option value="">' . __( 'Any', 'woocommerce' ) . ' ' . esc_html( wc_attribute_label( $attribute['name'] ) ) . '&hellip;</option>';            
            foreach ( $post_terms as $term ) {
                $html_filter.= '<option value="' . $term->term_id . '">' . apply_filters( 'woocommerce_variation_option_name', esc_html( $term->name ) ) . '</option>';
            }
            $html_filter.= '</select>';
        }
        
    }

    $query->set( 'posts_per_page', 10);
    $query->set( 'paged',1);
    //attribute_pa_paper-size
//    array_pop($filter_attributes);
//    print_r($filter_attributes);
//    print_r($html_filter);
//    echo '<hr/>';
//    die;
    return $query;
    
    //comprobamos si veníamos de guardar un producto para mantener la misma página de variaciones
    if(empty($_GET["varpage"]) && preg_match("/varpage=(.*)/is",$_SERVER["HTTP_REFERER"],$content)){
        $_GET["varpage"]=$content[1];
    }

    $post_parent=$_GET["post"];

    $link=get_edit_post_link($post->ID);

    $page=(int)((!empty($_GET["varpage"]))?$_GET["varpage"]:1);
    $orderby="";

    $prevPag=$link."&varpage=".($page-1);
    $nextPag=$link."&varpage=".($page+1);



    $query->set( 'numberposts', $PostxPage );

    $next_prev_orderby="";

    if(count($attributes)!=0){
        reset($attributes);
        $default=key($attributes);
        $orderby=((!empty($_GET["orderby"]))?$_GET["orderby"]:$default);
        $next_prev_orderby="&orderby=".$orderby;
        $query->set( 'meta_key', $orderby );
        $query->set( 'orderby', "meta_value" );
    } else {
        $query->set( 'order_by', "post_date" );
    }



    $query->set( 'posts_per_page', $PostxPage );
    $query->set( 'paged',$page );

    //recuperamos el número total de variaciones para calcular el número total de páginas
    $args=array(
        'variations_paginate'=>true,
        'posts_per_page'   => -1,
        'numberposts'   => -1,
        "offset" => 0,
        "post_type" => "product_variation",
        "post_status" => array("private","publish"),
        "post_parent" => $post_parent
    );

    $results = get_posts($args);
    $total= count($results)/$PostxPage;
    $total= ceil($total);

    unset($result);

    $options="";

    for($i=1;$i<=$total;$i++){
        $options.='<option value="'.$i.'" '.(($i==$page)?'selected':'').'>'.$i.'</option>'.'\n';
    }

    $options_order="";

    foreach($attributes as $key => $value){
        $options_order.='<option value="'.$key.'" '.(($key==$orderby)?'selected':'').'> '.$value.'</option>'.'\n';
    }

    $select='
        <div class="DivSelector" style="display:none">
            <div style="float:right">
                <div>
                    <button class="button BtnPaginacion">'.__('Go to the page of variations indicated:','woocommerce-paginate-variations').'</button>
                    <select class="SlcPaginacion" name="SlcPaginacion" id="SlcPaginacion">
                        '.$options.'
                    </select>
                </div>
                <div>
                    <button class="button BtnOrden">'.__('Order by:','woocommerce-paginate-variations').'</button>
                    <select class="SlcOrden" name="SlcOrden" id="SlcOrden">
                        '.$options_order.'
                    </select>
                </div>
            </div>
        </div>
    ';

    $autoActivateTab='
            var panel_wrap =  jQuery("a[href=#variable_product_options]").closest("div.panel-wrap");
            jQuery("ul.wc-tabs li", panel_wrap).removeClass("active");
            jQuery("a[href=#variable_product_options]").parent().addClass("active");
            jQuery("div.panel", panel_wrap).hide();
            jQuery("#variable_product_options").show();

            jQuery("input[name=_wp_http_referer]").val(jQuery("input[name=_wp_http_referer]").val()+"&varpage='.$page.'");
    ';

    // Genero los enlaces con funciones para detectar el inicio y el final de la paginación.
    // Las 3 barras \\\ son para escapar esto \" y prepararlo para javascript

    $prev_link=($page-1<1)?'':"<a href=\\\"".$prevPag.$next_prev_orderby."\\\"> < ".__('Previous','woocommerce-paginate-variations')."</a> ... ";
    $next_link=($page+1>$total)?'':" ... <a href=\\\"".$nextPag.$next_prev_orderby."\\\">".__('Next','woocommerce-paginate-variations')." ></a>";
    
    echo '
    '.$select.'
    <script type="text/javascript">
        jQuery( document ).ready(function() {
            '.((!empty($_GET["varpage"]))?$autoActivateTab:'').'
            jQuery( "#variable_product_options_inner .toolbar" ).before( "<div style=\"padding:15px;line-height:25px;background:#DBF1FF;\">'.__('Pagination of variations','woocommerce-paginate-variations').': '.$prev_link.'['.$page.__(' of ','woocommerce-paginate-variations').$total.']'.$next_link.'"+jQuery(".DivSelector").html()+"<p>'.__('<b>¡Important!</b> Edit massively only work for changes items in the current page ','woocommerce-paginate-variations').'</p></div>" );

            jQuery( ".BtnPaginacion, .BtnOrden" ).click(function(){
                window.location = "'. htmlspecialchars_decode($link).'&varpage="+jQuery("#SlcPaginacion").val()+"&orderby="+jQuery("#SlcOrden").val();
                return false;
            });

        });

    </script>
    ';

    return $query;
}

add_action( 'pre_get_posts', 'variations_paginate' );


function prepare_attributes($postID){

    $product= new WC_Product($postID);

    $attributes_return=array();

    $attributes = $product->get_attributes();

    if(count($attributes)!=0){
        foreach($attributes as $key => $value){
            $attributes_return['attribute_'.$key]=$value["name"];
        }
    }

    return $attributes_return;
}

load_plugin_textdomain('woocommerce-paginate-variations', '', basename(dirname(__FILE__)));
load_plugin_textdomain('woocommerce-paginate-variations', '', dirname(plugin_basename(__FILE__)) . '/languages');
