<?php 
    define ('IMBIBE_URI' , get_template_directory_uri());
    define ('IMBIBE_DIR' , get_template_directory());
    define ('IMBIBE_JS' , IMBIBE_URI . '/js');
    define ('IMBIBE_CSS' , IMBIBE_URI . '/css');
    define ('IMBIBE_IMG' , IMBIBE_URI . '/images');
    define ('IMBIBE_LIB' , IMBIBE_DIR . '/lib');
    define ('IMBIBE_FUN', IMBIBE_LIB . '/functions');
    define ('IMBIBE_WIDGETS', IMBIBE_LIB . '/widgets');
    define ('IMBIBE_SC', IMBIBE_LIB . '/shortcodes');    
    
    /*-------------------------------------------*/
    require_once  IMBIBE_LIB . '/meta-box/meta-box.php';
    /*-------------------------------------------*/

    foreach(glob(IMBIBE_LIB.'/functions/*.php') as $file){
        require_once $file;
    }
    foreach(glob(IMBIBE_LIB.'/widgets/*.php') as $file){
        require_once $file;
    }    
    foreach(glob(IMBIBE_LIB.'/shortcodes/*.php') as $file){
        require_once $file;
    }
    
    foreach(glob(IMBIBE_LIB.'/admin/*.php') as $file){
        require_once $file;
    }
?>