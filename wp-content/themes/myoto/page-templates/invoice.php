<?php
/**
 * Template Name: Invoice Template
 */
?>
<?php 
  $sidebar_image = get_template_directory_uri() .'/images/subscribe/subscribe_sidebar.jpg';
  $renewal_help_page   = get_page_by_title('Renewal Help');
  if($renewal_help_page){
    $renew_help_page_url = get_permalink($renewal_help_page->ID);
    $popup_url = "Popup=window.open('".$renew_help_page_url."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=600,height=550,right=50,top=50'); return false;";
  }else{
    $popup_url = '#';  
  }
  $source = isset($_GET['SourceCode']) ? $_GET['SourceCode'] : '';
  define('ERROR_INVOICE','Please double check the information you entered and try again. If problems continue, please contact subscriptions@imbibemagazine.com or call 1-877-246-2423 for assistance.');
  //header('Location: /subscribe.php?action=fill&promo=' . $promo . '&sn=' . $sub_num . '&SourceCode=' . $source);
  if(isset($_POST['action']) && $_POST['action'] == 'find'){    
    $SubscriptionNum = $_POST['SubscriptionNum'];
    $ShiptoName      = $_POST['ShiptoName'];
    $ShiptoCity      = $_POST['ShiptoCity'];
    $ShiptoZip       = $_POST['ShiptoZip'];
    try{
        global $wpdb;
        if($SubscriptionNum){
            $sql = $wpdb->prepare("SELECT * FROM customer_invoices WHERE SubscriptionNum = %s", $SubscriptionNum);        
            $row  = $wpdb->get_row($sql);
            if(!$row)throw new Exception(ERROR_INVOICE);
        }else{
            if($ShiptoName && $ShiptoCity && $ShiptoZip){
                if($ShiptoName){
                    $name_array = explode(" ",$ShiptoName);
                    $first_name = $name_array[0];
                    $last_name  = $name_array[1];
                    foreach ($name_array as $key => $namepart) {
                        if ($key > 1) {
                            $last_name .= ' ' . $name_array[$key];
                        }
                    }                
                }
                
                $sql = 'SELECT * FROM customer_invoices
                        WHERE (`ShiptoFirstName` LIKE "%' . $first_name . '%")
                        AND (`ShiptoLastName` LIKE "%' . $last_name . '%")
                        AND (`ShiptoCity` LIKE "%' . $ShiptoCity . '%")
                        AND (`ShiptoZip` LIKE "%' . $ShiptoZip . '%")';
                
                $row  = $wpdb->get_row($sql);
                if(!$row)throw new Exception(ERROR_INVOICE);                
            }else throw new Exception(ERROR_INVOICE);
        }
        
        $subscribe_page = get_page_by_title('Subscribe');
        if($subscribe_page){
            $subscribe_url = get_permalink(get_page_by_title('Subscribe')->ID);
            $subscribe_url = add_query_arg(array('action'=>'fill','promo'=>'invoice','sn'=>$row->SubscriptionNum,'SourceCode'=>$source),$subscribe_url);
            header('Location: '.$subscribe_url);
            exit;
        }else throw new Exception('Sorry, Subscribe page not exists. Please contact to admin to report this issue. Thanks so much!');
    }catch(Exception $ex){
        $error = $ex->getMessage();
    }
  }
?>
<?php get_header();?>
<div class="content clearfix">
    <div class="panelCenter">
        <style>
            label.error{
                color: red !important;
                width: auto !important;
            }
            input.error{
                border: 1px solid red !important;
            }
            select.error{
                border: 1px solid red !important;
            }
        </style>
            <section>
            <ul class="breadcrumb">
                <li><a href="<?php echo home_url();?>">Home</a></li>
                <li><span>Invoice</span></li>
            </ul>
        </section>
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
        <section class="title" style="margin-top: 0px;">
            <ul class="subBar" style="float: right; position: absolute; margin-top: -55px;">                    
                <?php foreach($cstools as $key => $cstool):?>
                    <li><a href="<?php echo $cstool['link'];?>"><?php echo $cstool['title'];?></a><?php if($key < count($cstools)-1):?>|<?php endif;?></li>
                <?php endforeach;?>
            </ul>
        </section>            
        <?php endif;?>
                  
        
        <section class="Drinkup">
                <div class="left">
                    <div class="thumb" style="text-align:center;">
                        <img src="<?php echo $sidebar_image;?>">
                    </div>
                </div>
                <div class="right">
                    <h1 style="padding-top:0px;margin-top: 0px;">Invoice Instructions</h1>
                    <section class="formShop">
                        <p>Complete your subscription order and pay your invoice using the secure form below. If you need to update the subscription address, you will be able to do so on the order form.</p>
                        <p>Please enter either your full subscription number OR three other pieces of information to begin your renewal.
                        Click 
                        <?php if($popup_url == '#'):?>
                            <a href="#">here</a>
                        <?php else:?>
                            <a href="#" onclick="<?php echo $popup_url;?>">here</a>
                        <?php endif;?>
                        for an example to pop-up.
                        </p>
                    </section>
                    <?php                             
                        if ($error) {
                            echo '<p class="contact_error">' . $error . '</p>' . "\n";
                        }
                    ?>
                    <form method="post" id="invoice_form" action="<?php echo add_query_arg(array('promo'=>$promo,'SourceCode'=>$source),  get_permalink());?>">
                        <input type="hidden" name="action" value="find" />
                        <section class="formShop">
                            <ul>
                                <li class="field">
                                    <label style="width:300px;text-align:right;">Subscription # on address label/invoice</label>
                                    <input type="text" id="SubscriptionNum" name="SubscriptionNum" value="<?php echo $data['SubscriptionNum'];?>"/>
                                </li>
                            </ul>
                        </section>   
                        <h2 style="text-align:center;">OR</h2>
                        <section class="formShop">
                            <ul>
                                <li class="field">
                                    <label style="width:300px;text-align:right;">Full Name on address label</label>
                                    <input type="text" id="ShiptoName" name="ShiptoName" value="<?php echo $data['ShiptoName'];?>"/>
                                </li>
                                <li class="field">
                                    <label style="width:300px;text-align:right;">City on address label</label>
                                    <input type="text" id="ShiptoCity" name="ShiptoCity" value="<?php echo $data['ShiptoCity'];?>"/>
                                </li>      
                                <li class="field">
                                    <label style="width:300px;text-align:right;">Zip on address label</label>
                                    <input type="text" id="ShiptoZip" name="ShiptoZip" value="<?php echo $data['ShiptoZip'];?>"/>
                                </li>
                            </ul>
                        </section>
                        <section class="buttonRed" style="text-align:center;">
                            <a href="javascript:void(0);" onclick="submitFormProcess();return false;">Submit</a>
                        </section>                        
                    </form>
                </div>
        </section>
        <script type="text/javascript">
            $(document).ready(function(){
               $("#invoice_form input[type='text']").keyup(function( event ) {
                    if ( event.which == 13 ) {    
                        submitFormProcess();
                    }
               });
 
            });
            function submitFormProcess(){
                var check_form = false;
                if($("#SubscriptionNum").val()){
                    check_form = true;
                }else{
                    if($("#ShiptoName").val() && $("#ShiptoCity").val() && $("#ShiptoZip").val())
                        check_form = true;
                }
                if(check_form) $("#invoice_form").submit();
                else alert('<?php echo ERROR_INVOICE;?>');
            }
        </script>    
    </div>
</div>
<?php get_footer();?>