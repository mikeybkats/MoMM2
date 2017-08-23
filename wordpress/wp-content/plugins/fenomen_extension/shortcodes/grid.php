<?php


/**
 * Function Blog with advanced features
 *
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */


if (!function_exists('fenomen_extension_grid_box')) {
    function fenomen_extension_grid_box($atts)
    {
        
        global $post;
        global $fenomen_sc_grid_i;
        
        static $sn = 1;
        
        $output = '';
        
        $atts = shortcode_atts(array(
            'id' => $post->ID,
            'title' => '',
            'posts' => '4',
            'filter' => '',
            'filter_type' => 'top',
            'pagination' => '',
            'pagination_type' => 'numeric',
            'carousel' => '',
            'cats' => '',
            'tags' => '',
            'authors' => '',
            'offset' => ''
        ), $atts, 'fenomen_grid');
        
        // Return Shortcode Attributes
        
        global $fenomen_grid_atts;
        $fenomen_grid_atts = array(
            'id' => $atts['id'],
            'title' => $atts['title'],
            'posts' => $atts['posts'],
            'filter' => $atts['filter'],
            'filter_type' => $atts['filter_type'],
            'pagination' => $atts['pagination'],
            'pagination_type' => $atts['pagination_type'],
            'carousel' => $atts['carousel'],
            'cats' => $atts['cats'],
            'tags' => $atts['tags'],
            'authors' => $atts['authors'],
            'offset' => $atts['offset']
        );
        
        
        $id = intval($atts['id']);
        
        if ($atts['posts']) {
            $posts_num = $atts['posts'];
        } else {
            $posts_num = 3;
        }
        
        global $paged;
        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }
        
        if ($paged > 1) {
            $paged = $paged;
        } else {
            $paged = 1;
        }
       
        $feature_posts_num = $atts['offset'];
        $main_posts_num = $posts_num;
        $main_posts = ($main_posts_num * ($paged - 1));
        $offset = $feature_posts_num + (($paged > 1) ? $main_posts : 0);

        $data_id = mt_rand(111111111111111, 999999999999999);
        $gpid    = mt_rand(111111111111111, 999999999999999);
        
        if ($atts['carousel']) {
            $carousel       = ' grid-box-type-carousel';
            $carousel_prop  = ' id="carouselid-' . $gpid . '" data-id="' . $gpid . '"';
            $carousel_class = ' owl-carousel';
        } else {
            $carousel       = '';
            $carousel_prop  = '';
            $carousel_class = ' clearfix';
        }
        
        if ($atts['pagination']) {
            if ($atts['pagination_type'] == "classic") {
                $data_pagin_type = 'classic';
            } elseif ($atts['pagination_type'] == "more") {
                $data_pagin_type = 'more';
            } elseif ($atts['pagination_type'] == "scroll") {
                $data_pagin_type = 'scroll';
            } else {
                $data_pagin_type = 'numeric';
            }
            $data_pagin_type = ' data-pagin="' . $data_pagin_type . '"';
        } else {
            $data_pagin_type = '';
        }
        
        if (!$atts['carousel']) {
            $output .= '<div id="fm-box-' . $data_id . '" class="fm-box-layout grid-box-layout clearfix" data-id="' . $data_id . '"' . $data_pagin_type . '>';
        } else {
            $output .= '<div' . $carousel_prop . ' class="fm-box-layout grid-box-layout' . $carousel . ' clearfix">';
        }
        
        if ($atts['filter']) {
            $fid = mt_rand(100000000000, 999999999999);
            $output .= '<div id="filter-tab-' . $fid . '" data-id="' . $fid . '" class="tab-switcher">';
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
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-grid-' . $vn_h . '-' . $sn . '"><span>' . $header_tab_title . '</span></li>';
                }
            } elseif ($atts['filter_type'] == "cat") {
                foreach (fenomen_filter_array('cat') as $category) {
                    $vn_h++;
                    if ($vn_h == 1) {
                        $current_header_tab = ' class="current-header-tab"';
                    } else {
                        $current_header_tab = '';
                    }
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-grid-' . $vn_h . '-' . $sn . '"><span>' . esc_html($category->name) . '</span></li>';
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
                    
                    $output .= '<li' . $current_header_tab . ' data-tab="tab-grid-' . $vn_h . '-' . $sn . '"><span>' . $header_tab_title . '</span></li>';
                }
            }
            
            $output .= '</ul></div></div>';
            $output .= '</div>';
        }
        
        $output .= '<div class="fm-box-layout-content grid-box-layout-content' . $carousel_class . '">';
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
                    
                    $args_filter   = array(
                        'post_type' => 'post',
                        'posts_per_page' => $main_posts_num,
                        'orderby' => $w_posts_order,
                        'meta_key' => $w_posts_key,
                        'order' => 'DESC',
                        'cat' => $atts['cats'],
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $offset
                    );
                    $fenomen_query = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-grid-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    while ($fenomen_query->have_posts()) {
                        $fenomen_query->the_post();
                        $fenomen_sc_grid_i++;
                        $output .= fenomen_sc_grid();
                    }
                    
                    $output .= '</div></div>';
                }
            } elseif ($atts['filter_type'] == "cat") {
                foreach (fenomen_filter_array('cat') as $category) {
                    $vn_l++;
                    $args_filter   = array(
                        'post_type' => 'post',
                        'posts_per_page' => $main_posts_num,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'cat' => $category->term_id,
                        'cat' => $atts['cats'],
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $offset
                    );
                    $fenomen_query = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-grid-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    while ($fenomen_query->have_posts()) {
                        $fenomen_query->the_post();
                        $fenomen_sc_grid_i++;
                        $output .= fenomen_sc_grid();
                    }
                    
                    $output .= '</div></div>';
                }
            } elseif ($atts['filter_type'] == "format") {
                foreach (fenomen_filter_array('format') as $value) {
                    $vn_l++;
                    $pformat       = 'post-format-' . $value;
                    $args_filter   = array(
                        'post_type' => 'post',
                        'posts_per_page' => $main_posts_num,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'cat' => $atts['cats'],
                        'tag_id' => $atts['tags'],
                        'author' => $atts['authors'],
                        'offset' => $offset,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'post_format',
                                'field' => 'slug',
                                'terms' => $pformat
                            )
                        )
                    );
                    $fenomen_query = new WP_Query($args_filter);
                    if ($vn_l == 1) {
                        $current_list_tab = ' current-tab';
                    } else {
                        $current_list_tab = '';
                    }
                    
                    $output .= '<div id="tab-grid-' . $vn_l . '-' . $sn . '" class="tab"><div class="tab-content' . $current_list_tab . '">';
                    while ($fenomen_query->have_posts()) {
                        $fenomen_query->the_post();
                        $fenomen_sc_grid_i++;
                        $output .= fenomen_sc_grid();
                    }
                    
                    $output .= '</div></div>';
                }
            }
        } else {
            
            global $paged;
            if (is_front_page()) {
                $paged = (get_query_var('page')) ? get_query_var('page') : 1;
            } else {
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            }
            
            if ($paged > 1) {
                $paged = $paged;
            } else {
                $paged = 1;
            }

            $args          = array(
                'post_type' => 'post',
                'posts_per_page' => $main_posts_num,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'cat' => $atts['cats'],
                'tag_id' => $atts['tags'],
                'author' => $atts['authors'],
                'offset' => $offset
            );

 

            $fenomen_query = new WP_Query($args);
            while ($fenomen_query->have_posts()) {
                $fenomen_query->the_post();
                $fenomen_sc_grid_i++;
                $output .= fenomen_sc_grid();
            }
            
        }
        
        
        $output .= '</div><!-- Box Layout Content -->';
        
        if ($atts['pagination']) {
            if ($atts['pagination_type'] == "classic") {
                $output .= fenomen_pagination($fenomen_query->max_num_pages, '', 'classic');
            } elseif ($atts['pagination_type'] == "more") {
                $output .= fenomen_pagination($fenomen_query->max_num_pages, '', 'more');
            } elseif ($atts['pagination_type'] == "scroll") {
                $output .= fenomen_pagination($fenomen_query->max_num_pages, '', 'scroll');
            } else {
                $output .= fenomen_pagination($fenomen_query->max_num_pages, '', 'numeric');
            }
        }
        
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
add_shortcode("fenomen_grid", "fenomen_extension_grid_box");


