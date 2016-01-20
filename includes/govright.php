<?php
/**
 * Base menu item definition
 */

// Check if it has been already defined
if (empty($GLOBALS['admin_page_hooks']['govright_options'])) {
    add_menu_page( 'GovRight', 'GovRight', 'manage_options', 'govright_options');

    // Hide parent element duplicate in submenu
    add_action('admin_head', function() {
        echo '<style>
            #toplevel_page_govright_options .wp-first-item {
                display: none;
            }
        </style>';
    });

    // Fix parent element link
    add_action('admin_print_footer_scripts', function() {
        echo '<script>
            (function($) {
                var href = $("#toplevel_page_govright_options .wp-first-item").parent()
                    .next()
                    .find("a")
                    .prop("href");
                $("#toplevel_page_govright_options > a").prop("href", href);
            } (jQuery));
        </script>';
    });
}