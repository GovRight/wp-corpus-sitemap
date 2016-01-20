<?php

class Revtracker extends WpcsInterface {
    function build() {
        $response = wp_remote_get($this->_api_url . '/laws/compare?slug=' . get_option('wpcs_law_slug'));
        if(is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }
        $data = json_decode($response['body']);
        $nodes = array();
        $this->_flatten($data->nodes, $nodes);
        $nodes = array_map(function($n) {
            return !empty($n->left) ? $n->left : $n->right;
        }, $nodes);
        return $this->_build_xml($nodes);
    }
}
