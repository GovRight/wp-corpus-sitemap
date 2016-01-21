<?php

add_action('wp_ajax_wpcs_create', 'wpcs_create_action');
function wpcs_create_action() {
    try {
        wpcs_create();
    } catch(Exception $e) {
        die(json_encode(array('error' => $e->getMessage())));
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

add_action('sm_init', function() {
    if(wpcs_is_sitemap_in_gxmls()) {
        add_action('shutdown', function () {
            ob_end_flush();
        });
        ob_start(function ($buffer) {
            $request_uri = trim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

            if ($request_uri === 'sitemap.xml') {
                $xml = simplexml_load_string($buffer);
                $sitemap = $xml->addChild('sitemap');
                $sitemap->addChild('loc', wpcs_get_url());
                $sitemap->addChild('lastmod', date('c', filemtime(wpcs_get_path())));
                return $xml->asXML();
            } else if($request_uri === 'sitemap.html') {
                return str_replace('</table>', '<tr><td><a href="' .wpcs_get_url() . '">' .wpcs_get_url() . '</a></td><td>' . date('Y-m-d H:i', filemtime(wpcs_get_path())) .'</td></tr></table>', $buffer);
            } else {
                return $buffer;
            }
        });
    }
});