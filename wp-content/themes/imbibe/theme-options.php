<?php
// Default options values
global $forix_options, $forix_options_define;
$forix_options_define = array(
    array(
        'name'  => 'imbibe_twitter_id',
        'label' => 'Imbibe Twitter ID',
        'value' => 'imbibe',
        'type'  => 'text'
    ),
    array(
        'name'  => 'imbibe_facebook_id',
        'label' => 'Imbibe Facebook ID',
        'value' => 'imbibe',
        'type'  => 'text'
    ),
    array(
        'name'  => 'imbibe_pinterest_id',
        'label' => 'Imbibe Pinterest ID',
        'value' => 'imbibe',
        'type'  => 'text'
    ),    
    array(
        'name'  => 'imbibe_instagram_id',
        'label' => 'Imbibe Instagram ID',
        'value' => 'imbibe',
        'type'  => 'text'
    ),
    array(
        'hr'    => true,
        'text'  => 'Config Subscribe'
    ),
    array(
        'name'  => 'COMPANY_NAME',
        'label' => 'Company Name',
        'value' => 'Imbibe Magazine',
        'type'  => 'text'
    ),
    array(
        'name'  => 'CONTACT_EMAIL',
        'label' => 'Contact Email',
        'value' => 'subscriptions@imbibemagazine.com',
        'type'  => 'text'
    ),
    array(
        'name'  => 'COMPANY_PHONE',
        'label' => 'Company Phone',
        'value' => '1-877-246-2423',
        'type'  => 'text'
    ),
    array(
        'name'  => 'FROM_EMAIL',
        'label' => 'From Email',
        'value' => 'subscriptions@imbibemagazine.com',
        'type'  => 'text'
    ),
    array(
        'name'  => 'ERROR_EMAIL',
        'label' => 'Error Email',
        'value' => 'hannah@synotac.com,subscriptions@imbibemagazine.com',
        'type'  => 'text'
    ),
    array(
        'name'  => 'CONTACT_BCC',
        'label' => 'Contact BCC',
        'value' => 'synotac@gmail.com',
        'type'  => 'text'
    ),
    array(
        'name'  => 'CONFIRM_BCC',
        'label' => 'Confirm BCC',
        'value' => 'subscriptions@imbibemagazine.com',
        'type'  => 'text'
    ),
    array(
        'hr'    => true,
        'text'  => 'Subscribe Paypal Settings'
    ),
    array(
        'name'  => 'PAYPAL_API_USERNAME',
        'label' => 'PAYPAL_API_USERNAME',
        'value' => 'sdk-three_api1.sdk.com',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_API_PASSWORD',
        'label' => 'PAYPAL_API_PASSWORD',
        'value' => 'QFZCWN5HZM8VBG7Q',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_API_SIGNATURE',
        'label' => 'PAYPAL_API_SIGNATURE',
        'value' => 'A.d9eRKfd1yVkRrtmMfCFLTqa6M9AyodL0SJkhYztxUi8W9pCXF6.4NI',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_API_ENDPOINT',
        'label' => 'PAYPAL_API_ENDPOINT',
        'value' => 'https://api-3t.sandbox.paypal.com/nvp',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_SUBJECT',
        'label' => 'PAYPAL_SUBJECT',
        'value' => '',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_USE_PROXY',
        'label' => 'PAYPAL_USE_PROXY',
        'value' => 0,
        'type'  => 'select',
        'options' => array(
            0 => 'No',
            1 => 'Yes'
        )
    ),
    array(
        'name'  => 'PAYPAL_PROXY_HOST',
        'label' => 'PAYPAL_PROXY_HOST',
        'value' => '127.0.0.1',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_PROXY_PORT',
        'label' => 'PAYPAL_PROXY_PORT',
        'value' => '808',
        'type'  => 'text'
    ),
    array(
        'name'  => 'PAYPAL_URL',
        'label' => 'PAYPAL_URL',
        'value' => 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=',
        'type'  => 'text'
    ),
    array(
        'hr'    => true,
        'text'  => 'Customer Service Change of Address To Email'
    ),
    array(
        'name'  => 'CUSTOMER_SERVICE_CHANGE_OF_ADDRESS_TO_EMAIL',
        'label' => 'To Email',
        'value' => 'subscriptions@imbibemagazine.com',
        'type'  => 'text'
    ),
);
foreach($forix_options_define as $k=>$v){
    if(!isset($v['hr']))
        $forix_options[$v['name']] = $v['value'];
}

