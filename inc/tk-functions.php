<?php
/**
 * EVENY THEME SPECIFIC FUNCTIONS
 *
 * @package Eveny
 */

/**
 * Set font size for tag_cloud
 *
 * Sets unique font-size in pixels for tags cloud widget
 *
 * @since Eveny 1.0
 *
 */
function eveny_widget_tag_cloud_args( $args ) {
	$args['largest']  = 11;
	$args['smallest'] = 11;
	$args['unit']     = 'px';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'eveny_widget_tag_cloud_args' );


/**
 * WP Audio Playlist quote marks removal
 *
 * Removesquote marks from WordPress audio playlist display
 *
 * @since Eveny 1.0
 *
 */
function eveny_wp_underscore_playlist_templates() {
?>
<script type="text/html" id="tmpl-wp-playlist-current-item">
        <# if ( data.image ) { #>
        <img src="{{ data.thumb.src }}"/>
        <# } #>
        <div class="wp-playlist-caption">
                <span class="wp-playlist-item-meta wp-playlist-item-title">{{ data.title }}</span>
                <# if ( data.meta.album ) { #><span class="wp-playlist-item-meta wp-playlist-item-album">{{ data.meta.album }}</span><# } #>
                <# if ( data.meta.artist ) { #><span class="wp-playlist-item-meta wp-playlist-item-artist">{{ data.meta.artist }}</span><# } #>
        </div>
</script>
<script type="text/html" id="tmpl-wp-playlist-item">
        <div class="wp-playlist-item">
                <a class="wp-playlist-caption" href="{{ data.src }}">
                        {{ data.index ? ( data.index + '. ' ) : '' }}
                        <# if ( data.caption ) { #>
                                {{ data.caption }}
                        <# } else { #>
                                <span class="wp-playlist-item-title">{{{ data.title }}}</span>
                                <# if ( data.artists && data.meta.artist ) { #>
                                <span class="wp-playlist-item-artist"> — {{ data.meta.artist }}</span>
                                <# } #>
                        <# } #>
                </a>
                <# if ( data.meta.length_formatted ) { #>
                <div class="wp-playlist-item-length">{{ data.meta.length_formatted }}</div>
                <# } #>
        </div>
</script>
<?php
}

function eveny_wp_playlist_scripts() {
    remove_action( 'wp_footer', 'wp_underscore_playlist_templates', 0 );
    add_action( 'wp_footer', 'eveny_wp_underscore_playlist_templates', 0 );
}
add_action( 'wp_playlist_scripts', 'eveny_wp_playlist_scripts' );


/**
 * Parenthesses remove
 *
 * Removes parenthesses from category and archives widget
 *
 * @since Eveny 1.0
 */
function eveny_categories_postcount_filter( $variable ) {
	$variable = str_replace( '(', '<span class="post_count"> ', $variable );
	$variable = str_replace( ')', ' </span>', $variable );
	return $variable;
}
add_filter( 'wp_list_categories','eveny_categories_postcount_filter' );

function eveny_archives_postcount_filter( $variable ) {
	$variable = str_replace( '(', '<span class="post_count"> ', $variable );
	$variable = str_replace( ')', ' </span>', $variable );
	return $variable;
}
add_filter( 'get_archives_link','eveny_archives_postcount_filter' );


/**
 * -------------------------------------------------------------------------------------
 * Albums and Events custom pages functions
 * -------------------------------------------------------------------------------------
 */

/**
 * Get Albums Query
 *
 * @since Eveny 1.0
 */
function eveny_get_albums() {

	if ( is_page_template( 'templates/template-front.php' ) ) :
		// Show 5 Albums on Front Page template
		$albums_per_page = 5;
	endif;

    $args = array(
        'post_type'      => 'album',
        'post_status'    => 'publish',
        'posts_per_page' => $albums_per_page,
	);

	$albums = new WP_Query( $args );

	return $albums;
}

/**
 * Get Events Query
 *
 * @since Eveny 1.0
 */
function eveny_get_events() {

    $events_per_page = esc_attr( get_theme_mod( 'events_archive_numbers', 10 ) );

	if ( is_page_template( 'templates/template-front.php' ) ) :
		// Show 5 Events on Front Page template
		$events_per_page = 5;
	endif;

	$args = array(
		'post_type'      => 'event',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
	);

	$events = new WP_Query( $args );

	return $events;
}

/**
 * Get News Query
 *
 * Displays news on Front Page
 *
 * @since Eveny 1.0
 */
function eveny_get_news( $category ) {

    if ( 'default' != $category ) {
        $args = array(
            'cat'                 => $category,
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish'
        );
    } else {
        $args = array(
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish'
        );
    }

	$news = new WP_Query( $args );

	return $news;

}

/**
 * Get Events Query
 *
 * @since Eveny 1.0
 */
function eveny_get_galleries() {

    $galleries_per_page = 10;

    $args = array(
        'post_type'       => 'gallery',
        'posts_per_page'  => $galleries_per_page,
        'post_status'     => 'publish',
        'order'           => 'ASC'
    );

    $galleries = new WP_Query( $args );

    return $galleries;
}

