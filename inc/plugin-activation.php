<?php
/**
 * TGM PLUGIN ACTIVATION
 *
 * Activates plugins needed by theme
 *
 * @package  Eveny
 */

// Activate TGM Class
require_once get_template_directory() . '/inc/apis/class-tgm-plugin-activation.php';

if ( ! function_exists( 'eveny_register_slider_plugin' ) ) {
    function eveny_register_slider_plugin() {
        $plugins = array(
            array(
                'name'               => 'TK Social Share', // The plugin name
                'slug'               => 'tk-social-share', // The plugin slug (typically the folder name)
                'source'             => 'http://www.themeskingdom.com/public/tk-social-share.zip', // The plugin source
                'required'           => false, // If false, the plugin is onl    y 'recommended' instead of required
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'       => 'http://www.themeskingdom.com', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'               => 'TK Advertising Widget', // The plugin name
                'slug'               => 'tk-advertising-widget', // The plugin slug (typically the folder name)
                'source'             => 'http://www.themeskingdom.com/public/tk-advertising-widget.zip', // The plugin source
                'required'           => false, // If false, the plugin is onl    y 'recommended' instead of required
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'       => 'http://www.themeskingdom.com', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'               => 'TK Shortcodes', // The plugin name
                'slug'               => 'tk-shortcodes', // The plugin slug (typically the folder name)
                'source'             => 'http://www.themeskingdom.com/public/tk-shortcodes.zip', // The plugin source
                'required'           => false, // If false, the plugin is onl    y 'recommended' instead of required
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'       => 'http://www.themeskingdom.com', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'               => 'TK Custom Post Types', // The plugin name
                'slug'               => 'tk-custom-post-types', // The plugin slug (typically the folder name)
                'source'             => get_template_directory() . '/inc/plugins/tk-custom-post-types.zip', // The plugin source
                'required'           => true, // If false, the plugin is onl    y 'recommended' instead of required
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'       => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'                  => 'Flickr Bagdes Widget', // The plugin name
                'slug'                  => 'flickr-badges-widget', // The plugin slug (typically the folder name)
                'source'                => 'https://downloads.wordpress.org/plugin/flickr-badges-widget.1.2.8.zip', // The plugin source
                'required'              => false, // If false, the plugin is onl    y 'recommended' instead of required
                'version'               => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'          => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'               => 'WP Instagram Widget', // The plugin name
                'slug'               => 'wp-instagram-widget', // The plugin slug (typically the folder name)
                'source'             => 'https://downloads.wordpress.org/plugin/wp-instagram-widget.zip', // The plugin source
                'required'           => false, // If false, the plugin is onl    y 'recommended' instead of required
                'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url'       => '', // If set, overrides default API URL and points to an external URL
            ),
            array(
                'name'               => 'Tickera - WordPress Event Ticketing', // The plugin name.
                'slug'               => 'tickera-event-ticketing-system', // The plugin slug (typically the folder name).
                'source'             => 'https://downloads.wordpress.org/plugin/tickera-event-ticketing-system.zip', // The plugin source.
                'required'           => false, // If false, the plugin is only 'recommended' instead of required.
                'external_url'       => 'https://wordpress.org/plugins/tickera-event-ticketing-system/', // If set, overrides default API URL and points to an external URL.
            )
        );

        // If is not active JetPack's module Tiled Galleries
        if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'tiled-galleries' ) ) {
            $tiled_galleries = '';
        }
        else {
            $tiled_galleries = array(
                                    'name'               => 'Tiled Galleries Carousel Without Jetpack', // The plugin name
                                    'slug'               => 'tiled-gallery-carousel-without-jetpack', // The plugin slug (typically the folder name)
                                    'source'             => 'https://downloads.wordpress.org/plugin/tiled-gallery-carousel-without-jetpack.2.1.zip', // The plugin source
                                    'required'           => false, // If false, the plugin is onl    y 'recommended' instead of required
                                    'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                                    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                                    'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                                    'external_url'       => '', // If set, overrides default API URL and points to an external URL
                                );
            // Add widget visibility plugin
            array_push( $plugins, $tiled_galleries );
        }

        $config = array(
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            /*'strings'                         => array(
            'page_title'                      => __( 'Install Required Plugins', 'eveny' ),
            'menu_title'                      => __( 'Install Plugins', 'eveny' ),
            'installing'                      => __( 'Installing Plugin: %s', 'eveny' ), // %1$s = plugin name
            'oops'                            => __( 'Something went wrong with the plugin API.', 'eveny' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'eveny' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'eveny' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'eveny' ), // %1$s = dashboard link
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )*/
        );
        tgmpa( $plugins, $config );
    } // function
    add_action( 'tgmpa_register', 'eveny_register_slider_plugin' );
} // if
