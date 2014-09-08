<header>
    	<h1 id="logo"><a href="<?php echo home_url();?>"></a></h1>
        <ul class="social">
            <li><a href="<?php echo 'http://facebook.com/' . get_theme_option('imbibe_facebook_id');?>" class="facebook"></a></li>
            <li><a href="<?php echo 'http://twitter.com/' .  get_theme_option('imbibe_twitter_id');?>" class="twitter"></a></li>
            <li><a href="<?php echo 'http://pinterest.com/' .  get_theme_option('imbibe_pinterest_id');?>" class="pinterest"></a></li>
            <li><a href="<?php echo 'http://instagram.com/' .  get_theme_option('imbibe_instagram_id');?>" class="instagram"></a></li>
        </ul>
        <nav>
            <div class="hideBlockSearch">
                <?php get_search_form();?>            
            </div>             
           <?php wp_nav_menu( array('theme_location'=>"header-menu","menu_class"=>"dropcordion") ); ?> 
            <script type="text/javascript">
                $(document).ready(function(){
                    var index = 0;
                    $("#menu-header-menu").children("li").each(function(){
                        index++;
                        $(this).addClass('menu-Tab-'+index);
                        if($(this).children('.sub-menu').size() > 0){
                            $(this).children('a').attr("href","javascript:void(0);"); 
                        }
                    });
                    
                    $("#menu-header-menu li:eq(0) a").attr("href","javascript:void(0);");
                    $("#menu-header-menu li:eq(0)").addClass('first Subscribe');
                    $("#menu-header-menu li:eq(0) a").after($("#subscribe_hover_menu").html());
                    $(".Subscribe a").click(function(){
                            $(".Subscribe .subFormMenu").toggle();
                    });
                    $(document).bind('click', function(e) {
                            var $clicked = $(e.target);
                            if (! $clicked.parents().hasClass("Subscribe"))
                                    $(".subFormMenu").hide();
                    });
                });
            </script>
            <?php 
                require_once(get_template_directory() . '/lib/subscribe/includes/functions/general.php');
                $states    = get_states();
                $countries = get_countries();                
            ?>
            <span id="subscribe_hover_menu" style="display:none;">
                <div class="subFormMenu">
                    <div class="tile">Save up to <span class="price">46%</span>
                        <br>
                        <em>When you Subscribe Today</em>
                    </div>
                    <style>
                        #subscribe_mini_form label.error{
                            display:none !important;
                        }
                        #subscribe_mini_form input.error{
                            border: 1px solid red;
                        }
                        #subscribe_mini_form select.error{
                            border: 1px solid red;
                        }
                        #subscribe_mini_form label span{
                            color: red;
                        }
                        #subscribe_mini_form select{
                            background: none repeat scroll 0 0 #FFFFFF;
                            border: 1px solid #BEBEBE;
                            height: 27px;
                            padding: 0px;
                            width: 174px;                            
                        }
                    </style>
                    <form action="<?php echo home_url();?>" method="get" id="subscribe_mini_form">
                        <input type="hidden" name="page_id" value="<?php echo get_page_by_title('subscribe')->ID;?>"/>
                        <input type="hidden" name="from" value="mini-form"/>
                        <ul class="subscribeForm">
                            <p class="h-subscribe_type">
                                <input type="hidden" name="SubType" id="MenuSubType" value="1-year print subscription"/>
                                <?php 
                                    $h_sub_options = array();
                                    $h_sub_display = array(); // the form will use this array to display two radio button options
                                    $h_sub_options = get_subscrip_option(null);
                                    $h_sub_display = array(); // the form will use this array to display two radio button options
                                        foreach ($h_sub_options as $key => $array) {
                                        $h_sub_display[$key] = $array[1];
                                    }
                                ?>
                                <?php $iii = 0; foreach($h_sub_display as $k=>$v): $iii++; $kk = str_replace(' ', '-', $k) ?>
                                    <?php if($k != '2-years print subscription'):?>
                                    <label class="label-<?php echo $kk;?>" for="<?php echo $kk;?>">
                                        <input class="SubTypeChk" <?php if($iii == 1) echo 'checked="checked"';?> id="<?php echo $kk;?>" type="checkbox" name="SubType_<?php echo $iii;?>" value="<?php echo $k;?>"/>
                                        <?php switch($k){
                                                case '1-year print subscription': echo 'PRINT <b>$'.$h_sub_options[$k][0].'</b>'; break;
                                                case '2-years print subscription': echo 'PRINT <b>$'.$h_sub_options[$k][0].'</b> 2 years'; break;
                                                case '1-year digital subscription': echo 'DIGITAL <b>$'.$h_sub_options[$k][0].'</b>'; break;
                                                case '1-year print and digital subscription': echo 'PRINT + DIGITAL <b>$'.$h_sub_options[$k][0].'</b>'; break;
                                                default:
                                                    echo strip_tags($v);   
                                            }
                                        ?>
                                    </label>
                                    <?php endif;?>                                
                                <?php endforeach;?>
                                <script type="text/javascript">
                                    $(document).ready(function(){
                                        $("input:checkbox.SubTypeChk").click(function(){
                                            $("#MenuSubType").val($(this).val());
                                            $("input:checkbox.SubTypeChk").not($(this)).removeAttr("checked");
                                            $(this).attr("SubTypeChk", $(this).attr("checked"));    
                                        });                                        
                                    });
                                </script>
                            </p>
                            <p>
                                <label>First Name <span>*</span></label> 
                                <input name="ShiptoFirstName" type="text" validate="required:true">
                            </p>
                            <p>
                                <label>Last Name <span>*</span></label>
                                <input name="ShiptoLastName" type="text" validate="required:true">
                            </p>
                            <p>
                                <label>Company</label>
                                <input name="ShiptoCompany" type="text" >
                            </p>
                            <p>
                                <label>Address 1 <span>*</span></label>
                                <input name="ShiptoAddress1" type="text" validate="required:true">
                            </p>
                            <p>
                                <label>Address 2</label>
                                <input name="ShiptoAddress2" type="text" >
                            </p>
                            <p>
                                <label>City <span>*</span></label>
                                <input type="text" name="ShiptoCity" validate="required:true"/>
                            </p>
                            <p>
                                <label>State <span>*</span></label>
                                <select name="ShiptoState" validate="required:true">
                                    <?php foreach($states as $k=>$s):?>
                                        <option value="<?php echo $k;?>"><?php echo $s;?></option>
                                    <?php endforeach;?>
                                </select>    
                            </p>
                            <p>
                                <label>Zip Code <span>*</span></label>
                                <input name="ShiptoZip" type="text" validate="required:true">
                            </p>
                            <p>
                                <label>Country <span>*</span></label>                          
                                <select name="ShiptoCountry" validate="required:true">
                                    <?php foreach($countries as $k=>$s):?>
                                        <option value="<?php echo $k;?>"><?php echo $s;?></option>
                                    <?php endforeach;?>
                                </select>
                            </p>
                            <p>
                                <label>Email <span>*</span></label>
                                <input name="Email" type="text" validate="required:true,email:true">
                            </p>
                            <p>
                                <label>Phone <span>*</span></label>
                                <input name="Phone" type="text" validate="required:true">
                            </p>                            
                            <p>
                                <input name="button-submit-mini-form" type="button" value="submit" onclick="submit_mini_subscribe_process();return false;">
                            </p>
                            <div class="clearfix"></div>
                        </ul>
                    </form>
                    <script type="text/javascript">
                        function submit_mini_subscribe_process(){
                            validate_form = submit_mini_subscribe_validateRules();        
                            if(validate_form.form()){ 
                                jQuery("#subscribe_mini_form").submit();
                            }
                        }
                        function submit_mini_subscribe_validateRules(){
                            jQuery.metadata.setType("attr", "validate");
                            return jQuery("#subscribe_mini_form").validate();
                        }    
                        
                    </script>    
                </div>
           </span>
        </nav>
        <script type="text/javascript">
            jQuery(document).ready(function(){
               jQuery('.sub-menu').parent('li').addClass('drop-down');               
               // have sub-menu
               if($(".current-menu-item").parent('.sub-menu').size()>0){
                  $(".current-menu-item").parent('.sub-menu').prev('a').addClass('active');
               }else{
                   jQuery(".current-menu-item > a").addClass("active");
               }               
               
            });
        </script>        
