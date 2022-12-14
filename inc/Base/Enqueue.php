<?php

/*
*
* @package Yariko
*
*/

namespace Mlp\Inc\Base;

class Enqueue{

    public function register(){

        add_action( 'wp_enqueue_scripts',  array($this,'enqueue_frontend'));

        add_action('init', array($this, 'gutenberg_blocks'));

    }


    /**
     * Enqueueing the main scripts with all the javascript logic that this plugin offer
     */
    function enqueue_frontend(){
        wp_enqueue_style('main-css', MLP_PLUGIN_URL . '/assets/css/main.css');
        wp_enqueue_style('leaflet-css', MLP_PLUGIN_URL . '/assets/css/leaflet.css');

        wp_enqueue_script('leaflet-js', MLP_PLUGIN_URL  . '/assets/js/leaflet.js' ,array('jquery'),'1.0', false);
        wp_enqueue_script('area-js', MLP_PLUGIN_URL  . '/assets/js/area.js' ,array(),'1.0', true);

    }

    function gutenberg_blocks(){

        wp_register_script('map-location-js', MLP_PLUGIN_URL . 'build/index.js', array('wp-blocks', 'wp-editor'));

        register_block_type('tbg/map-location', array(
            'editor_script' => 'map-location-js'
        ));
    }

}