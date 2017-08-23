<?php

/**
 * Add custom boxes
 * 
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

    require_once( plugin_dir_path( __FILE__ ) . '/h_title.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/multi6.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/multi5.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/multi3.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/left_ft.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/left_list.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/blank.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/grid.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/slider.php' ); 



/**
 * Function Create Own Param Types
 * 
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */
 
    function fenomen_extension_vc_custom_params()
    { 
        $output = '';
        $output.= vc_add_shortcode_param('fenomen_vc_cat_list', 'fenomen_vc_cat_field');
        $output.= vc_add_shortcode_param('fenomen_vc_tag_list', 'fenomen_vc_tag_field'); 
        $output.= vc_add_shortcode_param('fenomen_vc_author_list', 'fenomen_vc_author_field'); 

        return $output;
    }
    
?>