<?php


/**
 * Function Blog with advanced features
 *
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

if (!function_exists('fenomen_extension_slider_box')) {
    function fenomen_extension_slider_box($atts)
    {
        
        global $post;
        global $fenomen_sc_slider_i;
        
        static $sn = 1;
        
        $output = '';
        
        $atts = shortcode_atts(array(
            'id' => $post->ID,
            'orderby' => 'date',
            'posts' => '3',
        ), $atts, 'fenomen_slider');
        
        // Return Shortcode Attributes
        
        global $fenomen_slider_atts;
        $fenomen_slider_atts = array(
            'id' => $atts['id'],
            'orderby' => $atts['orderby'],
            'posts' => $atts['posts'],
        );

        if ($atts['posts']) {
            $posts_num = $atts['posts'];
        } else {
            $posts_num = 3;
        }
        
        $output .= '<div class="fm-box-layout slider-featured-layout slider-box-layout clearfix">';
        $output .= '<div class="slider-box-layout-content clearfix">';
        $output .= '<div class="slider-carousel slider-carousel-group slider-other-group owl-carousel" data-items="1">';

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
            'posts_per_page' => $posts_num,
            'orderby' => $w_posts_order,
            'meta_key' => $w_posts_key,
            'order' => 'DESC',
        );
        $fenomen_query = new WP_Query($args_order);
        
        $fenomen_sc_slider_i = 0;
        while ($fenomen_query->have_posts()) {
            $fenomen_query->the_post();
            $fenomen_sc_slider_i++;
            $output .= fenomen_sc_slider();
        } 

        $output .= '</div>';        
        $output .= '</div>';
        $output .= '</div>';
        
        wp_reset_postdata(); 
        wp_reset_query(); 
        
        $sn++;
        return $output;
    }
}
add_shortcode("fenomen_slider", "fenomen_extension_slider_box");


if (!function_exists('fenomen_extension_slider_integrateWithVC')) {
    function fenomen_extension_slider_integrateWithVC()
    {
        vc_map(array(
            "name" => __("FM: Slider / Posts", "fenomen"),
            "base" => "fenomen_slider",
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
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Posts", "fenomen"),
                    "param_name" => "posts",
                    "value" => __("3", "fenomen"),
                    "description" => __("Input Posts Num.", "fenomen"),
                    "group" => __("General", "fenomen")
                ),
            )
        ));
    }
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (is_plugin_active('js_composer/js_composer.php')) {
    add_action('vc_before_init', 'fenomen_extension_slider_integrateWithVC');
}


?>