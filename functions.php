<?php
/**
 * Eveny functions and definitions
 *
 * @package Eveny
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1315; /* pixels */
}

if ( ! function_exists( 'eveny_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eveny_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on eveny, use a find and replace
	 * to change 'eveny' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'eveny', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * Set image sizes
	 */
	add_image_size( 'gallery-thumb', 692, 99999, false );
	add_image_size( 'gallery-thumb-sinlge', 1316, 99999, false );
	add_image_size( 'album-thumb', 692, 99999, false );
	add_image_size( 'event-thumb', 630, 99999, false );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'eveny' ),
		'social'  => __( 'Social Menu', 'eveny' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'eveny_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // eveny_setup
add_action( 'after_setup_theme', 'eveny_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function eveny_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'eveny' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'eveny' ),
		'id'            => 'footer-widget-1',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'eveny' ),
		'id'            => 'footer-widget-2',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'eveny' ),
		'id'            => 'footer-widget-3',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'eveny' ),
		'id'            => 'footer-widget-4',
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>'
	) );
}
add_action( 'widgets_init', 'eveny_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eveny_scripts() {

	$browser = $_SERVER['HTTP_USER_AGENT'];

	// Google Fonts
    wp_register_style( 'eveny-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:700,300,600,400&subset=cyrillic-ext,greek-ext,latin-ext' );
    wp_enqueue_style( 'eveny-open-sans' );

	// CSS
	wp_register_style( 'eveny-icons', get_template_directory_uri() . '/layouts/icons.css' );
	wp_enqueue_style( 'eveny-icons' );
	wp_register_style( 'tk-fa-icons', get_template_directory_uri() . '/layouts/fontawesome.css' );
	wp_enqueue_style( 'tk-fa-icons' );
	wp_enqueue_style( 'eveny-slick', get_template_directory_uri() . '/js/slick/slick.css' );
	wp_enqueue_style( 'eveny-fancybox-style', get_template_directory_uri() . '/js/fancybox/fancybox.css' );
	wp_enqueue_style( 'eveny-style', get_stylesheet_uri() );

	
	// Scripts
	wp_enqueue_script( 'jquery' );

	if ( ! strpos( $browser, 'MSIE 8.0' ) ) {
		wp_enqueue_script( 'eveny-preloader', get_template_directory_uri() . '/js/load-preloader.js', false, false, false );
	}

	wp_enqueue_script( 'jquery-ui' );
	wp_enqueue_script( 'masonry' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'easing', get_template_directory_uri() . '/js/jquery/jquery.easing-1.3.min.js', false, false, true );
	wp_enqueue_script( 'eveny-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	wp_enqueue_script( 'eveny-nicescroll', get_template_directory_uri()     . '/js/nicescroll/jquery.nicescroll.min.js', false, false, true );
	wp_enqueue_script( 'eveny-sly', get_template_directory_uri()     . '/js/sly-slider/sly-min.js', false, false, true );
	wp_enqueue_script( 'eveny-fancybox', get_template_directory_uri()     . '/js/fancybox/fancybox.pack.js', false, false, true );
	wp_enqueue_script( 'eveny-slick', get_template_directory_uri() . '/js/slick/slick.min.js', false, false, true );
	wp_enqueue_script( 'eveny-call-scripts', get_template_directory_uri() . '/js/common.js', false, false, true );

	// PHP variables in JS files
	$front_page    = '';
	$template_file = esc_attr( get_post_meta( get_the_ID(), '_wp_page_template', true ) );

	if ( 'templates/template-front.php' == $template_file ) {
		$front_page = 'front_page';
	}

	$js_vars = array(
		'front_page'   => $front_page,
		'theme_url'    => get_template_directory_uri(),
		'admin_url'    => admin_url( 'admin-ajax.php' ),
		'nonce'        => wp_create_nonce( 'ajax-nonce' ),
		'captcha'      => esc_attr( get_theme_mod( 'eveny_contact_captcha_setting', 1 ) ),
		'message_info' => __( 'Message Sent!', 'eveny' )
	);

	// Load Google Maps API
	if ( is_page() && 'templates/template-contact.php' == $template_file ) {
		$google_map_api_key = get_theme_mod( 'eveny_contact_contact_map_api' );

        if ( '' != $google_map_api_key ) {
            wp_enqueue_script( 'eveny-google-maps-api', '//maps.google.com/maps/api/js?key=' . $google_map_api_key, false, false, false );
        }
	}

	// Localize php variables
	wp_localize_script( 'eveny-call-scripts', 'js_vars', $js_vars );
	wp_localize_script( 'eveny-preloader', 'js_vars', $js_vars );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'eveny_scripts' );

/* ADMIN SCRIPT AND STYLE */
function eveny_add_admin_scripts() {
	// Admin styles
	wp_register_style( 'eveny-admin-css', get_template_directory_uri() . '/inc/admin/admin.css' );
	wp_enqueue_style( 'eveny-admin-css' );
	wp_enqueue_style( 'wp-color-picker' );

	// Admin scripts
	wp_enqueue_media();
	wp_enqueue_script( 'my-upload' );
	wp_enqueue_script( 'eveny-admin-js', get_template_directory_uri() . '/inc/admin/admin.js' );
}
add_action( 'admin_enqueue_scripts', 'eveny_add_admin_scripts' );

/**
 * Change theme color support
 */

function eveny_change_color() {
	get_template_part( '/inc/change-colors' );
}
add_action( 'wp_head', 'eveny_change_color', '99' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Plugin Activation script
 */
require get_template_directory() . '/inc/plugin-activation.php';

/**
 * Load TK functions
 */
require get_template_directory() . '/inc/tk-functions.php';

/**
 * Load TK Widgets
 */
require get_template_directory() . '/inc/tk-widgets.php';

/**
 * Load Meta Boxes configuration
 */
require get_template_directory() . '/inc/meta-boxes.php';

/**
 * Load Demo Importer
 */
require_once get_template_directory() . '/inc/importer/init.php';

function add_ortimis_post_type() {
	// Events post type
	$labels = array(
		'name'               => __( 'Quotes', 'tkposttypes' ),
		'singular_name'      => __( 'Quote', 'tkposttypes' ),
		'add_new'            => __( 'Add New', 'tkposttypes' ),
		'add_new_item'       => __( 'Add New Quote', 'tkposttypes' ),
		'edit_item'          => __( 'Edit Quote', 'tkposttypes' ),
		'new_item'           => __( 'New Quote', 'tkposttypes' ),
		'all_items'          => __( 'All Quotes', 'tkposttypes' ),
		'view_item'          => __( 'View this Quote', 'tkposttypes' ),
		'search_items'       => __( 'Search Quotes', 'tkposttypes' ),
		'not_found'          => __( 'No Quotes', 'tkposttypes' ),
		'not_found_in_trash' => __( 'No Quotes in Trash', 'tkposttypes' ),
		'parent_item_colon'  => '',
		'menu_name'          => __( 'Quotes', 'tkposttypes' ),
	); // end $labels
	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'query_var'           => true,
		'capability_type'     => 'post',
		'rewrite'             => array( 'slug' => 'quote' ),
		'hierarchical'        => false,
		'menu_position'       => null,
		'has_archive'         => false,
		'menu_icon'           => 'dashicons-format-status',
		'supports'            => array( 'title' ),
	); // end $args
	register_post_type( 'quote', $args );
}

add_action('init', 'add_ortimis_post_type' );

/**
 * Enable ACF 5 early access
 * Requires at least version ACF 4.4.12 to work
 */
define('ACF_EARLY_ACCESS', '5');