</header>

<?php 
    $arr_menus  = array();
    $menu_items = wp_get_nav_menu_items('header-menu');
    foreach($menu_items as $m_item){
        if($m_item->menu_item_parent){
            if(!isset($arr_menus[$m_item->menu_item_parent])) $arr_menus[$m_item->menu_item_parent] = array();
            $arr_menus[$m_item->menu_item_parent][] = array('ID'=>$m_item->ID,"title"=>$m_item->title,"url"=>$m_item->url);
        }else{
            if(!isset($arr_menus[$m_item->ID])) $arr_menus[$m_item->ID]   = array();
            $arr_menus[$m_item->ID][] = array('ID'=>$m_item->ID,"title"=>$m_item->title,"url"=>$m_item->url);
        }
    }
    #echo '<pre>';
    #print_r($arr_menus);
    $html  = '<nav>';
    $html .= '<ul class="dropcordion">';
    $tab_index = 1;
    foreach($arr_menus as $item){
        if(count($item) == 1){
            foreach($item as $sub_index => $sub_item){
                $url   = $sub_item["url"];
                $title = $sub_item["title"];       
                $t_title = str_replace(array(' ','&','--'), array('-','','-'), $title);
                $class_page = 'Page-'.ucfirst(str_replace(' ','-',$t_title));
                
                $html .= "<li class='menu-Tab-{$tab_index} {$class_page} '>";
                $html.= "<a href='{$url}'>{$title}</a>";
                $html .= "</li>";                
            }
        }else{
            $url   = $item[0]["url"];
            $title = $item[0]["title"];  
            
            $t_title = str_replace(array(' ','&','--'), array('-','','-'), $title);
            $class_page = 'Page-'.ucfirst(str_replace(' ','-',$t_title));
            
            $html .= "<li class='menu-Tab-{$tab_index} {$class_page} '>";
            $html .= "<a href='javascript:void(0);'>{$title}</a>";            
            $html .= "<ul class='sub-menu'>";
            $html .= '<div class="bgSub-menu">';
            foreach($item as $sub_index => $sub_item){
                $url   = $sub_item["url"];
                $title = $sub_item["title"];          
                if($sub_index > 0){
                    $html .= "<li>";
                    $html .= "<a href='{$url}'>{$title}</a>";
                    $html .= '</li>';
                }
            }            
            $html .= '</div>';
            $html .= '</ul>';
            $html .= "</li>";
        }      
        $tab_index++;
    }
    $html .= '</ul>';
    $html .= '</nav';
    echo $html;
?>