/**
 * Gallery Category Selection
 *
 * @since  Eveny 1.0
 */
function eveny_select_gallery_category() {

    $galleries = get_terms( 'ct_gallery' );

    if ( ! empty( $galleries ) && ! is_wp_error( $galleries ) ) :

        $results['default'] = __( 'Default', 'eveny' );

        foreach ( $galleries as $gallery ) {
            $results[$gallery->slug] = $gallery->name;
        }

        return $results;

    endif;
}

/**
 * Event Category Selection
 *
 * @since  Eveny 1.0
 */
function eveny_select_event_category() {

    $events = get_terms( 'ct_events' );

    if ( ! empty( $events ) && ! is_wp_error( $events ) ) :

        $results['default'] = __( 'Default', 'eveny' );

        foreach ( $events as $event ) {
            $results[$event->slug] = $event->name;
        }

        return $results;

    endif;
}

/**
 * News Category Selection
 *
 * @since  Eveny 1.0
 */
function eveny_select_news_category() {

    $categories = get_categories();

    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :

        $results['default'] = __( 'Default', 'eveny' );

        foreach ( $categories as $category ) {
            $results[$category->cat_ID] = $category->name;
        }

        return $results;

    endif;
}


/**
 * Get All Pages and create select box for Customizer
 *
 * @since  Eveny 1.0
 */
function eveny_select_pages(){

    $pages = get_pages();

    // Get all page templates
    $templates = array( 'default', 'templates/template-fullwidth' );

    if ( ! empty ( $pages ) ) {
        $results['default'] = __( 'Default', 'eveny' );

        foreach ( $pages as $page ) {
            $page_template = get_post_meta( $page->ID, '_wp_page_template', true );

            // Check if page template is default or fullwidth
            if ( in_array( $page_template, $templates ) ) {
                $results[$page->ID] = $page->post_title;
            }
        }

        return $results;
    }
}

/**
 * Send Mail Contact Form
 *
 * @since  Eveny 1.0
 */

function eveny_send_contact_email() {

    $nonce   = $_POST['nonce'];

    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
        die ( __( 'You are not alowed to do this!', 'eveny' ) );
    }

    // Get our variables and data
    $captcha_option   = esc_attr( get_theme_mod( 'eveny_contact_captcha_setting' ) );
    $name             = esc_attr( $_POST['sender_name'] );
    $email            = esc_attr( $_POST['sender_email'] );
    $message          = esc_attr( $_POST['sender_message'] );
    $message_info     = esc_attr( $_POST['message_info'] );
    $validation_error = false;

    // Validation
    if ( strlen( $name ) < 2 ) {
        _e( 'Please enter your name!', 'eveny' );
        $validation_error = true;
        die();
    }
    elseif ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        _e( 'Please enter your email!', 'eveny' );
        $validation_error = true;
        die();
    }
    elseif ( strlen( $message ) < 2 ) {
        _e( 'Please enter your message!', 'eveny' );
        $validation_error = true;
        die();
    }
    elseif ( ! $captcha_option ) {
        // Start our session
        session_start();

        $captcha = $_POST['sender_captcha'];
        if ( empty( $_SESSION['captcha'] ) || strtolower( trim( $captcha ) ) != $_SESSION['captcha']  ) {
            _e( 'Invalid text from image!', 'eveny' );
            $validation_error = true;
            die();
        }
    }
    else {
        $validation_error = false;
    }

    if ( ! $validation_error ) {

        $to = esc_attr( get_theme_mod( 'eveny_contact_mail_address' ) );

        if ( '' == $to ) {
            $to = get_option( 'admin_email' );
        }

        $subject = __( 'Message from ', 'eveny' ) . get_bloginfo( 'name' );

        $headers  = "From: $name <$name>\n";
        $headers  .= "Reply-To: $subject <$name>\n";
        $sitename = get_bloginfo( 'name' );

        $body = __( 'You received e-mail from ', 'eveny' ) . $name . '  [' . $email . '] ' . __( ' using ', 'eveny' ) . $sitename . "\n\n\n";
        $body .= __( 'The message:', 'eveny' ) . "\n\n" . $message;

        $send = wp_mail( $to, $subject, $body, $headers );

        if ( $send ) {
            echo esc_html( $message_info );
        }
        else {
            esc_html_e( 'Message not sent!', 'eveny' );
        }
    }

    die();
}
add_action( 'wp_ajax_nopriv_send_contact_email', 'eveny_send_contact_email' );
add_action( 'wp_ajax_send_contact_email', 'eveny_send_contact_email' );


/**
 * Get Page Archive Name
 * Events, Gallery
 *
 * @since  Eveny 1.0
 */
function eveny_get_page_archive_name( $type ) {

    $page_template = 'templates/template-' . $type . '.php';

    $pages = get_pages( array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => $page_template,
        'number'     => 1
    ) );

    if ( $pages ) :
        foreach ( $pages as $page ) {
            $page_name = $page->post_title;
        }
    else :
        $page_name = sprintf ( __( '%s', 'eveny' ), ucfirst ( $type ) );
    endif;

    return $page_name;
}

