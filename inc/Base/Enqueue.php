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

        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_admin' ));

    }

    /**
     * @return void
     * Enqueue admin resources
     */
    function enqueue_admin(){
        wp_enqueue_script('admin-js', MLP_PLUGIN_URL  . '/assets/js/admin.js' ,array('jquery'),'v-' . strtotime(date('h:i:s')), true);

        wp_localize_script( 'admin-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php'), 'plugin_url' => MLP_PLUGIN_URL]);

    }


    /**
     * Enqueueing the main scripts with all the javascript logic that this plugin offer
     */
    function enqueue_frontend(){



        wp_enqueue_style('bootstrap-css', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css");
        wp_enqueue_style('main-css', MLP_PLUGIN_URL . '/assets/css/main.css');
        wp_enqueue_style('leaflet-css', MLP_PLUGIN_URL . '/assets/css/leaflet.css');

        wp_enqueue_script('bootstrap-jquery-js', 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js');
        wp_enqueue_script('bootstrap-bundle-js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js');
        wp_enqueue_script('leaflet-js', MLP_PLUGIN_URL  . '/assets/js/leaflet.js' ,array('jquery'),'1.0', false);
        wp_enqueue_script('area-js', MLP_PLUGIN_URL  . '/assets/js/area.js' ,array(),'1.0', true);

    }


    function gutenberg_blocks(){

        wp_register_script('map-location-js', MLP_PLUGIN_URL . 'build/index.js', array('wp-blocks', 'wp-editor', 'wp-components'));

        $terms = get_terms( array(
            'taxonomy' => 'area',
            'hide_empty' => false,
        ) );

        wp_localize_script( 'map-location-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php'), 'plugin_url' => MLP_PLUGIN_URL, 'areas' => $terms]);

        register_block_type('tbg/map-location', array(
            'editor_script' => 'map-location-js',
            'attributes' => array(
                'categories' => array(
                    'type' => 'array'
                )
            )
        ));
    }


}