<?php if(is_active_sidebar('main-sidebar')):?>
        <?php dynamic_sidebar('main-sidebar'); ?>
<?php endif;?>
<script type="text/javascript">
    $(document).ready(function(){
       if($("#sidebar-inner01").size() == 0)
        $(".panelRight").append('<div class="inner01" id="sidebar-inner01"></div>');
       if($("#sidebar-inner02").size() == 0) 
        $(".panelRight").append('<div class="inner02" id="sidebar-inner02"></div>');
       
       //"inner01" 
       var amount_wifgets = $(".panelRight").children("section").size();
       var i = 0;
       $(".panelRight").children("section").each(function(){
          if(i <= amount_wifgets/2){
              $(this).appendTo('#sidebar-inner01');
          }else{
              $(this).appendTo('#sidebar-inner02');
          }
          i++;
       });
    });
</script>    