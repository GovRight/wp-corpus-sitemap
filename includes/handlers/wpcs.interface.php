<?php

abstract class WpcsInterface {

    protected $_api_url;
    protected $_law_slug;
    protected $_url_template;

    function __construct($api_url, $law_slug, $url_template) {
        $this->_api_url = $api_url;
        $this->_law_slug = $law_slug;
        $this->_url_template = $url_template;
    }

    protected function _flatten($nodes, &$array) {
        if(!empty($nodes)) {
            foreach($nodes as $n) {
                $array[] = $n;
                if(!empty($n->nodes)) {
                    $this->_flatten($n->nodes, $array);
                }
            }
        }
    }

    protected function _build_xml($nodes) {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="http://participation.wp/wp-content/plugins/google-sitemap-generator/sitemap.xsl"?>
            <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        var_dump(count($nodes));
        foreach($nodes as $node) {
            if(empty($node->abstract)) {
                $url = $xml->addChild('url');
                $url->addChild('loc', str_replace(array('{id}', '{slug}'), array($node->id, $node->slug), $this->_url_template));
                $url->addChild('changefreq', 'monthly');
                $url->addChild('priority', '0.9');
            }
        }
        return $xml->asXML();
    }
}
