<?php
/**
 * Plugin Name: Definition Tool 
 * Plugin URI: http://www.methodsofamodernmale.com/
 * Version: 1.0
 * Author: Reea
 */
class TinyMCE_Definition_Tool {
	
    /**
    * Constructor. Called when the plugin is initialised.
    */
    function __construct() {
        if ( is_admin() ) {
            add_action( 'init', array(  $this, 'setup_tinymce_definition_tool' ) );
        }
    }
    
    
    /**
    * Check if the current user can edit Posts or Pages, and is using the Visual Editor
    * If so, add some filters so we can register our plugin
    */
    function setup_tinymce_definition_tool() {

        // Check if the logged in WordPress User can edit Posts or Pages
        // If not, don't register our TinyMCE plugin

        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
            return;
        }

        // If not, don't register our TinyMCE plugin
        if ( get_user_option( 'rich_editing' ) !== 'true' ) {
            return;
        }

        // Setup some filters
        add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
        add_filter( 'mce_buttons', array( &$this, 'add_tinymce_toolbar_button' ) );

    }
    
    /**
    * Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
    *
    * @param array $plugin_array Array of registered TinyMCE Plugins
    * @return array Modified array of registered TinyMCE Plugins
    */
    function add_tinymce_plugin( $plugin_array ) {
        $plugin_array['definition_tool'] = plugin_dir_url( __FILE__ ) . 'js/tinymce-definition-tool.js?v1.4';
        return $plugin_array;
    }

    function add_tinymce_toolbar_button( $buttons ) {
        array_push( $buttons, '|', 'definition_tool' );
        return $buttons;
    }
}

$TinyMCE_Definition_Tool = new TinyMCE_Definition_Tool;


function definition_tool_shortcode($atts = [], $content = null, $tag = '') {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    $shortcodeAtts = shortcode_atts([
        'text' => 'WordPress.org',
    ], $atts, $tag);
 
    $html = '';
    $html .= '<span class="definition-tooltip">';
    $html .= $content;
        $html .= '<span class="definition-tooltip-actual">' . esc_html__( $shortcodeAtts['text'], 'wporg' ) . '</span>';
    $html .= '</span>';
    
    return $html;
}
 
function definition_tool_shortcode_init() {
    add_shortcode('definition_tool', 'definition_tool_shortcode');
}
 
add_action('init', 'definition_tool_shortcode_init');


function definition_tool_styles_and_scripts() {
    wp_enqueue_style( 'definition-tool-style', plugins_url( '/css/definition-tooltip.css' , __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'definition_tool_styles_and_scripts' );