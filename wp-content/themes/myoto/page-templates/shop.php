<?php
/**
 * Template Name: Shop Template
 */
?>
<?php get_header();?>
	
    <div class="content clearfix">
    	<div class="panelCenter">
        <section class="title" style="position: relative;">
            <h1>Shop Imbibe</h1>
            <?php 
                $shop_page = get_page_by_title('Shop');
                $shop_page_id = null;
                if($shop_page) $shop_page_id = $shop_page->ID;                
                $cstools = array();
                if($shop_page_id){
                    if(get_field('cstools',$shop_page_id)){
                        while(has_sub_field('cstools',$shop_page_id)){
                            $cstools[] = array(
                                "link"   => get_sub_field("cstool_link",$shop_page_id),
                                "title"  => get_sub_field("cstool_title",$shop_page_id)
                            );
                        }
                    }
                }
            ?>
            <?php if(count($cstools)):?>
            <ul class="subBar">                    
                <?php foreach($cstools as $key => $cstool):?>
                    <li><a href="<?php echo $cstool['link'];?>"><?php echo $cstool['title'];?></a><?php if($key < count($cstools)-1):?>|<?php endif;?></li>
                <?php endforeach;?>
            </ul>
            <?php endif;?>            
        </section>            
            <section class="widget" style="background: none; margin-bottom: 0px;">
                <article class="blockShop">
                <h1>Imbibe Magazine Subscription</h1>               
                <form action="<?php echo add_query_arg(array("SourceCode"=>"shop"),  get_permalink(get_page_by_title('Subscribe')->ID));?>" method="post" id="landing-shop-form">
                    <input type="hidden" name="from" value="mini-form"/>
                    <ul class="subMagazine">
                            <li>
                            <h3>Print</h3>
                            <div class="thumb"><img src="<?php echo get_template_directory_uri();?>/images/thumb/img-25.png"></div>
                            <p>
                                    <label>
                                        <input type="radio" name="SubType" value="1-year print subscription">
                                        1 YR = $20</label>
                                    <br>
                                    <label>
                                        <input type="radio" name="SubType" value="2-years print subscription">
                                        2 YR = $32</label>
                                    <br>
                            </p>
                        </li>
                        <li>
                            <h3>Digital</h3>
                            <div class="thumb"><img src="<?php echo get_template_directory_uri();?>/images/thumb/img-26.png"></div>
                            <p>
                                    <label>
                                        <input type="radio" name="SubType" value="1-year digital subscription">
                                        1 YR = $20</label>
                            </p>
                            <p class="colorRed">
                                <a href="<?php echo add_query_arg(array(),  get_permalink(get_page_by_title('Upgrade Print To Digital Subscription')->ID));?>">
                                    Already a print subscriber? Click here and get the digital edition for just $5 »
                                </a>
                            </p>
                        </li>
                        <li>
                            <h3>Print + Digital</h3>
                            <div class="thumb"><img src="<?php echo get_template_directory_uri();?>/images/thumb/img-27.png"></div>
                            <p>
                                    <label>
                                        <input type="radio" name="SubType" value="1-year print and digital subscription">
                                        1 YR = $25</label>
                            </p>
                        </li>
                    </ul>
                </form>
                <p>*Add $20/year for all print subscriptions mailed outside the United States.</p>
                </article>
            </section>
            <section class="buttonFull">
            	<ul>
                    <li class="btnRed">
                        <a href="javascript:void(0);" onclick="$('#landing-shop-form').submit();">subscribe</a>
                    </li>
                    <li class="btnGray"><a href="<?php echo get_permalink(get_page_by_title("Gift")->ID);?>"><img src="<?php echo get_template_directory_uri();?>/images/icoGiftOrder.png"><span>Click here for gift orders</span></a></li>
                </ul>
            </section>
            <?php if(get_field('bottom_box')):?>
                <section class="widget1">
                    <article class="blockShop">
                    <h1>More from Imbibe</h1>
                    <ul class="subMoreFrom">
                        <?php while(has_sub_field('bottom_box')):?>
                            <?php
                                $image = get_sub_field('image');
                                $link  = get_sub_field("link");
                                $link_title = get_sub_field('link_title');
                                $short_description = get_sub_field('short_description');
                            ?>
                            <li>
                                <div class="thumb"><img src="<?php echo $image;?>"></div>
                                <a href="<?php echo $link; ?>" class="titleMore"><?php echo $link_title;?></a>
                                <?php echo $short_description;?>
                            </li>
                        <?php endwhile;?>
                    </ul>    
                    <a href="<?php echo home_url();?>/shop" class="viewAll">View all »</a>
                </section>
            <?php endif;?>

        </div>
        <div class="clearfix"></div>
    </div>    
<?php get_footer();?>