<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
    <?php $search_query = get_search_query();?>
    <div class="content clearfix">
    	<div class="panelLeft">
            <section class="title">
            	<h1 style="font-size:25px; line-height: 35px;"><?php printf( __( 'Search Results for: "%s"', 'imbibe' ), '<span>' . $search_query . '</span>' ); ?></h1>
            </section>
            <?php
                $post_per_page = 20;
                $order = isset($_GET['order']) ? $_GET['order'] : 'newest';
                $all_post_type = array('recipe','article','post','event','promotion','issue');
                $result_count  = array();
                $all_section_count = 0;
                foreach( $all_post_type as $post_type){
                    $wp_query   = new WP_Query();
                    $args = array(
                        'post_type'   => $post_type,
                        'post_status' => 'publish',
                        'paged'       => $paged,
                        'posts_per_page'   => $post_per_page,
                        's' => $search_query
                    );
                    $wp_query->query($args);
                    if($wp_query->found_posts > 0){
                        $result_count[$post_type] = $wp_query->found_posts;
                        $all_section_count+= $wp_query->found_posts;
                    }
                    wp_reset_query();
                }
                
                $paged                = isset($_GET['page-num']) ? $_GET['page-num'] : 1;                
                $txt_search_post_type = get_query_var('post_type');
                $post_type            = $txt_search_post_type;
                if($post_type == 'any'){
                    $s_post_type = $all_post_type;
                    $post_type   = '';
                }else{
                    $s_post_type = $post_type;
                }
                
                $wp_query   = new WP_Query();
                switch($order){
                    case 'oldest':
                        $args = array(
                                'post_type'   => $s_post_type,
                                'post_status' => 'publish',
                                'paged'       => $paged,
                                'posts_per_page'   => $post_per_page,
                                's' => $search_query,
                                'order' => 'ASC',
                                'orderby' => 'date'
                            );
                        break;
                    case 'alpha':
                        $args = array(
                                'post_type'   => $s_post_type,
                                'post_status' => 'publish',
                                'paged'       => $paged,
                                'posts_per_page'   => $post_per_page,
                                's' => $search_query,
                                'order' => 'ASC',
                                'orderby' => 'title'
                            );
                        break;
                    default: // newest
                        $args = array(
                                'post_type'   => $s_post_type,
                                'post_status' => 'publish',
                                'paged'       => $paged,
                                'posts_per_page'   => $post_per_page,
                                's' => $search_query,
                                'order' => 'DESC',
                                'orderby' => 'date'
                            );
                        break;
                }
                $wp_query -> query( $args); 
            ?>            
            <style>
                .content .details .thumb img{
                    width: 220px;
                    height: auto;
                }
                .content .details h3 span.date {
                    color: #666666;
                    display: block;
                    font-family: Arial,sans-serif;
                    font-size: 12px;
                }                
                .search-excerpt{background-color: yellow;}      
                
                .search_result_count{                    
                    width: 50%;
                    float:left;
                    display: inline-block;
                }
                .search_result_count li a{
                    color: #B0282E;
                    font-weight: bold;
                }
                .search_result_count_order{
                    width: 50%;
                    float:left;
                    display: inline-block;
                }
                .search_result_count_order li{
                    text-align: right;
                }
                .search_result_count_order li span{
                    color: #B0282E;
                    font-weight: bold;                    
                }
                .section_result_count{
                    display: inline-block;
                    border-bottom: 1px solid #cccccc;
                    width: 100%;
                    padding-bottom: 10px;
                }
            </style>            
            <?php if(count($result_count)):?>
             <section class="section_result_count">
                <ul class="search_result_count">
                    <li>
                        <a href="<?php echo home_url();?>/?s=<?php echo $search_query;?>">All Sections</a> <span>(<?php echo $all_section_count;?>)</span>
                    </li>
                    <?php foreach($result_count as $post_type => $post_count):?>
                    <li>
                        <?php 
                            switch($post_type){
                                case 'post': 
                                        $url_search = home_url().'/?s='.$search_query.'&post_type='.$post_type;
                                        echo '<a href="'.$url_search.'">Blog </a> <span>('.$post_count.')</span';
                                    break;
                                default: 
                                        $url_search = home_url().'/?s='.$search_query.'&post_type='.$post_type;                                        
                                        echo '<a href="'.$url_search.'">'.ucfirst($post_type).'</a> <span>('.$post_count.')</span';
                                    break;
                            }
                        ?>
                    </li>
                    <?php endforeach;?>
                </ul>                 
                 <ul class="search_result_count_order">
                    <li>
                        <span>Ordering:</span>
                        <select name="order" onchange="window.location = '<?php echo add_query_arg(array("s"=> $search_query , "post_type" => $txt_search_post_type),home_url());?>' + '&order='+this.value;">
                            <option value="newest" <?php if($order == 'newest') echo 'selected="selected"';?>>Newest First</option>
                            <option value="oldest" <?php if($order == 'oldest') echo 'selected="selected"';?>>Oldest First</option>                            
                            <option value="alpha" <?php if($order == 'alpha') echo 'selected="selected"';?>>Alphabetical</option>
                        </select>
                    </li>
                </ul>
             </section>    
            <div class="clearfix"></div>
            <?php endif;?>
            <?php if ( $wp_query->have_posts()) : ?>            
                <?php while($wp_query->have_posts()): $wp_query->the_post(); ?>
                    <section style="border-bottom: 1px dotted #cccccc;">
                        <div class="details">            
                            <a href="<?php the_permalink();?>">
                                <h3 style="margin:8px 0px;">                                     
                                    <?php //echo highLight(get_the_title(),$search_query); ?>
                                    <?php echo get_the_title(); ?>
                                    <span class="date">
                                        <strong> 
                                            <?php switch(get_post_type()){
                                                    case 'post': echo 'Blog';
                                                        break;
                                                    default: 
                                                            echo ucfirst(get_post_type());
                                                        break;
                                                }
                                            ?>
                                        </strong> | <?php the_time("F d, Y");?>                                        
                                    </span>                                    
                                </h3>
                            </a>       
                            <!--
                            <?php $featured_image = custom_post_thumbnail(null,null,null,false,false,false);?>
                            <?php if($featured_image):?>
                            <div class="thumb-wrapper">                                
                                <div class="thumb">
                                    <a href="<?php the_permalink();?>">                                        
                                        <?php custom_post_thubnail_no_caption(null,220,9999);?>
                                    </a>
                                </div>
                            </div>                    
                            <?php endif;?>
                            -->
                            <?php //echo highLight(get_the_excerpt(),$search_query);?>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                <?php endwhile;?>   
            
                <?php if($wp_query->found_posts > 0): ?>                    
                    <?php if($wp_query->max_num_pages > 1):?>
                        <section>
                            <?php 
                                $base_query_params = array("s"=> $search_query , "post_type" => $txt_search_post_type , "order"=> $order);
                            ?>
                            <ul class="paging" style="margin-top:15px;">
                                <li class="first"><a href="<?php $base_query_params['page-num'] = 1; echo add_query_arg( $base_query_params);?>">&lang;&lang;</a></li>
                                <?php if($paged > 1):?>
                                    <li class="prev"><a href="<?php $base_query_params['page-num'] = $paged -1; echo add_query_arg( $base_query_params);?>">&lang;</a></li>
                                <?php endif;?>          
                                <?php
                                    $p_min  = $paged;
                                    $p_max    = $paged;									
                                    $count = 1;									
                                    while(true){
                                        if($p_min -1 >= 1){ $p_min --; $count++;}
                                        if($count >= 5) break;                                        
                                        if($p_max + 1 <= $wp_query->max_num_pages) {$p_max++; $count++;}
                                        if($count >= 5) break;
                                        if($p_min <= 1 && $p_max >= $wp_query->max_num_pages) break;
                                    }
                                ?>
                                    
                                <?php for($p = $p_min; $p <= $p_max; $p++):?>
                                    <li class="num <?php if($p == $paged) echo 'active';?>"><a href="<?php $base_query_params['page-num'] = $p; echo add_query_arg( $base_query_params);?>"><?php echo $p;?></a></li>
                                <?php endfor;?>

                                <?php if($paged < $wp_query->max_num_pages): ?>
                                    <li class="next"><a href="<?php $base_query_params['page-num'] = $paged + 1; echo add_query_arg( $base_query_params);?>">&rang;</a></li>
                                <?php endif;?>
                                <li class="last"><a href="<?php $base_query_params['page-num'] = $wp_query->max_num_pages; echo add_query_arg( $base_query_params);?>">&rang;&rang;</a></li>
                            </ul>
                        </section>              
                    <?php endif;?>
                <?php endif;?>            
            
            <?php else:?>
                <h1>No result found. Please try again!</h1>
            <?php endif;?>
            <script type="text/javascript">
                function modifyThumbnail(){
                    jQuery(".thumb-wrapper").each(function(){
                       width = jQuery(this).find("img").width();
                       if(width > 307)
                           jQuery(this).find(".thumb").addClass("thumbCenter").removeClass("thumb");
                    });
                }
                jQuery(document).ready(function(){
                    interv = window.setInterval("modifyThumbnail();",1000);
                });
            </script>              
            
        </div>
        <div class="panelRight">
            <?php get_sidebar();?>            
        </div>        
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>