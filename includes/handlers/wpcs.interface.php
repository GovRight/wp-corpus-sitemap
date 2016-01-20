<?php

abstract class WpcsInterface {

    protected $_api_url;
    protected $_law_slug;
    protected $_url_template;
    protected $_is_gxmls_active;

    abstract public function build();

    function __construct($api_url, $law_slug, $url_template, $is_gxmls_active) {
        $this->_api_url = $api_url;
        $this->_law_slug = $law_slug;
        $this->_url_template = $url_template;
        $this->_is_gxmls_active = $is_gxmls_active;
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
        if($this->_is_gxmls_active) {
            $xml_str = '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="' . get_site_url() . '/wp-content/plugins/google-sitemap-generator/sitemap.xsl"?>';
        } else {
            $xml_str = '<?xml version="1.0" encoding="UTF-8"?>';
        }
        $xml_str .= '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';

        $xml = new SimpleXMLElement($xml_str);

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
