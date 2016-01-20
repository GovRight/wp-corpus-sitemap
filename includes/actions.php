<?php

add_action('wp_ajax_wpcs_create', 'wpcs_create_action');
function wpcs_create_action() {
    try {
        wpcs_create();
    } catch(Exception $e) {
        die(json_encode(array('error' => $e->getMessage())));
    }
    if(wpcs_is_sitemap_in_gxmls()) {
        wpcs_remove_from_gxmls();
        wpcs_add_to_gxmls();
    }
    die();
}

add_action('wp_ajax_wpcs_remove', 'wpcs_remove_action');
function wpcs_remove_action() {
    wpcs_remove_from_gxmls();
    wpcs_remove();
    die();
}

add_action('wp_ajax_wpcs_gxmls_add', 'wpcs_gxmls_add_action');
function wpcs_gxmls_add_action() {
    wpcs_add_to_gxmls();
    die();
}

add_action('wp_ajax_wpcs_gxmls_remove', 'wpcs_gxmls_remove_action');
function wpcs_gxmls_remove_action() {
    wpcs_remove_from_gxmls();
    die();
}
