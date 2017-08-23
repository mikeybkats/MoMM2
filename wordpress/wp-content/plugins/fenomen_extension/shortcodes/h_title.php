<?php


/**
 * Function Blog with advanced features
 *
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

if (!function_exists('fenomen_extension_h_title')) {
    function fenomen_extension_h_title($atts)
    {
        
        global $post;
        static $sn = 1;
        
        $output = '';
        
        $atts = shortcode_atts(array(
            'title' => ''
        ), $atts, 'fenomen_title');
        
        // Return Shortcode Attributes
        
        global $fenomen_title_atts;
        $fenomen_title_atts = array();
        
        $output .= '<h2 class="fm-box-title clearfix"><span>' . $atts['title'] . '</span></h2>';
        
        return $output;
        
        wp_reset_postdata();
        
        
        wp_reset_query();
        
        $sn++;
        return $output;
    }
}
add_shortcode("fenomen_title", "fenomen_extension_h_title");

if (!function_exists('fenomen_extension_title_integrateWithVC')) {
    function fenomen_extension_title_integrateWithVC()
    {
        vc_map(array(
            "name" => __("FM: Title", "fenomen"),
            "base" => "fenomen_title",
            "category" => __("Fenomen", "fenomen"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Heading", "gamepress"),
                    "param_name" => "title",
                    "value" => ""
                )
            )
        ));
    }
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (is_plugin_active('js_composer/js_composer.php')) {
    add_action('vc_before_init', 'fenomen_extension_title_integrateWithVC');
}


?>