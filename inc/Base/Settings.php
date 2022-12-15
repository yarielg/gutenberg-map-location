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
         * Add location CPT
         */
        add_action( 'init', array($this, 'add_location_cpt') );

        /**
         * Add Taxonomy Area
         */
        add_action( 'init', array($this, 'add_area_taxonomy') );

        /**
         * Add Metabox
         */
        add_action("add_meta_boxes", array($this, 'add_custom_map_meta_box'));
        add_action("save_post", array($this, 'save_custom_map_meta_box'), 10, 3);

        /**
         * Override the default template hierchachy from the plugin
         */
        add_filter( 'template_include', array($this, 'override_templates') );

    }

    function override_templates($template ){
        // For ID 93, load in file by using it's PATH (not URL)
        if( is_tax('area') ){
            $template = MLP_PLUGIN_PATH . 'templates/area.php';
        }

        // ALWAYS return the $template, or *everything* will be blank.
        return $template;
    }

    function save_custom_map_meta_box($post_id, $post, $update){
        if (isset($_POST["area_selected"])){
            update_post_meta($post_id, "post_area_ids", serialize($_POST["area_selected"]));
        }

        if (isset($_POST["area_location_selected"])){
            update_post_meta($post_id, "post_location_ids", serialize($_POST["area_location_selected"]));
        }

    }

    function add_custom_map_meta_box(){
        add_meta_box( 'map_location', 'Map widget', array($this, 'map_meta_box_callback'), array('page', 'post'), 'advanced','high');
    }

    function map_meta_box_callback(){

        global $post;

        $states = get_terms( array(
            'taxonomy' => 'area',
            'hide_empty' => false,
            'parent' => 0
        ) );

        $selected_areas = get_post_meta($post->ID, 'post_area_ids', true);

        if($selected_areas){
            $selected_areas = unserialize($selected_areas);
        }else{
            $selected_areas = [];
        }

        foreach ($states as $state){

            $state->selected = false;
            if(in_array($state->term_id, $selected_areas)) {
                $state->selected = true;
            }

            $cities = get_terms( 'area', array(
                'parent' => $state->term_id, 'hide_empty' => false
            ));

            foreach ($cities as $city){
                $locations = get_posts(array(
                    'post_type' => 'location',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'area',
                            'field' => 'term_id',
                            'terms' => $city->term_id
                        )
                    )
                ));

                $locations_selected = get_post_meta($post->ID, 'post_location_ids', true);

                if($locations_selected){
                    $locations_selected = unserialize($locations_selected);
                }else{
                    $locations_selected = [];
                }

                foreach($locations as $location){
                    $location->selected = false;
                    if(in_array($location->ID, $locations_selected)) {
                        $location->selected = true;
                    }
                }

                $city->locations = count($locations) > 0 ? $locations : [];
                $city->parent_name = $state->name;
            }

            $state->cities = $cities;
        }


        echo mlp_template(MLP_PLUGIN_PATH . 'templates/cpt-metabox.php' , array('states' => $states, 'selected_areas' => $selected_areas  ));
    }

    function add_area_taxonomy(){

            /**
             * Taxonomy: Areas.
             */

            $labels = [
                "name" => esc_html__( "Areas", "twentytwentythree" ),
                "singular_name" => esc_html__( "Area", "twentytwentythree" ),
                "menu_name" => esc_html__( "Areas", "twentytwentythree" ),
                "all_items" => esc_html__( "All Areas", "twentytwentythree" ),
                "edit_item" => esc_html__( "Edit Area", "twentytwentythree" ),
                "view_item" => esc_html__( "View Area", "twentytwentythree" ),
                "update_item" => esc_html__( "Update Area name", "twentytwentythree" ),
                "add_new_item" => esc_html__( "Add new Area", "twentytwentythree" ),
                "new_item_name" => esc_html__( "New Area name", "twentytwentythree" ),
                "parent_item" => esc_html__( "Parent Area", "twentytwentythree" ),
                "parent_item_colon" => esc_html__( "Parent Area:", "twentytwentythree" ),
                "search_items" => esc_html__( "Search Areas", "twentytwentythree" ),
                "popular_items" => esc_html__( "Popular Areas", "twentytwentythree" ),
                "separate_items_with_commas" => esc_html__( "Separate Areas with commas", "twentytwentythree" ),
                "add_or_remove_items" => esc_html__( "Add or remove Areas", "twentytwentythree" ),
                "choose_from_most_used" => esc_html__( "Choose from the most used Areas", "twentytwentythree" ),
                "not_found" => esc_html__( "No Areas found", "twentytwentythree" ),
                "no_terms" => esc_html__( "No Areas", "twentytwentythree" ),
                "items_list_navigation" => esc_html__( "Areas list navigation", "twentytwentythree" ),
                "items_list" => esc_html__( "Areas list", "twentytwentythree" ),
                "back_to_items" => esc_html__( "Back to Areas", "twentytwentythree" ),
                "name_field_description" => esc_html__( "The name is how it appears on your site.", "twentytwentythree" ),
                "parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "twentytwentythree" ),
                "slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "twentytwentythree" ),
                "desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "twentytwentythree" ),
            ];


            $args = [
                "label" => esc_html__( "Areas", "twentytwentythree" ),
                "labels" => $labels,
                "public" => true,
                "publicly_queryable" => true,
                "hierarchical" => true,
                "show_ui" => true,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "query_var" => true,
                "rewrite" => [ 'slug' => 'area', 'with_front' => true, ],
                "show_admin_column" => false,
                "show_in_rest" => true,
                "show_tagcloud" => false,
                "rest_base" => "area",
                "rest_controller_class" => "WP_REST_Terms_Controller",
                "rest_namespace" => "wp/v2",
                "show_in_quick_edit" => false,
                "sort" => false,
                "show_in_graphql" => false,
            ];
            register_taxonomy( "area", [ "location" ], $args );
    }

    function add_location_cpt(){

            /**
             * Post Type: Locations.
             */

            $labels = [
                "name" => esc_html__( "Locations", "twentytwentythree" ),
                "singular_name" => esc_html__( "Location", "twentytwentythree" ),
                "menu_name" => esc_html__( "My Locations", "twentytwentythree" ),
                "all_items" => esc_html__( "All Locations", "twentytwentythree" ),
                "add_new" => esc_html__( "Add new", "twentytwentythree" ),
                "add_new_item" => esc_html__( "Add new Location", "twentytwentythree" ),
                "edit_item" => esc_html__( "Edit Location", "twentytwentythree" ),
                "new_item" => esc_html__( "New Location", "twentytwentythree" ),
                "view_item" => esc_html__( "View Location", "twentytwentythree" ),
                "view_items" => esc_html__( "View Locations", "twentytwentythree" ),
                "search_items" => esc_html__( "Search Locations", "twentytwentythree" ),
                "not_found" => esc_html__( "No Locations found", "twentytwentythree" ),
                "not_found_in_trash" => esc_html__( "No Locations found in trash", "twentytwentythree" ),
                "parent" => esc_html__( "Parent Location:", "twentytwentythree" ),
                "featured_image" => esc_html__( "Featured image for this Location", "twentytwentythree" ),
                "set_featured_image" => esc_html__( "Set featured image for this Location", "twentytwentythree" ),
                "remove_featured_image" => esc_html__( "Remove featured image for this Location", "twentytwentythree" ),
                "use_featured_image" => esc_html__( "Use as featured image for this Location", "twentytwentythree" ),
                "archives" => esc_html__( "Location archives", "twentytwentythree" ),
                "insert_into_item" => esc_html__( "Insert into Location", "twentytwentythree" ),
                "uploaded_to_this_item" => esc_html__( "Upload to this Location", "twentytwentythree" ),
                "filter_items_list" => esc_html__( "Filter Locations list", "twentytwentythree" ),
                "items_list_navigation" => esc_html__( "Locations list navigation", "twentytwentythree" ),
                "items_list" => esc_html__( "Locations list", "twentytwentythree" ),
                "attributes" => esc_html__( "Locations attributes", "twentytwentythree" ),
                "name_admin_bar" => esc_html__( "Location", "twentytwentythree" ),
                "item_published" => esc_html__( "Location published", "twentytwentythree" ),
                "item_published_privately" => esc_html__( "Location published privately.", "twentytwentythree" ),
                "item_reverted_to_draft" => esc_html__( "Location reverted to draft.", "twentytwentythree" ),
                "item_scheduled" => esc_html__( "Location scheduled", "twentytwentythree" ),
                "item_updated" => esc_html__( "Location updated.", "twentytwentythree" ),
                "parent_item_colon" => esc_html__( "Parent Location:", "twentytwentythree" ),
            ];

            $args = [
                "label" => esc_html__( "Locations", "twentytwentythree" ),
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",
                "has_archive" => false,
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "can_export" => false,
                "rewrite" => [ "slug" => "location", "with_front" => true ],
                "query_var" => true,
                "supports" => [ "title", "editor", "thumbnail" ],
                "show_in_graphql" => false,
            ];

            register_post_type( "location", $args );

    }


    function render_map($atts){
        $a = shortcode_atts( array(
            '' => 4,
        ), $atts );

        global $post;

        wp_enqueue_script('main-js', MLP_PLUGIN_URL  . '/assets/js/main.js' ,array('jquery', 'leaflet-js', 'area-js'),'v-' . strtotime(date('h:i:s')), true);

        wp_localize_script( 'main-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php'), 'plugin_url' => MLP_PLUGIN_URL, 'state' => 'California']);

        return mlp_template(MLP_PLUGIN_PATH . 'templates/map.php' , array('post' => $post));
    }

}