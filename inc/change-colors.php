<?php
/**
 * Change theme colors selected in Theme Options / Customizer
 *
 * @package  Eveny
 */

// FRONT PAGE SECTIONS

// Custom Header
$header_bg_color          = get_theme_mod( 'eveny_header_bg_color', '#fff' );
$header_heading_color     = get_theme_mod( 'eveny_header_headings_color', '#282828' );
$header_button_color      = get_theme_mod( 'eveny_header_button_color');
$header_button_text_color = get_theme_mod( 'eveny_header_button_text_color' );
$header_secondary_color   = get_theme_mod( 'eveny_header_secondary_color' );

// Albums
$albums_bg_color          = get_theme_mod( 'eveny_albums_bg_color' );
$albums_heading_color     = get_theme_mod( 'eveny_albums_headings_color' );
$albums_secondary_color   = get_theme_mod( 'eveny_albums_secondary_color' );

// Events
$events_bg_color          = get_theme_mod( 'eveny_events_bg_color' );
$events_heading_color     = get_theme_mod( 'eveny_events_headings_color' );
$events_secondary_color   = get_theme_mod( 'eveny_events_secondary_color' );

// News
$news_bg_color            = get_theme_mod( 'eveny_news_bg_color' );
$news_heading_color       = get_theme_mod( 'eveny_news_headings_color' );
$news_post_meta_color     = get_theme_mod( 'eveny_news_meta_color' );
$news_secondary_color     = get_theme_mod( 'eveny_news_secondary_color' );

// Gallery
$gallery_bg_color         = get_theme_mod( 'eveny_gallery_bg_color' );
$gallery_heading_color    = get_theme_mod( 'eveny_gallery_headings_color' );
$gallery_post_meta_color  = get_theme_mod( 'eveny_gallery_meta_color' );
$gallery_secondary_color  = get_theme_mod( 'eveny_gallery_secondary_color' );

// Page Content
$page_bg_color            = get_theme_mod( 'eveny_page_bg_color' );

// Theme Colors
$main_color               = get_theme_mod( 'eveny_main_color' );

?>

<style type="text/css">

    /* Theme Colors */
    h1 a:hover,
    h2 a:hover,
    h3 a:hover,
    h4 a:hover,
    h5 a:hover,
    h6 a:hover,
    .post-meta .comments-link a:hover,
    .entry-footer .edit-link a:hover,
    .template-front-events h1 a:hover,
    .gallery-list figcaption a:hover,
    .social-close:hover {
        color: <?php echo esc_attr( $main_color ); ?>;
    }

    .scrollbar .handle,
    .scrollbar {
        background: <?php echo esc_attr( $main_color ); ?>;
    }

    .buy-tickets,
    .nicescroll-cursors {
        background-color: <?php echo esc_attr( $main_color ); ?> 
    }


    /* Front Page Sections Colors */

    /* Custom Header */
    .custom-header {
        background-color: <?php echo esc_attr( $header_bg_color ); ?>;
    }

    .custom-header h1 {
        color: <?php echo esc_attr( $header_heading_color ); ?>;
    }

    .custom-header p {
        color: <?php echo esc_attr( $header_secondary_color ); ?>;
    }

    .custom-header .button {
        background-color: <?php echo esc_attr( $header_button_color ); ?>;
        color: <?php echo esc_attr( $header_button_text_color ); ?>;
    }

    /* Albums */
    .template-front-albums .wp-playlist {
        border-color: <?php echo esc_attr( $albums_bg_color ); ?>;
    }

    .template-front-albums nav aside,
    .template-front-albums .next aside,
    .template-front-albums .prev aside,
    .template-front-albums span.wp-playlist-item-meta.wp-playlist-item-artist,
    .template-front-albums .wp-playlist-item-album {
        color: <?php echo esc_attr( $albums_secondary_color ); ?>;
    }

    .template-front-albums .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-current,
    .mejs-audio .mejs-controls .mejs-time-rail .mejs-time-total,
    .mejs-audio .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total,
    .template-front-albums .mejs-audio .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
        background-color: <?php echo esc_attr( $albums_secondary_color ); ?>;
    }

    .template-front-albums .wp-playlist-item {
        border-color: <?php echo esc_attr( $albums_secondary_color ); ?>;
    }

    .template-front-albums {
        background-color: <?php echo esc_attr( $albums_bg_color ); ?>;
    }

    .template-front-albums .wp-playlist-light .wp-playlist-caption,
    .template-front-albums .mejs-controls button:before,
    .template-front-albums .mejs-container.mejs-audio .mejs-controls .mejs-time span,
    .template-front-albums .wp-playlist .wp-playlist-playing .wp-playlist-caption,
    .template-front-albums .wp-playlist-item-length,
    .template-front-albums .wp-playlist .wp-playlist-playing .wp-playlist-item-length,
    .template-front-albums h3 {
        color: <?php echo esc_attr( $albums_heading_color ); ?>;
    }

    /* Events */
    .template-front-events {
        background-color: <?php echo esc_attr( $events_bg_color ); ?>;
    }

    .template-front-events .template-content h1,
    .template-front-events .template-content .button {
        color: <?php echo esc_attr( $events_heading_color ); ?>;
    }

    .template-front-events .entry-content {
        color: <?php echo esc_attr( $events_secondary_color ); ?>;
    }

    /* News */
    .template-front-news {
        background-color: <?php echo esc_attr( $news_bg_color ); ?>;
    }

    .template-front-news .format-standard h1 a,
    .template-front-news .template-content .button {
        color: <?php echo esc_attr( $news_heading_color ); ?>;
    }

    .template-front-news .news-list .format-standard .post-meta a{
        color: <?php echo esc_attr( $news_post_meta_color ); ?>;
    }

    .template-front-news .news-list .format-standard .entry-content {
        color: <?php echo esc_attr( $news_secondary_color ); ?>;
    }

    /* Page Content */
    .template-front-page {
        background-color: <?php echo esc_attr( $page_bg_color ); ?>;
    }

    /* Gallery */
    .template-front-gallery {
        background-color: <?php echo esc_attr( $gallery_bg_color ); ?>;
    }

    .template-front-gallery .template-content h1,
    .template-front-gallery .template-content .button {
        color: <?php echo esc_attr( $gallery_heading_color ); ?>;
    }

    .template-front-gallery .entry-content {
        color: <?php echo esc_attr( $gallery_secondary_color ); ?>;
    }


</style>