function get_theme_option($name){
	global $forix_options;
	$settings = get_option( 'forix_options', $forix_options );
        
        $update_option_flag = false;
        foreach($forix_options as $k=>$v){
            if(!isset($settings[$k])){
                $settings[$k] = $v;
                $update_option_flag = true;
            }
        }
        if($update_option_flag){
            update_option('forix_options', $forix_options);
        }
        
        if(isset($settings[$name]))
            return $settings[$name];
        else return null;
}

if ( is_admin() ){

    function forix_register_settings() {
        // Register settings and call sanitation functions
        register_setting( 'forix_theme_options', 'forix_options', 'forix_validate_options' );
    }

    add_action( 'admin_init', 'forix_register_settings' );

    function forix_theme_options() {
            // Add theme options page to the addmin menu
            add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'forix_theme_options_page' );
    }

    add_action( 'admin_menu', 'forix_theme_options' );

    // Function to generate options page
    function forix_theme_options_page() {
            global $forix_options, $forix_options_define;

            if ( ! isset( $_REQUEST['settings-updated'] ) )
                    $_REQUEST['settings-updated'] = false; // This checks whether the form has just been submitted. ?>

            <div class="wrap">
                <?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
                // This shows the page's name and an icon if one has been provided ?>

                <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
                <div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
                <?php endif; // If the form has just been submitted, this shows the notification ?>

                <form method="post" action="options.php">

                    <?php 
                        $settings = get_option( 'forix_options', $forix_options ); 
                        $update_option_flag = false;
                        foreach($forix_options as $k=>$v){
                            if(!isset($settings[$k])){
                                $settings[$k] = $v;
                                $update_option_flag = true;
                            }
                        }
                        if($update_option_flag){
                            update_option('forix_options', $forix_options);
                        }
                    ?>

                    <?php settings_fields( 'forix_theme_options' );
                    /* This function outputs some hidden fields required by the form,
                    including a nonce, a unique number used to ensure the form has been submitted from the admin page
                    and not somewhere else, very important for security */ ?>

                    <table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
                        <?php foreach($forix_options_define as $row):?>
                            <?php if(isset($row['hr'])):?>
                            <tr>
                                <td colspan="2" style="padding-bottom:0px;border-bottom: 1px dotted #cccccc;">
                                    <h2><?php echo $row['text'];?></h2>
                                </td>
                            </tr>
                            <?php endif;?>
                            <?php if(isset($row['name'])):?>
                                <?php 
                                    $name  = isset($row['name']) ? $row['name'] : $row['name'];
                                    $label = isset($row['label']) ? $row['label'] : $name;
                                    $value = $settings[$name];
                                    $type  = isset($row['type']) ? $row['type'] : 'text';
                                    $options = isset($row['options']) ? $row['options'] : array();
                                ?>
                                <tr valign="top">
                                    <th scope="row"><label for="<?php echo $row['name'];?>"><?php echo $label;?></label></th>
                                    <td>
                                    <?php if($type == 'select'):?>    
                                        <select id="<?php echo $name;?>" name="forix_options[<?php echo $name;?>]">
                                            <?php if(count($options)):?>
                                                <?php foreach($options as $k=>$v):?>
                                                    <option <?php if($k == $value) echo 'selected="selected"';?> value="<?php echo $k; ?>"><?php echo $v;?></option>
                                                <?php endforeach;?>
                                            <?php endif;?>                                            
                                        </select>
                                    <?php elseif($type == 'text'):?>    
                                        <input size="80" id="<?php echo $name;?>" name="forix_options[<?php echo $name;?>]" type="text" value="<?php  esc_attr_e($settings[$name]); ?>" />
                                    <?php elseif($type == 'textarea'):?> 
                                        <textarea cols="80" rows="3" id="<?php echo $name;?>" name="forix_options[<?php echo $name;?>]"><?php  esc_attr_e($settings[$name]); ?></textarea>
                                    <?php endif;?>    
                                    </td>
                                </tr>
                            <?php endif;?>
                        <?php endforeach;?>
                    </table>
                    <p class="submit">
                        <input type="submit" class="button-primary" value="Save Options" />
                        <input type="button" class="button-primary" value="Reset Default" onclick="forix_reset_default();"/>
                    </p>
                </form>
                <script type="text/javascript">
                    function forix_reset_default(){
                        <?php 
                            global $forix_options;                            
                            foreach($forix_options as $k=>$v){
                                echo 'jQuery("#'.$k.'").val("'.$v.'");';
                            }
                        ?>                                
                    }
                </script>    
            </div>
            <?php
    }

    function forix_validate_options( $input ) {
        return $input;
    }
}