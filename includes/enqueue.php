<?php

// Admin assets
function wpcs_add_admin_assets() {
    /*wp_register_style( 'corpus_admin_wpcw_css', plugins_url( 'assets/admin.css', dirname(__FILE__) ), false, '1.0.0' );
    wp_enqueue_style( 'corpus_admin_wpcw_css' );*/

    wp_register_script('corpus_admin_wpcs_script', plugins_url( 'assets/admin.js', dirname(__FILE__) ), array('jquery'), '1.0', true);
    wp_enqueue_script('corpus_admin_wpcs_script');
}
add_action( 'admin_enqueue_scripts', 'wpcs_add_admin_assets' );
