<?php

/*
*
* @package Yariko
*
*/

namespace Mlp\Inc\Base;

class Ajax{

    public function register(){

        /**
         * Ajax actions
         */
        add_action( 'wp_ajax_get_ffl', array($this,'getFflLocators'));
        add_action( 'wp_ajax_nopriv_get_ffl', array($this,'getFflLocators'));

        add_action( 'wp_ajax_add_ffl', array($this,'addFflLocator'));
        add_action( 'wp_ajax_nopriv_add_ffl', array($this,'addFflLocator'));

    }

    /**
     * Get the ffl dealers
     */
    function getFflLocators(){

        $args = array(
            'post_type' => 'wpsl_stores',
            'post_status'    => 'publish',
            'meta_key'			=> 'certified_kgm_dealer',
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC'
        );

        $locators = get_posts( $args );
        $ffl_locators = array();
        foreach ($locators as $locator){
            array_push($ffl_locators, array(
                    'city' => get_post_meta($locator->ID,'wpsl_city', true),
                    'address' => get_post_meta($locator->ID,'wpsl_address', true),
                    'country' => get_post_meta($locator->ID,'wpsl_country', true),
                    'state' => get_post_meta($locator->ID,'wpsl_state', true),
                    'zip' => get_post_meta($locator->ID,'wpsl_zip', true),
                    'lat' => get_post_meta($locator->ID,'wpsl_lat', true),
                    'lon' => get_post_meta($locator->ID,'wpsl_lng', true),
                    'phone' => get_post_meta($locator->ID,'wpsl_phone', true),
                    'name' => $locator->post_title,
                    'certified' => get_field('certified_kgm_dealer', $locator->ID),
                    'id' => $locator->ID,
                )
            );
        }

        echo json_encode(array('success' => true,'locators' => $ffl_locators));
        wp_die();
    }

    /**
     * Add ffl locator
     */
     function addFflLocator(){

         $country =  isset($_POST['country']) ? $_POST['country'] : '';
         $state =  isset($_POST['state']) ? $_POST['state'] : '';
         $city =  isset($_POST['city']) ? $_POST['city'] : '';
         $zip =  isset($_POST['zip']) ? $_POST['zip'] : '';
         $lat =  isset($_POST['lat']) ? $_POST['lat'] : '';
         $lon =  isset($_POST['lon']) ? $_POST['lon'] : '';
         $name =  isset($_POST['name']) ? $_POST['name'] : '';
         $phone =  isset($_POST['phone']) ? $_POST['phone'] : '';
         $address =  isset($_POST['address']) ? $_POST['address'] : '';

         $post_id = wp_insert_post(array(
             'post_title' => $name,
             'post_status' => 'draft',
             'post_type' => 'wpsl_stores'
         ));

         if(empty($post_id)){
             echo json_encode(array('success' => false));
             wp_die();
         }

        update_post_meta($post_id,'wpsl_country', $country);
        update_post_meta($post_id,'wpsl_state', $state);
        update_post_meta($post_id,'wpsl_city', $city);
        update_post_meta($post_id,'wpsl_zip', $zip);
        update_post_meta($post_id,'wpsl_lat', $lat);
        update_post_meta($post_id,'wpsl_lng', $lon);
        update_post_meta($post_id,'wpsl_phone', $phone);
        update_post_meta($post_id,'wpsl_address', $address);

         echo json_encode(array('success' => true,'post' => $_POST));
         wp_die();
     }
}