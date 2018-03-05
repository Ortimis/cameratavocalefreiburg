<?php
/**
 * The template for displaying Events on template-front.php.
 *
 * @package Eveny
 *
 * @since Eveny 1.0
 */

$term_name    = esc_attr( get_theme_mod( 'events_category_selected', 'default' ) );
$info_section = true;
$info_class   = '';

// Get event page content
$events_title          = esc_html( get_theme_mod( 'events_section_title' ) );
$events_text           = esc_html( get_theme_mod( 'events_section_text' ) );
$events_button         = esc_html( get_theme_mod( 'events_section_button_text' ) );
$events_archive_button = esc_url( get_theme_mod( 'events_section_button_url' ) );
$button_link           = $events_archive_button;

if ( empty( $events_archive_button ) ) {
    $button_link   = esc_url( get_permalink( get_page_by_title( eveny_get_page_archive_name( 'events' ) ) ) );
}

// Create query based on user input
if ( 'default' == $term_name ) :

    $args = array(
        'post_type'   => 'event',
        'post_status' => 'publish',
        'order'       => 'ASC'
    );

else :

    $args = array(
        'post_type'   => 'event',
        'post_status' => 'publish',
        'tax_query'   => array(
            'relation' => 'AND',
                array(
                    'taxonomy' => 'ct_events',
                    'field'    => 'slug',
                    'terms'    => array( $term_name ),
                    'operator' => 'IN'
                ),
        ),
        'order'       => 'ASC'
    );

endif;

if ( empty( $events_title ) && empty( $events_text ) && empty( $events_button ) ) :
    $info_section = false;
    $info_class   = 'no-info';
endif;

?>

<div class="template-front-events <?php echo esc_attr( $info_class ); ?>">
    <div class="container clear">

        <?php $event_query = new WP_Query( $args ); ?>

        <?php if ( $event_query->have_posts() ) : ?>

            <?php if ( $info_section ) : ?>

                    <div class="template-content">

                        <?php
                            if ( ! empty( $events_title ) ) :
                                printf( '<h1 class="entry-title">%1$s</h1>', esc_html( $events_title ) );
                            endif;
                        ?>

                        <div class="entry-content">

                            <?php if ( ! empty( $events_text ) ) : ?>
                                    <?php echo esc_html( $events_text ); ?>
                            <?php endif; ?>

                            <?php if ( ! empty( $events_button ) ) : ?>
                                    <a href="<?php echo esc_url( $button_link ); ?>" class="button">
                                        <?php echo esc_html( $events_button ); ?>
                                    </a>
                            <?php endif; ?>

                        </div>

                    </div>

            <?php endif; ?>

            <div class="event-list">
                <div class="event-slider-wrap">

                    <div class="event-slider">
                        <div class="slidee">

                            <?php while ( $event_query->have_posts() ) : $event_query->the_post(); ?>

                                <?php get_template_part( '/templates/contents/content', 'event' ); ?>

                            <?php endwhile; ?>

                        </div>
                    </div><!-- event-slider -->

                    <?php wp_reset_postdata(); ?>

                    <div class="scrollbar">
                        <div class="handle">
                            <span></span>
                        </div>
                    </div>

                </div><!-- event-slider-wrap -->
            </div><!-- event-list -->

        <?php else : ?>

            <?php
                printf( '<h1 class="entry-title">%s</h1>',
                    esc_html__( 'Weitere Konzerte werden in naher Zukunft angekündigt.', 'eveny' )
                    // esc_url( site_url() . '/konzerte' ),
                    // esc_html__( 'Konzertarchiv', 'eveny' )
                );
            ?>

        <?php endif; ?>

    </div><!-- container -->
</div><!-- template-front-events -->

<?php wp_reset_postdata(); ?>
