<?php
/*
Plugin Name: GovRight Corpus Sitemap
Plugin URI: https://github.com/GovRight/wp-corpus-sitemap
Description: A plugin to help you to create a sitemap containing article urls from a law document related to your site. Check <a href="https://github.com/GovRight/wp-corpus-sitemap">the plugin Github page</a> for details and instructions.
Version: 1.0.3
Author: GovRight
Author URI: http://govright.org/
License: MIT
GitHub Plugin URI: https://github.com/GovRight/wp-corpus-sitemap
GitHub Branch: master
*/

require_once(__DIR__ . '/includes/utils.php');
require_once(__DIR__ . '/includes/enqueue.php');
require_once(__DIR__ . '/includes/actions.php');
require_once(__DIR__ . '/includes/settings.php');

require_once(__DIR__ . '/includes/handlers/wpcs.interface.php');