/**
 * Events start and end date metaboxes
 *
 * @since  Eveny 1.0
 */
function eveny_eventposts_metaboxes() {
    add_meta_box( 'eveny_event_date_start', 'Start Date and Time', 'eveny_event_date', 'event', 'side', 'high', array( 'id' => '_start') );
    add_meta_box( 'eveny_event_date_end', 'End Date and Time', 'eveny_event_date', 'event', 'side', 'high', array('id'=>'_end') );
}
add_action( 'admin_init', 'eveny_eventposts_metaboxes' );

// Metabox HTML

function eveny_event_date( $post, $args ) {
    $metabox_id = $args['args']['id'];
    global $post, $wp_locale;

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'eveny_eventposts_nonce' );

    $time_adj = current_time( 'timestamp' );
    $month = esc_attr( get_post_meta( $post->ID, $metabox_id . '_month', true ) );

    if ( empty( $month ) ) {
        $month = gmdate( 'm', $time_adj );
    }

    $day = esc_attr( get_post_meta( $post->ID, $metabox_id . '_day', true ) );

    if ( empty( $day ) ) {
        $day = gmdate( 'd', $time_adj );
    }

    $year = esc_attr( get_post_meta( $post->ID, $metabox_id . '_year', true ) );

    if ( empty( $year ) ) {
        $year = gmdate( 'Y', $time_adj );
    }

    $hour = esc_attr( get_post_meta( $post->ID, $metabox_id . '_hour', true ) );
    $min = esc_attr( get_post_meta( $post->ID, $metabox_id . '_minute', true ) );


    $month_s = '<select name="' . $metabox_id . '_month">';
    for ( $i = 1; $i < 13; $i = $i +1 ) {
        $month_s .= "\t\t\t" . '<option value="' . zeroise( $i, 2 ) . '"';
        if ( $i == $month )
            $month_s .= ' selected="selected"';
        $month_s .= '>' . $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) . "</option>\n";
    }
    $month_s .= '</select>';

    echo $month_s;
    echo '<input type="text" name="' . $metabox_id . '_day" value="' . $day  . '" size="2" maxlength="2" />';
    echo '<input type="text" name="' . $metabox_id . '_year" value="' . $year . '" size="4" maxlength="4" /> @ ';
    echo '<input type="text" name="' . $metabox_id . '_hour" value="' . $hour . '" size="2" maxlength="2"/>:';
    echo '<input type="text" name="' . $metabox_id . '_minute" value="' . $min . '" size="2" maxlength="2" />';

}


// Save the Metabox Data

function eveny_eventposts_save_meta( $post_id, $post ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    if ( !isset( $_POST['eveny_eventposts_nonce'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['eveny_eventposts_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ) )
        return;

    // OK, we're authenticated: we need to find and save the data
    // We'll put it into an array to make it easier to loop though

    $metabox_ids = array( '_start', '_end' );

    foreach ( $metabox_ids as $key ) {
        $events_meta[$key . '_month'] = $_POST[$key . '_month'];
        $events_meta[$key . '_day']   = str_pad( $_POST[$key . '_day'], 2, '0', STR_PAD_LEFT );
        $events_meta[$key . '_year']           = $_POST[$key . '_year'];
        $events_meta[$key . '_hour']  = str_pad( $_POST[$key . '_hour'], 2, '0', STR_PAD_LEFT );
        $events_meta[$key . '_minute']         = $_POST[$key . '_minute'];
        $events_meta[$key . '_eventtimestamp'] = $events_meta[$key . '_year'] . $events_meta[$key . '_month'] . $events_meta[$key . '_day'] . $events_meta[$key . '_hour'] . $events_meta[$key . '_minute'];
    }

    // Add values of $events_meta as custom fields

    foreach ( $events_meta as $key => $value ) { // Cycle through the $events_meta array!
        if ( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode( ',', (array)$value ); // If $value is an array, make it a CSV (unlikely)

        if ( get_post_meta( $post->ID, $key, FALSE ) ) { // If the custom field already has a value
            update_post_meta( $post->ID, $key, $value );
        }
        else { // If the custom field doesn't have a value
            add_post_meta( $post->ID, $key, $value );
        }

        if ( !$value ) delete_post_meta( $post->ID, $key ); // Delete if blank
    }

}
add_action( 'save_post', 'eveny_eventposts_save_meta', 1, 2 );

/**
 * Populate select box for Map Zoom Factor in Customizer
 *
 * @since Eveny 1.0
 */
function eveny_map_zoom_select() {

    for ( $i = 1; $i <= 21; $i++ ) {
        $results[$i] = $i;
    }

    return $results;

}

/**
 * Redirect to IE8 Download page if users agent is IE8
 *
 * @since  Eveny 1.0
 */
function eveny_redirect_ie8() {
    $browser = $_SERVER['HTTP_USER_AGENT'];
    if ( preg_match( '/(?i)msie [2-8]/', $browser ) ) {
        if ( $overridden_template = locate_template( 'templates/old-ie.php' ) ) {
            load_template( $overridden_template );
            die();
        }
    }
}
add_action( 'wp_head', 'eveny_redirect_ie8' );
