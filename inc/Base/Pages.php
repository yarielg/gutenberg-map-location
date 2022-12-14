<?php

/*
*
* @package Yariko
*
*/

namespace Mlp\Inc\Base;

class Pages{

    public function register(){

        //Set a new page under Media menu in Parent Dashboard Website
        //add_action('admin_menu', array($this,'wrn_add_request_page'));
        //CPT
        //add_action( 'init', array($this,'cptui_register_my_cpts_bg_resources') );
        //Taxonomies
        //add_action( 'init', array($this, 'cptui_register_my_taxes_bgs_categories') );
    }

    /*function wrn_add_request_page(){
        $user = wp_get_current_user();
        if(get_current_blog_id() == 1  && in_array( 'administrator', $user->roles )){
            add_submenu_page( 'upload.php', 'Requests', 'Requests', 'manage_options', 'wrn_request_media', function(){
                $myListTable = new Request_Media_Table();
                echo '<div class="wrap"><h2>Media Requests</h2>';
                $myListTable->prepare_items();
                $myListTable->display();
                echo '</div>';
            } );

            add_submenu_page( 'upload.php', 'Settings', 'Settings', 'manage_options', 'wrn_settings_media', function(){
                if(isset($_POST['max_admin_approval_submit'])){
                    if($_POST['max_admin_approval'] > 0){
                        wrn_update_option_parent('wrn_max_admin_approval',$_POST['max_admin_approval']);
                    }else{
                        echo '<div class="error notice"><p>Error, No negative number are allowed</p></div>';
                    }
                }
                echo '<div class="wrap"><h2>Settings Requests</h2>';
                echo '<br>';
                echo '<hr>';
                echo '<br>';
                echo '<form action="upload.php?page=wrn_settings_media" method="post">';
                echo '<label for="max_admin_approval"> Define the max of admins that must approved a media </label>';
                echo '<input id="max_admin_approval" type="number" name="max_admin_approval" value="'.wrn_get_option_parent('wrn_max_admin_approval').'">';
                echo '<br><br><br>';
                echo '<input id="max_admin_approval_submit" min=0 type="submit" name="max_admin_approval_submit" value="Update Settings">';
                echo '</form>';
                echo '</div>';
            } );
        }
    }*/


    

}
?>