if (!function_exists('fenomen_extension_grid_integrateWithVC')) {
    function fenomen_extension_grid_integrateWithVC()
    {
        vc_map(array(
            "name" => __("FM: Grid / Posts", "fenomen"),
            "base" => "fenomen_grid",
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
                    "type" => "textfield",
                    "class" => "",
                    "heading" => __("Posts", "fenomen"),
                    "param_name" => "posts",
                    "value" => __("4", "fenomen"),
                    "description" => __("Input Posts Num.", "fenomen"),
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __("Pagination", "fenomen"),
                    "param_name" => "pagination",
                    "value" => "",
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => __("Pagination Type", "fenomen"),
                    "param_name" => "pagination_type",
                    "dependency" => array(
                        "element" => "pagination",
                        "value" => "true"
                    ),
                    "value" => array(
                        "Classic" => "classic",
                        "Numeric" => "numeric",
                        "Show More" => "more",
                        "Scroll" => "scroll"
                    ),
                    "std" => "numeric",
                    "group" => __("General", "fenomen")
                ),
                array(
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __("Filter", "fenomen"),
                    "description" => __("Enable Filter.", "fenomen"),
                    "param_name" => "filter",
                    "value" => "",
                    "dependency" => array(
                        "element" => "pagination",
                        "value_not_equal_to" => "true"
                    ),
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
                    "type" => "checkbox",
                    "class" => "",
                    "heading" => __("Carousel Mode", "fenomen"),
                    "description" => __("Switch to Carousel.", "fenomen"),
                    "param_name" => "carousel",
                    "value" => "",
                    "dependency" => array(
                        "element" => "pagination",
                        "value_not_equal_to" => "true"
                    ),
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
    add_action('vc_before_init', 'fenomen_extension_grid_integrateWithVC');
}


?>