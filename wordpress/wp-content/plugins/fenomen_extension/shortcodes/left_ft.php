<?php


/**
 * Function Blog with advanced features
 *
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

if (!function_exists('fenomen_extension_left_ft_box')) {
    function fenomen_extension_left_ft_box($atts)
    {
        global $post;
        global $fenomen_field;
        static $sn = 1;
        $vn_h   = '';
        $vn_l   = '';
        $output = '';
        $atts   = shortcode_atts(array(
            'id' => $post->ID,
            'title' => '',
            'posts' => '7',
            'filter' => '',
            'filter_type' => 'top',
            'cats' => '',
            'tags' => '',
            'authors' => '',
            'offset' => ''
        ), $atts, 'fenomen_left_ft');
        
        // Return Shortcode Attributes
        
        global $fenomen_left_ft_atts;
        $fenomen_left_ft_atts = array(
            'id' => $atts['id'],
            'title' => $atts['title'],
            'filter' => $atts['filter'],
            'filter_type' => $atts['filter_type'],
            'cats' => $atts['cats'],
            'tags' => $atts['tags'],
            'authors' => $atts['authors'],
            'offset' => $atts['offset']
        );
        
        $id = intval($atts['id']);
        
        if ($atts['posts']) {
            $posts_num = $atts['posts'];
        } else {
            $posts_num = 7;
        }
        
        $output .= '<div class="fm-box-layout left-ft-box-layout clearfix">';
        if ($atts['filter']) {
            $fid = mt_rand(111111111111111, 999999999999999);
            $output .= '<div id="filter-tab-' . $fid . '" data-id="' . $fid . '" class="tab-switcher clearfix">';
            $output .= '<div class="tab-switch-title">';
        }
        
        if ($atts['title']) {
            $output .= '<h2 class="fm-box-title clearfix"><span>' . $atts['title'] . '</span></h2>';
        }
        
        if ($atts['filter']) {
            $output .= '<div class="tab-headers"><div class="tab-headers-content"><ul>';
            if ($atts['filter_type'] == "top") {
                foreach (fenomen_filter_array('top') as $value) {
                    $vn_h++;
                    if ($vn_h == 1) {
                        $current_header_tab = ' class="current-header-tab"';
                    } else {
                        $current_header_tab = '';
                    }
                    
                    if ($vn_h == 1) {
                        $header_tab_title = __('by Date', 'fenomen');
                    } elseif ($vn_h == 2) {
                        $header_tab_title = __('by Views', 'fenomen');
                    } elseif ($vn_h == 3) {
                        $header_tab_title = __('by Comments', 'fenomen');
                    }
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-left-ft-' . $vn_h . '-' . $sn . '"><span>' . $header_tab_title . '</span></li>';
                }
            } elseif ($atts['filter_type'] == "cat") {
                if ($atts['cats']) {
                    $cat_array = explode(',', $atts['cats']);
                } else {
                    $cat_array = fenomen_filter_array('cat');
                }
                
                foreach ($cat_array as $category) {
                    $vn_h++;
                    
                    if ($atts['cats']) {
                        $cat_id = get_cat_name($category);
                    } else {
                        $cat_id = $category->name;
                    }
                    
                    if ($vn_h == 1) {
                        $current_header_tab = ' class="current-header-tab"';
                    } else {
                        $current_header_tab = '';
                    }
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-left-ft-' . $vn_h . '-' . $sn . '"><span>' . esc_html($cat_id) . '</span></li>';
                }
            } elseif ($atts['filter_type'] == "format") {
                foreach (fenomen_filter_array('format') as $value) {
                    $vn_h++;
                    if ($vn_h == 1) {
                        $current_header_tab = ' class="current-header-tab"';
                    } else {
                        $current_header_tab = '';
                    }
                    
                    if ($value == "image") {
                        $header_tab_title = __('Image', 'fenomen');
                    } elseif ($value == "gallery") {
                        $header_tab_title = __('Gallery', 'fenomen');
                    } elseif ($value == "video") {
                        $header_tab_title = __('Video', 'fenomen');
                    } elseif ($value == "audio") {
                        $header_tab_title = __('Audio', 'fenomen');
                    }
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-left-ft-' . $vn_h . '-' . $sn . '"><span>' . $header_tab_title . '</span></li>';
                }
            }
            
            $output .= '</ul></div></div>';
            $output .= '</div>';
        }
        
        $output .= '<div class="fm-box-layout-content left-ft-box-layout-content clearfix">';
        if ($atts['filter']) {
            if ($atts['filter_type'] == "top") {
                foreach (fenomen_filter_array('top') as $value) {
                    $vn_l++;
                    $w_posts_key   = '';
                    $w_posts_order = '';
                    if ($vn_l == 2) {
                        $w_posts_order = 'meta_value_num';
                        $w_posts_key   = 'post_views_count';
                    } elseif ($vn_l == 3) {
                        $w_posts_order = 'comment_count';
                    } else {
                        $w_posts_order = 'date';
                    }
                    
                    $args_filter  = array(
                        'post_type' => 'post',
                        'posts_per_page' => $posts_num,
                        'orderby' => $w_posts_order,
                        'meta_key' => $w_posts_key,
                        'order' => 'DESC',
                        'cat' => $atts['cats'],
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $atts['offset']
                    );
                    $query_filter = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-left-ft-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    global $fenomen_sc_left_ft_i;
                    $fenomen_sc_left_ft_i = 0;
                    while ($query_filter->have_posts()) {
                        $query_filter->the_post();
                        $fenomen_sc_left_ft_i++;
                        $output .= fenomen_sc_left_ft();
                    }
                    
                    if ($query_filter->have_posts()) {
                        $output .= '</div>';
                    }
                    
                    wp_reset_postdata();
                    wp_reset_query();
                    $output .= '</div></div>';
                }
            } elseif ($atts['filter_type'] == "cat") {
                if ($atts['cats']) {
                    $cat_array = explode(',', $atts['cats']);
                    $cat_id    = $category;
                } else {
                    $cat_array = fenomen_filter_array('cat');
                    $cat_id    = $category->term_id;
                }
                foreach ($cat_array as $category) {
                    $vn_l++;
                    
                    if ($atts['cats']) {
                        $cat_id = $category;
                    } else {
                        $cat_id = $category->term_id;
                    }
                    
                    $args_filter  = array(
                        'post_type' => 'post',
                        'posts_per_page' => $posts_num,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'cat' => $cat_id,
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $atts['offset']
                    );
                    $query_filter = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-left-ft-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    global $fenomen_sc_left_ft_i;
                    $fenomen_sc_left_ft_i = 0;
                    while ($query_filter->have_posts()) {
                        $query_filter->the_post();
                        $fenomen_sc_left_ft_i++;
                        $output .= fenomen_sc_left_ft();
                    }
                    
                    if ($query_filter->have_posts()) {
                        $output .= '</div>';
                    }
                    
                    wp_reset_postdata();
                    wp_reset_query();
                    $output .= '</div></div>';
                }
            } elseif ($atts['filter_type'] == "format") {
                foreach (fenomen_filter_array('format') as $value) {
                    $vn_l++;
                    $pformat      = 'post-format-' . $value;
                    $args_filter  = array(
                        'post_type' => 'post',
                        'posts_per_page' => $posts_num,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'cat' => $atts['cats'],
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $atts['offset'],
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'post_format',
                                'field' => 'slug',
                                'terms' => $pformat
                            )
                        )
                    );
                    $query_filter = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-left-ft-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    global $fenomen_sc_left_ft_i;
                    $fenomen_sc_left_ft_i = 0;
                    while ($query_filter->have_posts()) {
                        $query_filter->the_post();
                        $fenomen_sc_left_ft_i++;
                        $output .= fenomen_sc_left_ft();
                    }
                    
                    if ($query_filter->have_posts()) {
                        $output .= '</div>';
                    }
                    
                    wp_reset_postdata();
                    wp_reset_query();
                    $output .= '</div></div>';
                }
            }
        } else {
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => $posts_num,
                'orderby' => 'date',
                'order' => 'DESC',
                'cat' => $atts['cats'],
                'tag_id' => $atts['tags'],
                'author' => $atts['authors'],
                'offset' => $atts['offset']
            );
            
            $query = new WP_Query($args);
            global $fenomen_sc_left_ft_i;
            $fenomen_sc_left_ft_i = 0;
            while ($query->have_posts()) {
                $query->the_post();
                global $fenomen_sc_left_ft_i;
                $fenomen_sc_left_ft_i++;
                $output .= fenomen_sc_left_ft();
            }
            
            if ($query->have_posts()) {
                $output .= '</div>';
            }
        }
        
        $output .= '</div><!-- Box Layout Content -->';
        if ($atts['filter']) {
            $output .= '</div><!-- Tab Switcher -->';
        }
        
        $output .= '</div><!-- Box Layout -->';
        wp_reset_postdata();
        wp_reset_query();
        
        $sn++;
        return $output;
    }
}
add_shortcode("fenomen_left_ft", "fenomen_extension_left_ft_box");

if (!function_exists('fenomen_extension_left_ft_integrateWithVC')) {
    function fenomen_extension_left_ft_integrateWithVC()
    {
        vc_map(array(
            "name" => __("FM: Left FT / Posts", "fenomen"),
            "base" => "fenomen_left_ft",
            "category" => __("Fenomen", "fenomen"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Title", "fenomen"),
                    "description" => __("Leave the field empty if you don't need for title.", "fenomen"),
                    "param_name" => "title",
                    "value" => "",
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __("Filter", "fenomen"),
                    "description" => __("Enable Filter.", "fenomen"),
                    "param_name" => "filter",
                    "value" => "",
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __("Filter Type", "fenomen"),
                    "param_name" => "filter_type",
                    "dependency" => array(
                        "element" => "filter",
                        "value" => "true"
                    ),
                    "value" => array(
                        "by Popularity" => "top",
                        "by Categories" => "cat",
                        "by Post Format" => "format"
                    ),
                    "std" => "top",
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "fenomen_vc_cat_list",
                    "class" => "",
                    "heading" => __("Categories", "fenomen"),
                    "param_name" => "cats",
                    "value" => "",
                    "group" => __("Query", "fenomen")
                ),
                array(
                    "type" => "fenomen_vc_tag_list",
                    "class" => "",
                    "heading" => __("Tags", "fenomen"),
                    "param_name" => "tags",
                    "value" => "",
                    "group" => __("Query", "fenomen")
                ),
                array(
                    "type" => "fenomen_vc_author_list",
                    "class" => "",
                    "heading" => __("Authors", "fenomen"),
                    "param_name" => "authors",
                    "value" => "",
                    "group" => __("Query", "fenomen")
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Offset", "fenomen"),
                    "description" => __("Number of post to displace or pass over.", "fenomen"),
                    "param_name" => "offset",
                    "value" => "",
                    "group" => __("Query", "fenomen")
                )
            )
        ));
    }
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';

if (is_plugin_active('js_composer/js_composer.php')) {
    add_action('vc_before_init', 'fenomen_extension_left_ft_integrateWithVC');
}


?>