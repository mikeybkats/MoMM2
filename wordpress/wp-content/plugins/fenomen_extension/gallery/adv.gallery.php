<?php

 
/**
 * Add custom options to admin meda panel (for gallery shortcode)
 * 
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

add_action('print_media_templates',
function ()
{

    // define your backbone template;
    // the "tmpl-" prefix is required,
    // and your input field should have a data-setting attribute
    // matching the shortcode name

?>
  <script type="text/html" id="tmpl-fm-gallery-atts">
    <label class="setting">
      <span><?php
    _e('Navigation', 'fenomen'); ?></span>
      <select data-setting="navigation">
        <option value="">Default (set in Admin)</option>
        <option value="true">On</option>
        <option value="false">Off</option>
      </select>
    </label>
    <label class="setting">
      <span><?php
    _e('Pagination', 'fenomen'); ?></span>
      <select data-setting="pg_type">
        <option value="">Default (set in Admin)</option>
        <option value="thumbs">Thumbs</option>
        <option value="thumbs_wide">Thumbs: Wide</option>
        <option value="dots">Dots</option>
        <option value="none">Off</option>
      </select>
    </label>
  </script>

  <script>

    jQuery(document).ready(function(){
		
      // add your shortcode attribute and its default value to the
      // gallery settings list; $.extend should work as well...

      _.extend(wp.media.gallery.defaults, {
        pg_type: 'default_param'
      });
	  
      // merge default gallery settings template with yours

      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
        template: function(view){
          return wp.media.template('gallery-settings')(view)
               + wp.media.template('fm-gallery-atts')(view);
        }
      });

    });

  </script>
  <?php
});



/**
 * Creete own gallery shortcode
 * 
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */
 
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'fenomen_extension_gallery_shortcode');
function fenomen_extension_gallery_shortcode($attr)
{
    $post = get_post();
    static $instance = 0;
    $instance++;
    if (!empty($attr['ids'])) {

        if (empty($attr['orderby'])) {
            $attr['orderby'] = 'post__in';
        }

        $attr['include'] = $attr['ids'];
    }

    $output = apply_filters('post_gallery', '', $attr, $instance);
    if ($output != '') {
        return $output;
    }
    
    $html5 = current_theme_supports('html5', 'gallery');
    $atts = shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post ? $post->ID : 0,
        'itemtag' => $html5 ? 'figure' : 'div',
        'icontag' => $html5 ? 'div' : 'div',
        'captiontag' => $html5 ? 'figcaption' : 'div',
        'columns' => 3,
        'size' => 'thumbnail',
        'hover_type' => '',
        'single_post_hover' => '1',
        'include' => '',
        'exclude' => '',
        'link' => '',
        'navigation' => '',
        'pagination' => '',
        'pg_type' => 'thumbs',
    ) , $attr, 'gallery');
	
    $id = intval($atts['id']) . $instance;
	
    if (!empty($atts['include'])) {
        $_attachments = get_posts(array(
            'include' => $atts['include'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
        $attachments = array();
        foreach($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (!empty($atts['exclude'])) {
        $attachments = get_children(array(
            'post_parent' => $id,
            'exclude' => $atts['exclude'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    } else {
        $attachments = get_children(array(
            'post_parent' => $id,
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ));
    }

    if (empty($attachments)) {
        return '';
    }

    if (is_feed()) {
        $output = "\n";
        foreach($attachments as $att_id => $attachment) {
            $output.= wp_get_attachment_link($att_id, $atts['size'], true) . "\n";
        }

        return $output;
    }

    $itemtag = tag_escape($atts['itemtag']);
    $captiontag = tag_escape($atts['captiontag']);
    $icontag = tag_escape($atts['icontag']);
    $valid_tags = wp_kses_allowed_html('post');
    if (!isset($valid_tags[$itemtag])) {
        $itemtag = 'dl';
    }

    if (!isset($valid_tags[$captiontag])) {
        $captiontag = 'dd';
    }

    if (!isset($valid_tags[$icontag])) {
        $icontag = 'dt';
    }

    $columns = intval($atts['columns']);
    $itemwidth = $columns > 0 ? floor(100 / $columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
    $selector = "gallery-{$instance}";
    $gallery_style = '';

	
    if (apply_filters('use_default_gallery_style', !$html5)) {
        if (!empty($atts['pagination']) && 'true' === $atts['pagination']) {
            $owlnav = "#gallery-{$id} .owl-nav [class*=owl-]{margin-top:-31px;}";
        }
    }

    $size_class = sanitize_html_class($atts['size']); 
    
    if (!$atts['navigation']) {
        $atts['navigation'] = fenomen_get_field('gallery_navigation_type');
    } 
    
    if (!$atts['pg_type']) {
        $atts['pg_type'] = fenomen_get_field('gallery_pagination_type');
    } 

    if ($atts['pg_type'] === 'thumbs_wide') {
        $pagin_type = "thumbs-wide";
    } elseif ($atts['pg_type'] === 'thumbs') {
            $pagin_type = "thumbs";
    } elseif ($atts['pg_type'] === 'dots') {
            $pagin_type = "dots";
    } 
    
    $image_gallery_thumbnail = '';
    $image_gallery_thumbnail[0] = '';

    if ($atts['pg_type'] === "dots") {
        $pagin_class = " gpag-type-dots";
        $data_thumbs = "";
        $data_thumb = "";    
    } elseif ($atts['pg_type'] === "thumbs") {
        $pagin_class = " gpag-type-thumbs";
        $data_thumbs = " data-thumbs=\"true\"";
        $data_thumb = " data-thumb=\"{$image_gallery_thumbnail[0]}\"";
    } elseif ($atts['pg_type'] === "thumbs_wide") {
        $pagin_class = " gpag-type-thumbs-wide";
        $data_thumbs = " data-thumbs=\"true\"";
        $data_thumb = " data-thumb=\"{$image_gallery_thumbnail[0]}\"";
    } else {
        $pagin_class = "";
        $data_thumbs = "";
        $data_thumb = "";        
    }
    
    if ($atts['pg_type'] === 'none') {
        $data_dots = " data-dots=\"false\"";
    } else {
        $data_dots = "";
    }

    if ($atts['navigation'] === 'true') {
        $data_nav = " data-nav=\"true\"";
    } else {
        $data_nav = "";
    }

    $single_post_thumbnail_start = '<div class="fm-gallery"><div class="fm-gallery-wrapper">';

    $gallery_div = "{$single_post_thumbnail_start}<div id=\"gallery-{$id}\" class=\"owl-carousel owl-gallery-slider galleryid-{$id}{$pagin_class} gallery-columns-{$columns} gallery-size-{$size_class} gallery-zoom\" data-id=\"{$id}\" data-columns=\"{$columns}\"{$data_dots}{$data_thumbs}{$data_nav}>";

    $gallery_id = $id;

    $output = apply_filters('gallery_style', $gallery_style . $gallery_div);
    $i = 0;
    $len = count($attachments);
    foreach($attachments as $id => $attachment) {
        $attr = (trim($attachment->post_excerpt)) ? array(
            'aria-describedby' => "$selector-$id"
        ) : '';
        $image_output = wp_get_attachment_image($id, $atts['size'], false, $attr);
        $image_meta = wp_get_attachment_metadata($id);
        $image_gallery_thumbnail = wp_get_attachment_image_src($id, 'thumbnail');
        $image_gallery_link_full = wp_get_attachment_image_src($id, 'full');
        $orientation = '';
        if (isset($image_meta['height'], $image_meta['width'])) {
            $orientation = ($image_meta['height'] > $image_meta['width']) ? 'portrait' : 'landscape';
        }

        if ($i > 0) {
            $owl_slider_item_next = " owl-slider-item-next";
        } else {
            $owl_slider_item_next = "";
        }

        if ($atts['pg_type'] === "thumbs" or $atts['pg_type'] === "thumbs_wide") {
            $data_thumb = " data-thumb=\"{$image_gallery_thumbnail[0]}\"";
        } else {
            $data_thumb = "";
        }

        $output.= "<{$itemtag} class=\"owl-slider-item{$owl_slider_item_next}\"{$data_thumb}>";

        $output.= '<div class="hover-type"><a data-effect="mfp-zoom-in" data-caption="' . get_post(get_post_thumbnail_id($post->ID))->post_excerpt . '" class="thumbnail-zoom" href="' . $image_gallery_link_full[0] . '">' . $image_output . '<div class="mask"></div><div class="loop"><div class="loop-wrapper"><i class="fa fa-search-plus"></i></div></div></a></div>';

        $output.= "</{$itemtag}>";
        if (!$html5 && $columns > 0 && ++$i % $columns == 0) {
            $output.= '';
        }
    }

    if (!$html5 && $columns > 0 && $i % $columns !== 0) {
        $output.= "";
    }

    $output.= '</div></div></div>';

    return $output;
}

?>