<?php
/**
 * Post metaboxes configuration
 *
 * @package  Eveny
 */


$prefix = 'eveny_';
$meta_boxes = array(

    /**
     * Meta boxes for Event post type
     */
    array(
        'id'       => 'events_meta_box',
        'title'    => __( 'Event details', 'eveny' ),
        'pages'    => array( 'event' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            // Display Directions button
            array(
                'name' => __( 'Disable "Directions" display', 'eveny' ),
                'desc' => __( 'Check this box if you do not want to display "Directions" button', 'eveny' ),
                'id'   => $prefix . 'event_directions',
                'type' => 'checkbox',
                'std'  => ''
            ),
            // Event location
            array(
                'name' => __( 'Event location', 'eveny' ),
                'desc' => __( 'Enter event address in this format: Street Nr., Street Name, Country', 'eveny' ),
                'id'   => $prefix . 'event_location',
                'type' => 'text',
                'std'  => ''
            ),
            // Display Buy tickets button
            array(
                'name' => __( 'Show "SOLD OUT" button', 'eveny' ),
                'desc' => __( 'Check this box if you want to show "SOLD OUT" button', 'eveny' ),
                'id'   => $prefix . 'event_buytickets',
                'type' => 'checkbox',
                'std'  => ''
            ),
            // Event buy tickets link
            array(
                'name' => __( 'Buy tickets link', 'eveny' ),
                'desc' => __( 'Enter URL address of page where your tickets can be purchased', 'eveny' ),
                'id'   => $prefix . 'buy_tickets_link',
                'type' => 'text',
                'std'  => ''
            )
        )
    ),
    /***************** end add metabox ***********************/

    /**
     * Meta boxes for Album post type
     */
    array(
        'id'       => 'albums_meta_box',
        'title'    => __( 'Album details', 'eveny' ),
        'pages'    => array( 'album' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            // Event location
            array(
                'name' => __( 'Album Info', 'eveny' ),
                'desc' => __( 'Enter additional album info here (artist, genre...)', 'eveny' ),
                'id'   => $prefix . 'album_info',
                'type' => 'text',
                'std'  => ''
            )
        )
    ),
    /***************** end add metabox ***********************/

    /************************************************************/
    /*                                                          */
    /*   Configuration for post formats:                        */
    /*   video, audio, link and quote                           */
    /*                                                          */
    /************************************************************/
    array(
        'id'       => 'post_format_gallery',
        'title'    => __( 'Slider Fields', 'eveny' ),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'label' => 'Repeatable',
                'name'  => 'Slider Fields',
                'desc'  => '',
                'id'    => $prefix.'repeatable',
                'type'  => 'repeatable'
            )
        )
    ),
    array(
        'id'       => 'post_format_link',
        'title'    => __( 'Link', 'eveny' ),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __( 'Link Text', 'eveny' ),
                'desc' => '',
                'id'   => $prefix . 'link_text',
                'type' => 'textarea',
                'std'  => '',
                'options' => array(
                    'rows' => '4',
                    'cols' => '12'
                )
            ),
            array(
                'name' => __( 'Link Url', 'eveny' ),
                'desc' => '',
                'id'   => $prefix . 'link_url',
                'type' => 'text',
                'std'  => ''
            )
        )
    ),
    array(
        'id'       => 'post_format_quote',
        'title'    => __( 'Quote Text', 'eveny' ),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __( 'Quote Text', 'eveny' ),
                'desc' => '',
                'id'   => $prefix . 'quote',
                'type' => 'textarea',
                'std'  => '',
                'options' => array(
                    'rows' => '4',
                    'cols' => '12'
                )
            ),
            array(
                'name' => __( 'Quote Author', 'eveny' ),
                'desc' => '',
                'id'   => $prefix . 'quote_author',
                'type' => 'text',
                'std'  => ''
            )
        )
    ),
    array(
        'id'       => 'post_format_video',
        'title'    => __( 'Video Link', 'eveny' ),
        'pages'    => array( 'post', 'gallery', 'event' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __( 'Video Content', 'eveny' ),
                'desc' => __( 'Paste your video link or video embed HTML code', 'eveny' ),
                'id'   => $prefix . 'video_link',
                'type' => 'textarea',
                'std'  => '',
                'options' => array(
                    'rows' => '4',
                    'cols' => '12'
                )
            )
        )
    ),
    array(
        'id'       => 'post_format_audio',
        'title'    => __( 'Audio Options', 'eveny' ),
        'pages'    => array( 'post' ),
        'context'  => 'normal',
        'priority' => 'high',
        'fields'   => array(
            array(
                'name' => __( 'Audio Link', 'eveny' ),
                'desc' => __( 'Paste your audio link or audio embed HTML code', 'eveny' ),
                'id'   => $prefix . 'audio_link',
                'type' => 'textarea',
                'std'  => '',
                'options' => array(
                    'rows' => '4',
                    'cols' => '12'
                )
            ),
        )
    ),
    /***************** end post formats ***********************/

);
