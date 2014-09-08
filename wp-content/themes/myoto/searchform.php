<?php 
    $post_type = get_query_var('post_type');
    $form_search_index = rand(1,1000);
?>
<section class="SearchBlock hideBlockSearchRight">    
    <form action="<?php echo home_url( '/' ); ?>" method="get" id="search_form_<?php echo $form_search_index;?>">
        <ul>
            <fieldset>
                <li class="icoSearch">
                    <a href="javascript:void(0);" class="ico" onclick="$(this).next('ul').toggle();"></a>
                        <ul class="sub">
                            <li>
                                <?php $id1 = rand(1,1000);?>
                                <input type="radio" name="post_type" id="post_type_entire_site_<?php echo $id1;?>" value="" <?php if(empty($post_type) || $post_type =='any') echo 'checked="checked"';?>/> 
                                <label for="post_type_entire_site_<?php echo $id1;?>">Entire Site</label>
                            </li>
                            <li>
                                <?php $id2 = rand(2,1000);?>
                                <input type="radio" name="post_type" id="post_type_recipe_<?php echo $id2;?>" value="recipe" <?php if($post_type == 'recipe') echo 'checked="checked"';?>/>
                                <label for="post_type_recipe_<?php echo $id2;?>">Recipes Only</label>
                            </li>
                        </ul>
                </li>
                <li class="field"><input name="s" type="text" id="txt_search_<?php echo $form_search_index;?>" value="<?php the_search_query(); ?>"></li>
                <li class="buton"><input name="" type="button" value="Search" onclick="if(jQuery('#txt_search_<?php echo $form_search_index;?>').val().length > 0) {jQuery('#search_form_<?php echo $form_search_index;?>').submit();} return false;"></li>
            </fieldset>
        </ul>
    </form>
    <script type="text/javascript">
            $(document).ready(function() {
                    $(document).bind('click', function(e) {
                            var $clicked = $(e.target);
                            if (! $clicked.parents().hasClass("icoSearch"))
                                    $(".icoSearch ul.sub").hide();
                    });

            });
    </script>    
</section>                   
