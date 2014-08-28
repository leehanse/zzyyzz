<?php
/**
 * Template Name: In The Magazine
 */
?>
<?php
    $page_id = get_the_ID();
    // new current issues
    $arr_year_exists = array();
    $archive_issues  = array();

    $query = new WP_Query('post_type=issue&paged=1&posts_per_page=999999999');
    while( $query->have_posts() ){
        $query->the_post();
        $year_archive  = get_field('year_archive',get_the_ID());
        $month_archive = get_field('month_archive',get_the_ID());
        $id            = get_the_ID();
        if(!in_array($year_archive, $arr_year_exists)) $arr_year_exists[] = $year_archive;

        if(!isset($archive_issues[$year_archive])) $archive_issues[$year_archive] = array();
        
        $archive_issues[$year_archive][$month_archive] = $id;
    }
    arsort($arr_year_exists);    
    $max_year      = reset($arr_year_exists);
    $arr_key_month = array_keys($archive_issues[$max_year]);
    arsort($arr_key_month);    
    $max_month     = reset($arr_key_month);
    
    $current_issue_id = $archive_issues[$max_year][$max_month];    
?>
<?php get_header();?>
    <div class="content clearfix">
        <input type="hidden" id="PAGE" value="Current-Issue"/>
    	<div class="panelLeft">
            <section class="title" style="background: none;">
                <h1 style="margin-bottom:0px;padding-bottom:0px;">In The Magazine</h1>
                <h2>On Newsstands Now</h2>
                <p>                        
                    Our latest issue is <a href="<?php echo get_permalink(get_page_by_title('Where To Buy')->ID);?>">available in stores</a> nationally. You can also read from our full set of back issues and order any issues you need to complete your Imbibe library.
                </p>
            </section>
            <section class="currentIssue">
                <div class="left">
                    <div class="thumb">
                        <?php echo get_the_post_thumbnail($current_issue_id,array(300,9999));?>
                    </div>

                    <ul class="list">
                        <h3>Web Extras</h3>
                        <?php while(has_sub_field('web_extras_link',$current_issue_id)): ?>
                                <li>
                                <?php if(get_sub_field("external_url",$current_issue_id)):?>
                                        <a href="<?php echo get_sub_field("external_url",$current_issue_id)?>">
                                            <?php echo get_sub_field("external_title",$current_issue_id)?>
                                        </a>                                    
                                <?php endif;?>                       
                                </li>
                        <?php endwhile;?>                         
                    </ul>                        
                </div>

                <div class="right">
                    <div class="issueNo">
                        <?php the_title();?>
                        <!-- <br> <span class="">The Texas Issue</span> -->
                    </div>
                    <ul class="list">                            
                        <h3>Features</h3>
                        <?php while(has_sub_field("features_link",$current_issue_id)): ?>
                                <?php 
                                $internal_feature_link  = get_sub_field("internal_feature_link",$current_issue_id);
                                $external_feature_link  = "";
                                $external_feature_title = "";
                                // repeater has only 1 row
                                while(has_sub_field("external_feature_link_repeater",$current_issue_id)){
                                    $external_feature_link  = get_sub_field("external_feature_link",$current_issue_id);
                                    $external_feature_title = get_sub_field("external_feature_title",$current_issue_id);
                                }                                    
                                ?>
                            <?php if($internal_feature_link): ?> 
                                <li>
                                    <a href="<?php echo get_permalink($internal_feature_link->ID);?>"><?php echo get_the_title($internal_feature_link->ID);?></a>
                                </li>
                            <?php elseif($external_feature_link):?>
                                <li>
                                    <a href="<?php echo $external_feature_link;?>"><?php echo $external_feature_title;?></a>
                                </li>
                            <?php endif;?>
                        <?php endwhile;?>
                    </ul>

                    <ul class="list">                            
                        <h3>Departments</h3>
                        <?php while(has_sub_field("departments_link",$current_issue_id)): ?>
                                <?php 
                                $internal_department_link  = get_sub_field("internal_department_link",$current_issue_id);
                                $external_feature_link  = "";
                                $external_feature_title = "";
                                // repeater has only 1 row
                                while(has_sub_field("external_pepartment_link_repeater",$current_issue_id)){
                                    $external_department_link  = get_sub_field("external_department_link",$current_issue_id);
                                    $external_department_title = get_sub_field("external_department_title",$current_issue_id);
                                }                                    
                                ?>
                            <?php if($internal_department_link): ?> 
                                <li>
                                    <a href="<?php echo get_permalink($internal_department_link->ID);?>"><?php echo get_the_title($internal_department_link->ID);?></a>
                                </li>
                            <?php elseif($external_department_link):?>
                                <li>
                                    <a href="<?php echo $external_department_link;?>"><?php echo $external_department_title;?></a>
                                </li>
                            <?php endif;?>
                        <?php endwhile;?>
                    </ul>

                    <ul class="list">                            
                        <h3>Recipes</h3>
                        <?php while(has_sub_field("recipes_link",$current_issue_id)): ?>
                                <?php 
                                $recipe_link  = get_sub_field("recipe_link",$current_issue_id);
                                ?>
                                <li>
                                    <a href="<?php echo get_permalink($recipe_link->ID);?>"><?php echo get_the_title($recipe_link->ID);?></a>
                                </li>
                        <?php endwhile;?>
                    </ul>                                                
                </div>
                <div class="clearfix"></div>
            </section> 
            <section class="title" style="background: none;">
                <h2>POPULAR BACK ISSUES</h2>
                <p>                        
                    Thirsty for more? We have all <a href="<?php echo get_permalink(get_page_by_title('Back Issues')->ID);?>">back issues</a> in stock, in limited quantities. <a href="https://www.imbibemagazine.com/images/stories/pdfs/order_forms/backissue.pdf">Order up</a> a full set, put up your feet and enjoy!
                </p>
            </section>
            <?php
                $popular_back_issues = get_field('popular_back_issues', $page_id); 
                if(is_array($popular_back_issues) && count($popular_back_issues)):
            ?>
                    <?php foreach($popular_back_issues as $back_issue): $back_issue_id = $back_issue->ID;?>
                            <section class="currentIssue">
                                <div class="left">
                                    <div class="thumb">
                                        <?php echo get_the_post_thumbnail($back_issue_id,array(300,9999));?>
                                    </div>

                                    <ul class="list">
                                        <h3>Web Extras</h3>
                                        <?php while(has_sub_field('web_extras_link',$back_issue_id)): ?>
                                                <li>
                                                <?php if(get_sub_field("external_url",$back_issue_id)):?>
                                                        <a href="<?php echo get_sub_field("external_url",$back_issue_id)?>">
                                                            <?php echo get_sub_field("external_title",$back_issue_id)?>
                                                        </a>                                    
                                                <?php endif;?>                       
                                                </li>
                                        <?php endwhile;?>                         
                                    </ul>                        
                                </div>

                                <div class="right">
                                    <div class="issueNo">
                                        <?php the_title();?>
                                        <!-- <br> <span class="">The Texas Issue</span> -->
                                    </div>
                                    <ul class="list">                            
                                        <h3>Features</h3>
                                        <?php while(has_sub_field("features_link",$back_issue_id)): ?>
                                                <?php 
                                                $internal_feature_link  = get_sub_field("internal_feature_link",$back_issue_id);
                                                $external_feature_link  = "";
                                                $external_feature_title = "";
                                                // repeater has only 1 row
                                                while(has_sub_field("external_feature_link_repeater",$back_issue_id)){
                                                    $external_feature_link  = get_sub_field("external_feature_link",$back_issue_id);
                                                    $external_feature_title = get_sub_field("external_feature_title",$back_issue_id);
                                                }                                    
                                                ?>
                                            <?php if($internal_feature_link): ?> 
                                                <li>
                                                    <a href="<?php echo get_permalink($internal_feature_link->ID);?>"><?php echo get_the_title($internal_feature_link->ID);?></a>
                                                </li>
                                            <?php elseif($external_feature_link):?>
                                                <li>
                                                    <a href="<?php echo $external_feature_link;?>"><?php echo $external_feature_title;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endwhile;?>
                                    </ul>

                                    <ul class="list">                            
                                        <h3>Departments</h3>
                                        <?php while(has_sub_field("departments_link",$back_issue_id)): ?>
                                                <?php 
                                                $internal_department_link  = get_sub_field("internal_department_link",$back_issue_id);
                                                $external_feature_link  = "";
                                                $external_feature_title = "";
                                                // repeater has only 1 row
                                                while(has_sub_field("external_pepartment_link_repeater",$back_issue_id)){
                                                    $external_department_link  = get_sub_field("external_department_link",$back_issue_id);
                                                    $external_department_title = get_sub_field("external_department_title",$back_issue_id);
                                                }                                    
                                                ?>
                                            <?php if($internal_department_link): ?> 
                                                <li>
                                                    <a href="<?php echo get_permalink($internal_department_link->ID);?>"><?php echo get_the_title($internal_department_link->ID);?></a>
                                                </li>
                                            <?php elseif($external_department_link):?>
                                                <li>
                                                    <a href="<?php echo $external_department_link;?>"><?php echo $external_department_title;?></a>
                                                </li>
                                            <?php endif;?>
                                        <?php endwhile;?>
                                    </ul>

                                    <ul class="list">                            
                                        <h3>Recipes</h3>
                                        <?php while(has_sub_field("recipes_link",$back_issue_id)): ?>
                                                <?php 
                                                $recipe_link  = get_sub_field("recipe_link",$back_issue_id);
                                                ?>
                                                <li>
                                                    <a href="<?php echo get_permalink($recipe_link->ID);?>"><?php echo get_the_title($recipe_link->ID);?></a>
                                                </li>
                                        <?php endwhile;?>
                                    </ul>                                                
                                </div>
                                <div class="clearfix"></div>
                            </section>                        
                    <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="panelRight">
            <?php get_sidebar();?>
        </div>
        <div class="clearfix"></div>
    </div>
<?php get_footer();?>
