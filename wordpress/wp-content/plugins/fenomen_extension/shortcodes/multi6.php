<?php


/**
 * Function Blog with advanced features
 *
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

if (!function_exists('fenomen_extension_multi6_box')) {
    function fenomen_extension_multi6_box($atts)
    {
        
        global $post;
        global $fenomen_sc_multi6_i;
        
        static $sn = 1;
        
        $output = '';
        
        $atts = shortcode_atts(array(
            'id' => $post->ID,
            'orderby' => 'date',
        ), $atts, 'fenomen_multi6');
        
        // Return Shortcode Attributes
        
        global $fenomen_multi6_atts;
        $fenomen_multi6_atts = array(
            'id' => $atts['id'],
            'orderby' => $atts['orderby'],
        );
        
        $output .= '<div class="fm-box-layout multi-featured-layout multi6-box-layout clearfix">';
        $output .= '<div class="multi6-box-layout-content clearfix">';

        $w_posts_key = '';
        if ( $atts['orderby'] == "comms" ) {
            $w_posts_order = 'comment_count';
        } elseif ( $atts['orderby'] == "views" ) {
            $w_posts_order = 'meta_value_num';
            $w_posts_key = 'post_views_count';
        } else {
            $w_posts_order = 'date';
        }

        $args_order = array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'orderby' => $w_posts_order,
            'meta_key' => $w_posts_key,
            'order' => 'DESC',
        );
        $fenomen_query = new WP_Query($args_order);
        
        $fenomen_sc_multi6_i = 0;
        while ($fenomen_query->have_posts()) {
            $fenomen_query->the_post();
            $fenomen_sc_multi6_i++;
            $output .= fenomen_sc_multi6();
        } 
        
        $output .= '</div>';
        $output .= '</div>';
        
        wp_reset_postdata(); 
        wp_reset_query(); 
        
        $sn++;
        return $output;
    }
}
add_shortcode("fenomen_multi6", "fenomen_extension_multi6_box");


if (!function_exists('fenomen_extension_multi6_integrateWithVC')) {
    function fenomen_extension_multi6_integrateWithVC()
    {
        vc_map(array(
            "name" => __("FM: Multi6 / Posts", "fenomen"),
            "base" => "fenomen_multi6",
            "category" => __("Fenomen", "fenomen"),
            "description" => __("Only for Featured Area!", "fenomen"),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __("Order By", "fenomen"),
                    "param_name" => "orderby",
                    "value" => array(
                        "Date" => "date",
                        "Number of Views" => "views",
                        "Number of Comments" => "comms"
                    ),
                    "std" => "date",
                    "group" => __("General", "fenomen")
                ),
            )
        ));
    }
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (is_plugin_active('js_composer/js_composer.php')) {
    add_action('vc_before_init', 'fenomen_extension_multi6_integrateWithVC');
}


?>