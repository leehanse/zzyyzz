<?php
  add_shortcode('editor_pick', 'sc_editor_pick');
    function sc_editor_pick($atts){
        $slide_index = rand(1,1000);
        $slide_index = md5($slide_index);                
        $query = new WP_Query();
        $args  = array(
                    'post_type'   => array("editor_pick"),
                    'post_status' => 'publish',
                    'paged'       => 1,
                    'posts_per_page' => 1
                );
        $query -> query( $args);
        $arr_objects = array();
        $editor_pick_id = null;
        if( $query->have_posts() ){
             while( $query->have_posts() ){
                 $query->the_post();
                 $editor_pick_id = get_the_ID();
             }
        }        
        if($editor_pick_id){
            if(get_field('object_id',$editor_pick_id)){
                $arr_objects = get_field('object_id');
            }
        }
        ?>
        <?php if( count($arr_objects) ): ?>
	<style>
            .thumbImg{
                background-position: center center;
                background-repeat: no-repeat;
                background-size: cover;
                cursor: pointer;
                display: inline-block;
                height: 188px;
                width: 131px;
                border: 1px solid #cccccc;
                background-repeat: no-repeat;
            }
        </style>
        <section class="widget">
            <h1>Editor Picks</h1>
            <section id="SwiperSlice-<?php echo $slide_index;?>" class="sliderThumb">
                <a class="arrow-left" href="#"></a> 
                <a class="arrow-right" href="#"></a>
                    <div class="swiper-container thumbs-container">
                        <div class="swiper-wrapper">
                            <?php foreach($arr_objects as $object):?>
				    <div class="swiper-slide">
<div onclick="window.location=$(this).attr('data-url');" class="thumbImg" data-url="<?php echo get_permalink($object->ID);?>" style="background-image:url(<?php echo custom_post_thumbnail_img($object->ID);?>)"></div>
                                        <a href="<?php echo get_permalink($object->ID);?>"><h4><?php echo get_the_title($object->ID);?></h4></a>
                                    </div>
                            <?php endforeach;?>
                        </div>
                    </div>
            </section>
        </section> 
        <script type="text/javascript">
            $(document).ready(function(){
                var myswipe_<?php echo $slide_index;?> = new Swiper('#SwiperSlice-<?php echo $slide_index;?> .thumbs-container',{
                        slidesPerView:'auto',
                        offsetPxBefore:0,
                        offsetPxAfter:0,
                        calculateHeight: true
                });
                
                $('#SwiperSlice-<?php echo $slide_index;?> .arrow-left').on('click', function(e){
                        e.preventDefault()
                        myswipe_<?php echo $slide_index;?>.swipePrev()
                })
                $('#SwiperSlice-<?php echo $slide_index;?> .arrow-right').on('click', function(e){
                        e.preventDefault()
                        myswipe_<?php echo $slide_index;?>.swipeNext()
                })
                
            });
        </script>    
        <?php endif;?>
<?php    } ?>
