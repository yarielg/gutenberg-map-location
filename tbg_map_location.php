<?php
/*
*
* @package yariko


Plugin Name:  Map location login
Plugin URI:   https://thomasgbennett.com/
Description:  This plugin implement the map logic
Version:      1.0.0
Author:       Bennet Group (Yariel Gordillo)
Author URI:   https://thomasgbennett.com/
Tested up to: 6.1.0
Text Domain:  tbg_map_location
Domain Path:  /languages
*/

defined('ABSPATH') or die('You do not have access, sally human!!!');

define ( 'MLP_PLUGIN_VERSION', '1.0.0');

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php') ){
    require_once  dirname( __FILE__ ) . '/vendor/autoload.php';
}

define('MLP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define('MLP_PLUGIN_URL' , plugin_dir_url(  __FILE__  ) );
define('MLP_ADMIN_URL' , get_admin_url() );
define('MLP_PLUGIN_DIR_BASENAME' , dirname(plugin_basename(__FILE__)) );
define('MLP_PLUGIN_DIR' , __DIR__ );

//include the helpers
include 'inc/util/helpers.php';
if( class_exists( 'Mlp\\Inc\\Init' ) ){
    register_activation_hook( __FILE__ , array('Mlp\\Inc\\Base\\Activate','activate') );
    Mlp\Inc\Init::register_services();

}





