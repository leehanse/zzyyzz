<?php
  add_shortcode('back_issues', 'sc_back_issues');
    function sc_back_issues($atts){ ?>
        <?php 
            $arr_year_exists = array();
            $archive_issues  = array();
            $year = date('Y');
            $list_issues = array();
            for($y = $year; $y >= 2005; $y--){
                if(!isset($list_issues[$y])) $list_issues[$y] = array();
                $url_servies = 'http://demo:demo@54.200.52.131/shop/index.php?route=product/category/ajaxLoadProducts&name='.$y;                
                $response = file_get_contents($url_servies);
                if($response){
                    $response = json_decode($response);                    
                    if($response->success){
                        $data = (array)$response->data;
                        $list_issues[$y]['data'] = $data;
                    }
                }else break;
            }
            /*
            $query = new WP_Query('post_type=issue');    
            while( $query->have_posts() ){
                $query->the_post();
                $thumbnail = get_the_post_thumbnail(array(133,9999));
                $title     = get_the_title();
                $excerpt   = strip_tags(get_the_excerpt());
                $excerpt   = wp_trim_words($excerpt,10);
                $permalink = get_permalink();
                $year_archive = get_field('year_archive',get_the_ID());
                $month_archive = get_field('month_archive',get_the_ID());
                
                if(!in_array($year_archive, $arr_year_exists)) $arr_year_exists[] = $year_archive;
                
                if(!isset($archive_issues[$year_archive])) $archive_issues[$year_archive] = array();
                $archive_issues[$year_archive][$month_archive] = array(
                    "title"             => $title,
                    "thumbnail"         => $thumbnail,
                    "excerpt"           => $excerpt,
                    "permalink"         => $permalink                   
                );
            }
            arsort($arr_year_exists); 
             */
        ?>
        <?php if(count($list_issues)):?>
            <?php foreach($list_issues as $year_archive => $_data):?>
                <?php $data = $_data['data'];?>
                <?php if(count($data)):?>
                <section class="widget">
                    <h1><?php echo $year_archive;?></h1>
                    <section id="SwiperSlice-<?php echo $year_archive;?>" class="sliderThumb">
                        <a class="arrow-left" href="#"></a> 
                        <a class="arrow-right" href="#"></a>
                        <div class="swiper-container thumbs-container">
                            <div class="swiper-wrapper">                    
                                <?php foreach($data as $product_id => $product): ?>
                                    <div class="swiper-slide">
                                        <?php 
                                            $product_link = home_url().'/shop/index.php?route=product/product&amp;product_id='.$product_id;
                                            $product_image = 'http://54.200.52.131/shop/image/'.$product->image;
                                        ?>
                                        <a href="<?php echo $product_link;?>"> 
                                            <img src="<?php echo $product_image;?>">
                                        </a>
                                        <a href="<?php echo $product_link;?>"> <h4><?php echo $product->name;?></h4></a>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </section>
                </section>  
                <script type="text/javascript">                
                    $(function(){
                            var myswipe_<?php echo $year_archive;?> = new Swiper('#SwiperSlice-<?php echo $year_archive;?> .thumbs-container',{
                                    slidesPerView:'auto',
                                    offsetPxBefore:0,
                                    offsetPxAfter:0,
                                    calculateHeight: true
                            });
                            
                            $('#SwiperSlice-<?php echo $year_archive;?> .arrow-left').on('click', function(e){
                                    e.preventDefault()
                                    myswipe_<?php echo $year_archive;?>.swipePrev()
                            });
                            
                            $('#SwiperSlice-<?php echo $year_archive;?> .arrow-right').on('click', function(e){
                                    e.preventDefault()
                                    myswipe_<?php echo $year_archive;?>.swipeNext()
                            });
                    });    
                </script>    
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
<?php    } ?>