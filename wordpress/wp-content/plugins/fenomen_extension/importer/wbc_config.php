<?php

/**
 * Create configs for importing demos
 * 
 * @package WordPress
 * @subpackage Fenomen
 * @since Fenomen 1.0
 */

if (!function_exists('fenomen_extension_wbc_extended_example')) {
    add_action('wbc_importer_after_content_import', 'fenomen_extension_wbc_extended_example', 10, 2);
    function fenomen_extension_wbc_extended_example($demo_active_import, $demo_directory_path)
    {
        reset($demo_active_import);
        $current_key = key($demo_active_import);
        
        /************************************************************************
         * Import slider(s) for the current demo being imported
         *************************************************************************/
        if (class_exists('RevSlider')) {
            $wbc_sliders_array = array(
                'Fenomen' => array(
                    'fm_slider.zip'
                ),
                'Classic' => array(
                    'fm_slider_classic.zip'
                )
            );
            if (isset($demo_active_import[$current_key]['directory']) && !empty($demo_active_import[$current_key]['directory']) && array_key_exists($demo_active_import[$current_key]['directory'], $wbc_sliders_array)) {
                $wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
                
                if (is_array($wbc_slider_import)) {
                    foreach ($wbc_slider_import as $slider_zip) {
                        if (!empty($slider_zip) && file_exists($demo_directory_path . $slider_zip)) {
                            $slider = new RevSlider();
                            $slider->importSliderFromPost(true, true, $demo_directory_path . $slider_zip);
                        }
                    }
                } else {
                    if (file_exists($demo_directory_path . $wbc_slider_import)) {
                        $slider = new RevSlider();
                        $slider->importSliderFromPost(true, true, $demo_directory_path . $wbc_slider_import);
                    }
                }
            }
        }
        
        /************************************************************************
         * Setting Menus
         *************************************************************************/
         
		$wbc_menu_array = array( 'Fenomen', 'Classic' );
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
			$header_menu = get_term_by( 'name', 'Header Menu', 'nav_menu' );
			$header_second_menu = get_term_by( 'name', 'Header Second Menu', 'nav_menu' );
			$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

			set_theme_mod( 'nav_menu_locations', array(
				'header-menu' => $header_menu->term_id,
				'header-second-menu' => $header_second_menu->term_id,
				'footer-menu' => $footer_menu->term_id
			));
		}
    }
}

?>