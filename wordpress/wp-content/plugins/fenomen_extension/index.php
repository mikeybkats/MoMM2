<?php

/*
Plugin Name: Fenomen Shortcodes & Extensions
Plugin URI: 
Description: This plugin contains all shortcodes & extensions for "Fenomen" theme: Shortcodes, Advanced Gallery, Demo Importer...
Version: 2.2
Author: DivEngine
Author URI: http://themeforest.net/user/divengine
Text Domain: fenomen
*/

    require_once( plugin_dir_path( __FILE__ ) . '/shortcodes/index.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/gallery/index.php' ); 
    require_once( plugin_dir_path( __FILE__ ) . '/importer/index.php' ); 
    
?>