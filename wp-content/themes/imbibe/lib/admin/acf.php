<?php
    foreach ( glob( get_template_directory().'/lib/admin/acf/*.php' ) as $file ){
        require_once($file);
    }
?>
