<?php
/**
 * Get an app-specific config value
 */
function wpcs_config($option) {
    $config = require(__DIR__ . '/config.php');
    return $config[$option];
}

/**
 * Get sitemap path
 * @return string
 */
function wpcs_get_path() {
    $path = wpcs_config('xml_path');
    $app = get_option('wpcs_app');
    $law = get_option('wpcs_law_slug');
    if(!$app || !$law) {
        return '';
    }
    return $path . '/' . $app . '-' . $law . '.xml';
}

function wpcs_get_url() {
    $path = wpcs_get_path();
    return str_replace(ABSPATH, get_site_url() . '/', $path);
}

/**
 * Check if sitemap exists
 * @return bool
 */
function wpcs_sitemap_exists() {
    $path = wpcs_get_path();
    return file_exists($path);
}

function wpcs_remove($path = null) {
    if(!$path) {
        $path = wpcs_get_path();
    }
    unlink($path);
    wpcs_remove_from_gxmls();
}

function wpcs_build() {
    $app = get_option('wpcs_app');
    $class = ucfirst($app);

    $api_url = wpcs_config('corpus_api_url');
    $law_slug = get_option('wpcs_law_slug');
    $url_template = get_option('wpcs_url_template');
    $is_gxmls_active = is_plugin_active(wpcs_config('gxmls_dep'));

    if($api_url && $law_slug && $url_template) {
        require __DIR__ . '/handlers/' . $app . '.class.php';
        $handler = new $class($api_url, $law_slug, $url_template, $is_gxmls_active);
        return $handler->build();
    } else {
        return '';
    }
}

function wpcs_create($path = null) {
    if(!$path) {
        $path = wpcs_get_path();
    }
    if(!is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    $content = wpcs_build();
    $path = wpcs_get_path();
    file_put_contents($path, $content);
}

function wpcs_is_sitemap_in_gxmls() {
    return get_option('wpcs_gxmls_connected') === '1';
}

function wpcs_add_to_gxmls() {
    if(!wpcs_is_sitemap_in_gxmls()) {
        update_option('wpcs_gxmls_connected', '1');
    }
}

function wpcs_remove_from_gxmls() {
    if(is_plugin_active(wpcs_config('gxmls_dep'))) {
        update_option('wpcs_gxmls_connected', '0');
    }
}
