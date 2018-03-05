<?php
/**
 * The template for displaying Gallery items on template-front.php.
 *
 * @package Eveny
 * @since Eveny 1.0
 */

$term_name    = esc_attr( get_theme_mod( 'gallery_category_selected', 'default' ) );
$info_class   = '';
$info_section = true;

// Get gallery page content
$gallery_title        = esc_html( get_theme_mod( 'gallery_section_title' ) );
$gallery_text         = esc_html( get_theme_mod( 'gallery_section_text' ) );
$gallery_button       = esc_html( get_theme_mod( 'gallery_section_button_text' ) );
$gallery_items_number = esc_html( get_theme_mod( 'eveny_gallery_items', 6 ) );

if ( empty( $gallery_title ) && empty( $gallery_text ) && empty( $gallery_button ) ) :
    $info_section = false;
    $info_class   = 'no-info';
endif;

// Get Gallery Page Template
$pages = get_pages( array(
    'meta_key'   => '_wp_page_template',
    'meta_value' => 'templates/template-gallery.php',
    'number'     => 1
) );

if ( $pages ) {
    foreach( $pages as $page ){
        $page_link = $page->ID;
    }

    $button_link = get_permalink( $page_link );
} else {
    $button_link = esc_url( get_post_type_archive_link( 'gallery' ) );
}

// Create query based on user input
if ( 'default' == $term_name ) :
    $args = array(
        'posts_per_page' => $gallery_items_number,
        'post_type'      => 'gallery',
        'post_status'    => 'publish'
    );

else :
    $args = array(
        'posts_per_page' => $gallery_items_number,
        'post_type'      => 'gallery',
        'post_status'    => 'publish',
        'tax_query'      => array(
            'relation' => 'AND',
                array(
                    'taxonomy' => 'ct_gallery',
                    'field'    => 'slug',
                    'terms'    => array( $term_name ),
                    'operator' => 'IN'
                ),
        )
    );

endif;

?>

<div class="template-front-gallery <?php echo esc_attr( $info_class ); ?>">
    <div class="container clear">

        <?php $gallery_query = new WP_Query( $args ); ?>

        <?php if ( $gallery_query->have_posts() ) : ?>

            <?php if ( $info_section ) : ?>

                <div class="template-content">
                    <?php

                        if ( ! empty( $gallery_title ) ) :

                            printf( '<h1 class="entry-title">%1$s</h1>', esc_html( $gallery_title ) );

                        endif;

                    ?>
                    <div class="entry-content">

                        <?php if ( ! empty( $gallery_text ) ) : ?>
                                <?php echo esc_html( $gallery_text ); ?>
                        <?php endif; ?>

                        <?php if ( ! empty( $gallery_button ) ) : ?>
                                <a href="<?php echo esc_url( $button_link ); ?>" class="button">
                                    <?php echo esc_html( $gallery_button ); ?>
                                </a>
                        <?php endif; ?>

                    </div>
                </div>

            <?php endif; ?>

            <div class="gallery-list">
                <div class="row">

                    <?php while ( $gallery_query->have_posts() ) : $gallery_query->the_post(); ?>

                        <?php get_template_part( '/templates/contents/content', 'gallery' ); ?>

                    <?php endwhile; ?>

                </div><!-- row -->
            </div><!-- gallery-list -->

            <?php wp_reset_postdata(); ?>

        <?php else : ?>

            <?php
                printf( '<h1 class="entry-title">%s</h1><a href="%s" class="button">%s</a>',
                    esc_html__( 'There are no gallery items yet.', 'eveny' ),
                    esc_url( admin_url() . 'post-new.php?post_type=gallery' ),
                    esc_html__( 'Add new gallery item', 'eveny' )
                );
            ?>

        <?php endif; ?>

    </div><!-- .container -->
</div><!-- .template-front-gallery -->
