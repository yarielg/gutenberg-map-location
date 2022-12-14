<?php

/*
*
* @package Yariko
*
*/

namespace Mlp\Inc\Base;

class Settings{

    public function register(){

        /**
         * Add the shortcode to render the map with areas and locations
         */
        add_shortcode( 'mlp_map', array($this, 'render_map') );

        /**
         * Add the map gutenberg block
         */
        //add_action( 'init', array($this, 'map_block') );


    }



    /*function map_block(){
        register_block_type( MLP_PLUGIN_DIR
        );
    }*/

    /*function render_editor($attr, $content){
    }*/

    function render_map($atts){
        $a = shortcode_atts( array(
            'cols' => 4,
        ), $atts );

        wp_enqueue_script('main-js', MLP_PLUGIN_URL  . '/assets/js/main.js' ,array('jquery', 'leaflet-js', 'area-js'),'v-' . strtotime(date('h:i:s')), true);

        wp_localize_script( 'main-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php'), 'plugin_url' => MLP_PLUGIN_URL, 'state' => 'California']);

        return mlp_template(MLP_PLUGIN_PATH . 'templates/map.php' , array());
    }

}