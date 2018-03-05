<?php
/**
 * Eveny Theme Customizer
 *
 * @package Eveny
 *
 * Contents:
 * ==============================
 * 1. CUSTOM PANELS
 * 2. CUSTOMIZER SECTIONS
 * 3. EVENY THEME COLORS SETTINGS
 * 4. FRONT PAGE SECTIONS SETTINGS
 * 5. CUSTOM HEADER SETTINGS
 * 6. CONTACT PAGE TEMPLATE SETTINGS
 * 7. SANITIZATION FUNCTIONS
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function eveny_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Adds textarea support to the theme customizer
	 */
	class Customize_Textarea_Control extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	            <label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}

	/**
	 * --------------------------------------------------------------------
	 * 1. Custom Panels
	 * --------------------------------------------------------------------
	 */

	// Front Page Panel
	$wp_customize->add_panel( 'front_page_settings', array(
		'priority'       => 120,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Front Page Options', 'eveny' ),
		'description'    => __( 'Settings for Front Page Template', 'eveny' )
	) );

	// Front Page Colors
	$wp_customize->add_panel( 'front_page_colors', array(
		'priority'       => 120,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => __( 'Front Page Colors', 'eveny' ),
		'description'    => __( 'Colors for Front Page Template', 'eveny' )
	) );


	// Replace header image section
	$wp_customize->get_section( 'header_image' )->panel    = 'front_page_settings';
	$wp_customize->get_section( 'header_image' )->title    = __( 'Custom Header Image', 'eveny' );
	$wp_customize->get_section( 'header_image' )->priority = 1;

	// Rename Colors Section
	$wp_customize->get_section( 'colors' )->title = __( 'Theme Colors', 'eveny' );

	// Add Logo and Favicon field
	$wp_customize->add_section( 'eveny_logo_section' , array(
		'title'    => __( 'Logo and Favicon', 'themeslug' ),
		'priority' => 30
	) );

	// Events Archive section
	$wp_customize->add_section( 'events_archive', array(
		'title'       => __( 'Events Archive', 'eveny' ),
		'description' => __( 'Enter number of events you want to display on Events Archive page template', 'eveny' ),
		'priority'    => 50
	) );

	// Register the setting for logo
	$wp_customize->add_setting( 'eveny_logo_setting', array(
		'sanitize_callback' => 'eveny_sanitize_image',
	));

	// Add the control for logo
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'eveny_logo',
				array(
					'label'    => __( 'Upload Logo', 'eveny' ),
					'section'  => 'eveny_logo_section',
					'settings' => 'eveny_logo_setting',
				)
	    )
	);

	// Register the setting for Retina logo
	$wp_customize->add_setting( 'eveny_retina_logo_setting', array(
		'sanitize_callback' => 'eveny_sanitize_image',
	));

	// Add the control for Retina logo
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'eveny_retina_logo',
				array(
					'label'       => __( 'Upload Retina Logo', 'eveny' ),
					'section'     => 'eveny_logo_section',
					'description' => __( 'Upload double size image for retina displays. JPEG, GIF or PNG image, recommended up to 500KB', 'eveny' ),
					'settings'    => 'eveny_retina_logo_setting'
				)
	    )
	);

	// Register the setting for favicon
	$wp_customize->add_setting( 'eveny_favicon_setting', array(
		'sanitize_callback' => 'eveny_sanitize_image',
	));

	// Add the control for favicon
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'eveny_favicon', array(
		'label'    => __( 'Upload a Favicon', 'eveny' ),
		'section'  => 'eveny_logo_section',
		'settings' => 'eveny_favicon_setting',
    ) ) );


	/**
	 * -------------------------------------------------------------------
	 * 2. Customizer Sections
	 * -------------------------------------------------------------------
	 */

	// Blog Archive layout section
	$wp_customize->add_section( 'blog_archive_layout', array(
		'title'    => __( 'Archives layout settings', 'eveny' )
	) );

	// Custom Header on / off
	$wp_customize->add_section( 'custom_header_settings', array(
		'title'       => __( 'Custom Header Settings', 'eveny' ),
		'description' => __( 'Turn Custom Header on / off', 'eveny' ),
		'priority'    => 0,
		'panel'       => 'front_page_settings'
	) );

	// Custom header options section
	$wp_customize->add_section( 'custom_header_options', array(
		'title'       => __( 'Custom Header Content', 'eveny' ),
		'description' => __( 'This is displayed on Front Page Template as top header on custom header image background', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// Custom header options section
	$wp_customize->add_section( 'select_sections', array(
		'title'       => __( 'Sections Order Settings', 'eveny' ),
		'description' => __( 'Here you can select which sections will display on Front Page Template and in what order.', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// Events section content options section
	$wp_customize->add_section( 'events_content_sections', array(
		'title'       => __( 'Events Section Settings', 'eveny' ),
		'description' => __( 'Here you can enter content for Events section', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// News section content options section
	$wp_customize->add_section( 'news_content_sections', array(
		'title'       => __( 'News Section Settings', 'eveny' ),
		'description' => __( 'Here you can enter content for News section', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// Gallery section content options section
	$wp_customize->add_section( 'gallery_content_sections', array(
		'title'       => __( 'Gallery Section Settings', 'eveny' ),
		'description' => __( 'Here you can choose category for Gallery section that is displayed on Front Page and enter content for that section', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// Page section content options section
	$wp_customize->add_section( 'page_content_sections', array(
		'title'       => __( 'Page Section Settings', 'eveny' ),
		'description' => __( 'Here you can choose which page content will be displayed', 'eveny' ),
		'panel'       => 'front_page_settings'
	) );

	// Contact Page Settings Section
	$wp_customize->add_section( 'contact_content_section' , array(
		'title' => __( 'Contact Page Settings', 'eveny' ),
	) );

	// Footer Copyright
	$wp_customize->add_section( 'eveny_footer_copyright' , array(
		'title' => __( 'Footer Copyright Text', 'themeslug' ),
	) );

	/* Front Page Color Sections */
	$wp_customize->add_section( 'eveny_header_colors', array(
		'title' => __( 'Custom Header Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	$wp_customize->add_section( 'eveny_albums_colors', array(
		'title' => __( 'Albums Section Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	$wp_customize->add_section( 'eveny_events_colors', array(
		'title' => __( 'Events Section Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	$wp_customize->add_section( 'eveny_news_colors', array(
		'title' => __( 'News Section Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	$wp_customize->add_section( 'eveny_gallery_colors', array(
		'title' => __( 'Gallery Section Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	$wp_customize->add_section( 'eveny_page_colors', array(
		'title' => __( 'Page Section Colors', 'eveny' ),
		'panel' => 'front_page_colors'
	) );

	/**
	 * -------------------------------------------------------------------
	 * 3. Eveny Theme Colors
	 * -------------------------------------------------------------------
	 */

	// Main Theme Color
	$wp_customize->add_setting( 'eveny_main_color', array(
		'default'           => '#fb4f00',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_main_color', array(
		'label'    => __( 'Main Theme Color', 'eveny' ),
		'section'  => 'colors',
		'settings' => 'eveny_main_color',
	) ) );


	/**
	 * -------------------------------------------------------------------
	 * 3.1 Front Page Sections Colors
	 * -------------------------------------------------------------------
	 */

	/**
	 * 3.1.1 Custom Header
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_header_bg_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_header_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_header_colors',
		'settings' => 'eveny_header_bg_color',
	) ) );

	// Headings color
	$wp_customize->add_setting( 'eveny_header_headings_color', array(
		'default'           => '#282828',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_header_headings_color', array(
		'label'    => __( 'Heading Color', 'eveny' ),
		'section'  => 'eveny_header_colors',
		'settings' => 'eveny_header_headings_color',
	) ) );

	// Button color
	$wp_customize->add_setting( 'eveny_header_button_color', array(
		'default'           => 'transparent',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_header_button_color', array(
		'label'    => __( 'Button Color', 'eveny' ),
		'section'  => 'eveny_header_colors',
		'settings' => 'eveny_header_button_color',
	) ) );

	// Button text color
	$wp_customize->add_setting( 'eveny_header_button_text_color', array(
		'default'           => '#282828',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_header_button_text_color', array(
		'label'    => __( 'Button Text Color', 'eveny' ),
		'section'  => 'eveny_header_colors',
		'settings' => 'eveny_header_button_text_color',
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'eveny_header_secondary_color', array(
		'default'           => '#282828',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_header_secondary_color', array(
		'label'    => __( 'Text Color', 'eveny' ),
		'section'  => 'eveny_header_colors',
		'settings' => 'eveny_header_secondary_color',
	) ) );


	/**
	 * 3.1.2 Section Albums
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_albums_bg_color', array(
		'default'           => '#ededed',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_albums_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_albums_colors',
		'settings' => 'eveny_albums_bg_color',
	) ) );

	// Headings color
	$wp_customize->add_setting( 'eveny_albums_headings_color', array(
		'default'           => '#363636',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_albums_headings_color', array(
		'label'    => __( 'Headings Color', 'eveny' ),
		'section'  => 'eveny_albums_colors',
		'settings' => 'eveny_albums_headings_color',
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'eveny_albums_secondary_color', array(
		'default'           => '#cdcdcd',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_albums_secondary_color', array(
		'label'    => __( 'Secondary Color', 'eveny' ),
		'section'  => 'eveny_albums_colors',
		'settings' => 'eveny_albums_secondary_color',
	) ) );


	/**
	 * 3.1.3 Section Events
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_events_bg_color', array(
		'default'           => '#282828',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_events_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_events_colors',
		'settings' => 'eveny_events_bg_color',
	) ) );

	// Headings color
	$wp_customize->add_setting( 'eveny_events_headings_color', array(
		'default'           => '#fff',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_events_headings_color', array(
		'label'    => __( 'Heading Color', 'eveny' ),
		'section'  => 'eveny_events_colors',
		'settings' => 'eveny_events_headings_color',
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'eveny_events_secondary_color', array(
		'default'           => '#909090',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_events_secondary_color', array(
		'label'    => __( 'Secondary Color', 'eveny' ),
		'section'  => 'eveny_events_colors',
		'settings' => 'eveny_events_secondary_color',
	) ) );


	/**
	 * 3.1.4 Section News
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_news_bg_color', array(
		'default' => '#fff',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_news_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_news_colors',
		'settings' => 'eveny_news_bg_color',
	) ) );

	// Headings color
	$wp_customize->add_setting( 'eveny_news_headings_color', array(
		'default' => '#363636',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_news_headings_color', array(
		'label'    => __( 'Heading Color', 'eveny' ),
		'section'  => 'eveny_news_colors',
		'settings' => 'eveny_news_headings_color',
	) ) );

	// Post Meta color
	$wp_customize->add_setting( 'eveny_news_meta_color', array(
		'default' => '#6d6d6d',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_news_meta_color', array(
		'label'    => __( 'Post Meta Color', 'eveny' ),
		'section'  => 'eveny_news_colors',
		'settings' => 'eveny_news_meta_color',
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'eveny_news_secondary_color', array(
		'default' => '#666666',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_news_secondary_color', array(
		'label'    => __( 'Secondary Color', 'eveny' ),
		'section'  => 'eveny_news_colors',
		'settings' => 'eveny_news_secondary_color',
	) ) );


	/**
	 * 3.1.5 Section Gallery
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_gallery_bg_color', array(
		'default'           => '#dcf2f9',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_gallery_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_gallery_colors',
		'settings' => 'eveny_gallery_bg_color',
	) ) );

	// Headings color
	$wp_customize->add_setting( 'eveny_gallery_headings_color', array(
		'default'           => '#363636',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_gallery_headings_color', array(
		'label'    => __( 'Heading Color', 'eveny' ),
		'section'  => 'eveny_gallery_colors',
		'settings' => 'eveny_gallery_headings_color',
	) ) );

	// Secondary color
	$wp_customize->add_setting( 'eveny_gallery_secondary_color', array(
		'default'           => '#666666',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_gallery_secondary_color', array(
		'label'    => __( 'Secondary Color', 'eveny' ),
		'section'  => 'eveny_gallery_colors',
		'settings' => 'eveny_gallery_secondary_color',
	) ) );


	/**
	 * 3.1.6 Section Page Content
	 */

	// Background color
	$wp_customize->add_setting( 'eveny_page_bg_color', array(
		'default' => '#fff',
		'sanitize_callback' => 'eveny_sanitize_color'
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_page_bg_color', array(
		'label'    => __( 'Background Color', 'eveny' ),
		'section'  => 'eveny_page_colors',
		'settings' => 'eveny_page_bg_color',
	) ) );


	/**
	 * -------------------------------------------------------------------
	 * 4. Front Page Sections Settings
	 * -------------------------------------------------------------------
	 */

	// Front Page Section 1 Picker
	$wp_customize->add_setting( 'eveny_section_one', array(
		'default' => 'albums',
		'sanitize_callback' => 'eveny_sanitize_section_one'
	) );

	$wp_customize->add_control( 'eveny_section_one', array(
		'label'    => __( 'Section One Content', 'eveny' ),
		'priority' => 1,
		'section'  => 'select_sections',
		'type'     => 'select',
		'choices'  => array(
			'albums'  => __( 'Albums slider', 'eveny' ),
			'events'  => __( 'Events slider', 'eveny' ),
			'news'    => __( 'Latest news', 'eveny' ),
			'gallery' => __( 'Gallery', 'eveny' ),
			'page'	  => __( 'Page Content', 'eveny' ),
			'disable' => __( 'Disable Section', 'eveny' )
		),
	) );

	// Front Page Section 2 Picker
	$wp_customize->add_setting( 'eveny_section_two', array(
		'default' => 'events',
		'sanitize_callback' => 'eveny_sanitize_section_two'
	) );

	$wp_customize->add_control( 'eveny_section_two', array(
		'label'    => __( 'Section Two Content', 'eveny' ),
		'priority' => 1,
		'section'  => 'select_sections',
		'type'     => 'select',
		'choices'  => array(
			'albums'  => __( 'Albums slider', 'eveny' ),
			'events'  => __( 'Events slider', 'eveny' ),
			'news'    => __( 'Latest news', 'eveny' ),
			'gallery' => __( 'Gallery', 'eveny' ),
			'page'	  => __( 'Page Content', 'eveny' ),
			'disable' => __( 'Disable Section', 'eveny' )
		),
	) );

	// Front Page Section 3 Picker
	$wp_customize->add_setting( 'eveny_section_three', array(
		'default' => 'news',
		'sanitize_callback' => 'eveny_sanitize_section_three'
	) );

	$wp_customize->add_control( 'eveny_section_three', array(
		'label'    => __( 'Section Three Content', 'eveny' ),
		'priority' => 1,
		'section'  => 'select_sections',
		'type'     => 'select',
		'choices'  => array(
			'albums'  => __( 'Albums slider', 'eveny' ),
			'events'  => __( 'Events slider', 'eveny' ),
			'news'    => __( 'Latest news', 'eveny' ),
			'gallery' => __( 'Gallery', 'eveny' ),
			'page'	  => __( 'Page Content', 'eveny' ),
			'disable' => __( 'Disable Section', 'eveny' )
		),
	) );

	// Front Page Section 4 Picker
	$wp_customize->add_setting( 'eveny_section_four', array(
		'default' => 'gallery',
		'sanitize_callback' => 'eveny_sanitize_section_four'
	) );

	$wp_customize->add_control( 'eveny_section_four', array(
		'label'    => __( 'Section Four Content', 'eveny' ),
		'priority' => 1,
		'section'  => 'select_sections',
		'type'     => 'select',
		'choices'  => array(
			'albums'  => __( 'Albums slider', 'eveny' ),
			'events'  => __( 'Events slider', 'eveny' ),
			'news'    => __( 'Latest news', 'eveny' ),
			'gallery' => __( 'Gallery', 'eveny' ),
			'page'	  => __( 'Page Content', 'eveny' ),
			'disable' => __( 'Disable Section', 'eveny' )
		),
	) );

	// Front Page Section 5 Picker
	$wp_customize->add_setting( 'eveny_section_five', array(
		'default' => 'page',
		'sanitize_callback' => 'eveny_sanitize_section_five'
	) );

	$wp_customize->add_control( 'eveny_section_five', array(
		'label'    => __( 'Section Five Content', 'eveny' ),
		'priority' => 1,
		'section'  => 'select_sections',
		'type'     => 'select',
		'choices'  => array(
			'albums'  => __( 'Albums slider', 'eveny' ),
			'events'  => __( 'Events slider', 'eveny' ),
			'news'    => __( 'Latest news', 'eveny' ),
			'gallery' => __( 'Gallery', 'eveny' ),
			'page'	  => __( 'Page Content', 'eveny' ),
			'disable' => __( 'Disable Section', 'eveny' )
		),
	) );

	/**
	 * Section Events Content Settings
	 */

	// Event Category Selector
	$wp_customize->add_setting( 'events_category_selected', array(
		'default' => 'default',
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'events_category_selected', array(
		'label'    => __( 'Choose Events Category', 'eveny' ),
		'priority' => 1,
		'section'  => 'events_content_sections',
		'type'     => 'select',
		'choices'  => eveny_select_event_category()
	) );

	// Events section title
	$wp_customize->add_setting( 'events_section_title', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'events_section_title', array(
		'label'    => __( 'Events section title', 'eveny' ),
		'priority' => 1,
		'section'  => 'events_content_sections',
		'type'     => 'text',
	) );

	// Events section text
	$wp_customize->add_setting( 'events_section_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'events_section_text', array(
		'label'    => __( 'Events section text', 'eveny' ),
		'priority' => 2,
		'section'  => 'events_content_sections',
		'type'     => 'textarea',
	) );

	// Events section button text
	$wp_customize->add_setting( 'events_section_button_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'events_section_button_text', array(
		'label'    => __( 'Events section button text', 'eveny' ),
		'priority' => 3,
		'section'  => 'events_content_sections',
		'type'     => 'text',
	) );

	// Events section button URL
	$wp_customize->add_setting( 'events_section_button_url', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'events_section_button_url', array(
		'label'    => __( 'Events section button URL', 'eveny' ),
		'priority' => 4,
		'section'  => 'events_content_sections',
		'type'     => 'text',
	) );


	/**
	 * Section News Content Settings
	 */

	// Event Category Selector
	$wp_customize->add_setting( 'news_category_selected', array(
		'default' => 'default',
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'news_category_selected', array(
		'label'    => __( 'Choose News Category', 'eveny' ),
		'priority' => 1,
		'section'  => 'news_content_sections',
		'type'     => 'select',
		'choices'  => eveny_select_news_category()
	) );

	// News section title
	$wp_customize->add_setting( 'news_section_title', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'news_section_title', array(
		'label'    => __( 'News section title', 'eveny' ),
		'priority' => 1,
		'section'  => 'news_content_sections',
		'type'     => 'text',
	) );

	// News section text
	$wp_customize->add_setting( 'news_section_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'news_section_text', array(
		'label'    => __( 'News section text', 'eveny' ),
		'priority' => 2,
		'section'  => 'news_content_sections',
		'type'     => 'textarea',
	) );

	// News section button text
	$wp_customize->add_setting( 'news_section_button_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'news_section_button_text', array(
		'label'    => __( 'News section button text', 'eveny' ),
		'priority' => 3,
		'section'  => 'news_content_sections',
		'type'     => 'text',
	) );

	/**
	 * Section Gallery controls
	 */

	// Number of Gallery items
	$wp_customize->add_setting( 'eveny_gallery_items', array(
		'default'           => 6,
		'sanitize_callback' => 'eveny_number_sanitize'
	) );

	$wp_customize->add_control( 'eveny_gallery_items', array(
		'label'    => __( 'Number of gallery items to display', 'eveny' ),
		'priority' => 2,
		'section'  => 'gallery_content_sections',
		'type'     => 'number'
	) );

	// Gallery Category Selector
	$wp_customize->add_setting( 'gallery_category_selected', array(
		'default' => 'default',
		'sanitize_callback' => 'eveny_text_sanitize'
	) );

	$wp_customize->add_control( 'gallery_category_selected', array(
		'label'    => __( 'Choose Gallery Category', 'eveny' ),
		'priority' => 1,
		'section'  => 'gallery_content_sections',
		'type'     => 'select',
		'choices'  => eveny_select_gallery_category(),
	) );

	// Gallery section title
	$wp_customize->add_setting( 'gallery_section_title', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'gallery_section_title', array(
		'label'    => __( 'Gallery section title', 'eveny' ),
		'priority' => 0,
		'section'  => 'gallery_content_sections',
		'type'     => 'text',
	) );

	// Gallery section text
	$wp_customize->add_setting( 'gallery_section_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'gallery_section_text', array(
		'label'    => __( 'Gallery section text', 'eveny' ),
		'priority' => 2,
		'section'  => 'gallery_content_sections',
		'type'     => 'textarea',
	) );

	// Gallery section button text
	$wp_customize->add_setting( 'gallery_section_button_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'gallery_section_button_text', array(
		'label'    => __( 'Gallery section button text', 'eveny' ),
		'priority' => 3,
		'section'  => 'gallery_content_sections',
		'type'     => 'text',
	) );

	/**
	 * Section Page Content Settings
	 */

	// Page Content Selector
	$wp_customize->add_setting( 'page_content_select', array(
		'default'           => 'default',
		'sanitize_callback' => 'eveny_sanitize_page'
	));

	$wp_customize->add_control( 'page_content_select', array(
		'label'    => __( 'Choose Page', 'eveny' ),
		'priority' => 1,
		'section'  => 'page_content_sections',
		'type'     => 'select',
		'choices'  => eveny_select_pages(),
	) );


	/**
	 * -------------------------------------------------------------------
	 * 5. Custom Header Settings
	 * -------------------------------------------------------------------
	 */

	// Custom header on / off
	$wp_customize->add_setting( 'custom_header_enable', array(
		'default' => 0,
		'sanitize_callback' => 'eveny_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'custom_header_enable', array(
		'label'    => __( 'Enable Custom Header', 'eveny' ),
		'priority' => 0,
		'section'  => 'custom_header_settings',
		'type'     => 'checkbox'
	) );

	// Custom header title
	$wp_customize->add_setting( 'custom_header_title', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'custom_header_title', array(
		'label'    => __( 'Custom header title', 'eveny' ),
		'priority' => 1,
		'section'  => 'custom_header_options',
		'type'     => 'text',
	) );

	// Custom header text
	$wp_customize->add_setting( 'custom_header_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'custom_header_text', array(
		'label'    => __( 'Custom header text', 'eveny' ),
		'priority' => 2,
		'section'  => 'custom_header_options',
		'type'     => 'textarea',
	) );

	// Custom header button text
	$wp_customize->add_setting( 'custom_header_button_text', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	) );

	$wp_customize->add_control( 'custom_header_button_text', array(
		'label'    => __( 'Custom header button text', 'eveny' ),
		'priority' => 3,
		'section'  => 'custom_header_options',
		'type'     => 'text',
	) );

	// Custom header button link
	$wp_customize->add_setting( 'custom_header_button_link', array(
		'sanitize_callback' => 'eveny_text_sanitize',
	));

	$wp_customize->add_control( 'custom_header_button_link', array(
		'label'    => __( 'Custom header button link', 'eveny' ),
		'priority' => 4,
		'section'  => 'custom_header_options',
		'type'     => 'text',
	));

	// Blog Archive layout setting
	$wp_customize->add_setting( 'blog_archive_layout', array(
		'default' => 'default',
		'sanitize_callback' => 'eveny_text_sanitize'
	) );

	$wp_customize->add_control( 'blog_archive_layout', array(
		'label'    => __( 'Choose layout for Blog archive', 'eveny' ),
		'priority' => 1,
		'section'  => 'blog_archive_layout',
		'type'     => 'select',
		'choices'  => array(
			'default' => __( 'Default', 'eveny' ),
			'grid'    => __( 'Grid', 'eveny' )
		),
	) );


	/**
	 * -------------------------------------------------------------------
	 * 6. Contact Page Template Settings
	 * -------------------------------------------------------------------
	 */

	// Register the setting for contact map
	$wp_customize->add_setting( 'eveny_contact_map_setting', array(
		'sanitize_callback' => 'eveny_sanitize_checkbox',
	));

	// Add the control for contact map
	$wp_customize->add_control('eveny_contact_map', array(
		'label'   	=> __('Disable contact page map', 'eveny'),
		'priority'  => 1,
		'section' 	=> 'contact_content_section',
		'settings'  => 'eveny_contact_map_setting',
		'type'    	=> 'checkbox',
	));

	// Register the setting for contact form captcha
	$wp_customize->add_setting( 'eveny_contact_captcha_setting', array(
		'default' => 1,
		'sanitize_callback' => 'eveny_sanitize_checkbox',
	));

	// Add the control for contact form captcha
	$wp_customize->add_control('eveny_contact_form_captcha', array(
		'label'   	=> __('Disable contact form captcha', 'eveny'),
		'priority'  => 2,
		'section' 	=> 'contact_content_section',
		'settings'  => 'eveny_contact_captcha_setting',
		'type'    	=> 'checkbox',
	));

	// Register the setting for contact form
	$wp_customize->add_setting( 'eveny_contact_form_setting', array(
		'sanitize_callback' => 'eveny_sanitize_checkbox',
	));

	// Add the control for contact form
	$wp_customize->add_control('eveny_contact_form', array(
		'label'   	=> __('Disable contact form', 'eveny'),
		'priority'  => 2,
		'section' 	=> 'contact_content_section',
		'settings'  => 'eveny_contact_form_setting',
		'type'    	=> 'checkbox',
	));

	// Register the setting for contact email address
	$wp_customize->add_setting( 'eveny_contact_mail_address', array(
		'default'			=> get_option( 'admin_email' ),
		'sanitize_callback' => 'eveny_textarea_sanitize',
	));

	// Add the control for contact email address
	$wp_customize->add_control('eveny_contact_mail_address', array(
		'label'     => __('Contact Email address', 'eveny'),
		'priority'  => 4,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_contact_mail_address',
		'type'      => 'text',
	) );

	// Register the setting for contact email address
    $wp_customize->add_setting( 'eveny_contact_contact_map_api', array(
        'default'           => '',
        'sanitize_callback' => 'eveny_textarea_sanitize',
    ));

    // Add the control for contact email address
    $wp_customize->add_control( 'eveny_contact_contact_map_api', array(
        'label'       => __( 'Google Maps API key', 'eveny' ),
        'description' => __( '<a href="https://themeskingdom.com/knowledge-base/how-to-generate-google-maps-api-key/" target="_blank">How to create API key?</a>', 'eveny' ),
        'priority'    => 4,
        'section'     => 'contact_content_section',
        'settings'    => 'eveny_contact_contact_map_api',
        'type'        => 'text',
    ));

	// Register the setting for contact map color
	$wp_customize->add_setting( 'eveny_contact_map_color_picker_setting', array(
		'default' => '',
		'sanitize_callback' => 'eveny_sanitize_map_color',
	));

	// Add the control for contact map color
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'eveny_map_color', array(
		'label'      => __( 'Map Color', 'eveny' ),
		'priority'   => 4,
		'section'    => 'contact_content_section',
		'settings'   => 'eveny_contact_map_color_picker_setting',
	) ) );

	// Register the setting for map x coordinate
	$wp_customize->add_setting( 'eveny_contact_map_x_coord', array(
		'sanitize_callback' => 'eveny_textarea_sanitize',
	));

	// Add the control for contact map x coordinate
	$wp_customize->add_control('eveny_x_coord', array(
		'label'     => __('Map X coordinate', 'eveny'),
		'priority'  => 4,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_contact_map_x_coord',
		'type'      => 'text',
	) );

	// Register the setting for map y coordinate
	$wp_customize->add_setting( 'eveny_contact_map_y_coord', array(
		'sanitize_callback' => 'eveny_textarea_sanitize',
	));

	// Add the control for contact map y coordinate
	$wp_customize->add_control('eveny_y_coord', array(
		'label'     => __('Map Y coordinate', 'eveny'),
		'priority'  => 5,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_contact_map_y_coord',
		'type'      => 'text',
	) );

	// Register the setting for map zoom factor
	$wp_customize->add_setting( 'eveny_map_zoom_factor_setting', array(
		'sanitize_callback' => 'eveny_textarea_sanitize',
	));

	// Add the control for contact map zoom factor
	$wp_customize->add_control('eveny_zoom_factor', array(
		'label'     => __('Map zoom factor', 'eveny'),
		'priority'  => 6,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_map_zoom_factor_setting',
		'type'      => 'select',
		'choices'   => eveny_map_zoom_select()
	) );

	// Register the setting for map marker
	$wp_customize->add_setting( 'eveny_map_marker_setting', array(
		'sanitize_callback' => 'eveny_textarea_sanitize',
	));

	// Add the control for contact map marker
	$wp_customize->add_control('eveny_map_marker', array(
		'label'     => __('Map marker title', 'eveny'),
		'priority'  => 7,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_map_marker_setting',
		'type'      => 'text',
	) );

	// Register the setting for map type
	$wp_customize->add_setting( 'eveny_map_type_setting', array(
		'default' => 'choice-2',
		'sanitize_callback' => 'eveny_sanitize_map_type',
	));

	// Add the control for contact map type
	$wp_customize->add_control('eveny_map_type', array(
		'label'     => __('Map type', 'eveny'),
		'priority'  => 8,
		'section'   => 'contact_content_section',
		'settings'  => 'eveny_map_type_setting',
		'type'      => 'select',
        'choices'   => array(
        	'choice-1' => 'HYBRID',
        	'choice-2' => 'ROADMAP',
        	'choice-3' => 'SATELLITE',
        	'choice-4' => 'TERRAIN'
	) ) );

	// Register the setting map marker icon
	$wp_customize->add_setting( 'eveny_map_marker_icon_setting', array(
		'sanitize_callback' => 'eveny_sanitize_image'
	));

	// Add the control for map marker icon
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'eveny_map_icon',
	        array(
				'label'    => __( 'Upload Marker Icon (80 x 90 px)', 'eveny' ),
				'section'  => 'contact_content_section',
				'settings' => 'eveny_map_marker_icon_setting',
	       )
	    )
	);

	/**
	 * ------------------------------------------------------------------------
	 * 7. Footer Copyright Text
	 * ------------------------------------------------------------------------
	 */

	// Footer Copyright Text
	$wp_customize->add_setting( 'footer_copyright_text', array(
		'sanitize_callback' => 'eveny_textarea_sanitize',
	) );

	$wp_customize->add_control( 'footer_copyright_text', array(
		'label'    => __( 'Enter Copyright text', 'eveny' ),
		'priority' => 2,
		'section'  => 'eveny_footer_copyright',
		'type'     => 'textarea',
	) );

	/**
	 * ------------------------------------------------------------------------
	 * 8. Events Archive Settings
	 * ------------------------------------------------------------------------
	 */
	// Number of events to show
	$wp_customize->add_setting( 'events_archive_numbers', array(
		'sanitize_callback' => 'eveny_number_sanitize',
		'default'           => 10
	) );

	$wp_customize->add_control( 'events_archive_numbers', array(
		'label'    => __( 'Number of events', 'eveny' ),
		'priority' => 2,
		'section'  => 'events_archive',
		'type'     => 'number',
	) );


}
add_action( 'customize_register', 'eveny_customize_register' );

/**
 * ----------------------------------------------------------------------
 * 8. Sanitization Functions
 * ----------------------------------------------------------------------
 */

// Sanitize Page selection
function eveny_number_sanitize( $number ) {
	if ( !is_numeric($number) ) {
		$number = 10;
	}
	return $number;
}

// Sanitize Page selection
function eveny_sanitize_page( $page ) {
	if ( 'default' == $page ) {
		$page = 'default';
	}
	return $page;
}

// Sanitize the Header Title, Text and Button.
function eveny_text_sanitize( $header_text ) {
	if ( '' == $header_text ) {
		$header_text = '';
	}
	return $header_text;
}

/**
 * Sanitize the value of textbox.
 *
 * @param string $textarea_content.
 * @return string $textarea_content.
 */
function eveny_textarea_sanitize( $textarea_content ) {
	if ( $textarea_content == '' ) {
		$textarea_content = '';
	}
	return $textarea_content;
}

/**
 * Sanitize the value of checkboxes.
 *
 * @param string $logo_image.
 * @return string $logo_image.
 */
function eveny_sanitize_checkbox( $checkbox ) {
    if ( $checkbox == 1 ) {
        return 1;
    } else {
        return '';
    }
}

/**
 * Sanitize the Google Map Type picker
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (left | fullwidth | right).
 */
function eveny_sanitize_sidebar( $sidebar ) {
	if ( ! in_array( $sidebar, array( 'left', 'right', 'fullwidth' ) ) ) {
		$sidebar = 'left';
	}
	return $sidebar;
}

/**
 * Sanitize the Google Map Type picker
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (choice-1 | choice-2 | choice-3 | choice-4).
 */
function eveny_sanitize_map_type( $map_type ) {
	if ( ! in_array( $map_type, array( 'choice-1', 'choice-2', 'choice-3', 'choice-4') ) ) {
		$map_type = 'choice-2';
	}
	return $map_type;
}

/**
 * Sanitize colors
 */
function eveny_sanitize_map_color( $hex, $default = '' ) {
	if ( of_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 * Sanitize the value of Logo image.
 *
 * @param string $logo_image.
 * @return string $logo_image.
 */
function eveny_sanitize_image( $logo_image ) {
		$length_url = strlen( $logo_image) ;
		$image_ext = substr( $logo_image, $length_url-4, $length_url );
		$ext_array = array( '.png', '.jpg', '.gif' );

		if ( in_array( $image_ext, $ext_array) ) {
			$logo_image = $logo_image;
		}
		else $logo_image = '';

		return $logo_image;
}

/**
 * --------------------------------------------------------------------
 * SECTIONS SANITIZE
 * --------------------------------------------------------------------
 */

/**
 * Sanitize the Home Page Section One.
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (albums | events | archive | gallery | disable).
 */
function eveny_sanitize_section_one( $section_one ) {
	if ( ! in_array( $section_one, array( 'albums', 'events', 'news', 'gallery', 'page', 'disable' ) ) ) {
		$section_one = 'albums';
	}
	return $section_one;
}

/**
 * Sanitize the Home Page Section Two.
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (albums | events | news | gallery | disable).
 */
function eveny_sanitize_section_two( $section_two ) {
	if ( ! in_array( $section_two, array( 'albums', 'events', 'news', 'gallery', 'page', 'disable' ) ) ) {
		$section_two = 'events';
	}
	return $section_two;
}

/**
 * Sanitize the Home Page Section Three.
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (albums | events | archive | gallery | disable).
 */
function eveny_sanitize_section_three( $section_three ) {
	if ( ! in_array( $section_three, array( 'albums', 'events', 'news', 'gallery', 'page', 'disable' ) ) ) {
		$section_three = 'news';
	}
	return $section_three;
}

/**
 * Sanitize the Home Page Section Four.
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (albums | events | archive | gallery | disable).
 */
function eveny_sanitize_section_four( $section_four ) {
	if ( ! in_array( $section_four, array( 'albums', 'events', 'news', 'gallery', 'page', 'disable' ) ) ) {
		$section_four = 'gallery';
	}
	return $section_four;
}

/**
 * Sanitize the Home Page Section Five.
 *
 * @param string $ratio Aspect ratio.
 * @return string Filtered ratio (albums | events | archive | gallery | disable).
 */
function eveny_sanitize_section_five( $section_five ) {
	if ( ! in_array( $section_five, array( 'albums', 'events', 'news', 'gallery', 'page', 'disable' ) ) ) {
		$section_five = 'page';
	}
	return $section_five;
}

/**
 * Sanitize colors
 */
function eveny_sanitize_color( $hex, $default = '' ) {
	if ( eveny_of_validate_hex( $hex ) ) {
		return $hex;
	}
	return $default;
}

/**
 *
 * @param    string    Color in hexidecimal notation. "#" may or may not be prepended to the string.
 * @return   bool
 *
 */

function eveny_of_validate_hex( $hex ) {
	$hex = trim( $hex );
	/* Strip recognized prefixes. */
	if ( 0 === strpos( $hex, '#' ) ) {
		$hex = substr( $hex, 1 );
	}
	elseif ( 0 === strpos( $hex, '%23' ) ) {
		$hex = substr( $hex, 3 );
	}
	/* Regex match. */
	if ( 0 === preg_match( '/^[0-9a-fA-F]{6}$/', $hex ) ) {
		return false;
	}
	else {
		return true;
	}
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function eveny_customize_preview_js() {
	wp_enqueue_script( 'eveny_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'eveny_customize_preview_js' );
