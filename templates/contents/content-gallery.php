<?php
/**
 * Displays content for gallery post type
 *
 * @package Eveny
 */

$gallery_template = false;
$columns          = array( 'col-lg-4', 'col-sm-6' );

if ( 'video' == get_post_format() ) {
    $video = get_post_meta( get_the_ID(), 'eveny_video_link', true );
}

$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
    $empty_class = 'empty';
}

if ( is_page_template( 'templates/template-gallery.php' ) || is_post_type_archive() ) {
    $gallery_template = true;
}
elseif ( is_page_template( 'templates/template-front.php' ) ) {
    $front_template = true;
}
else {
    $columns = '';
}

// Set No image if thumbnail doesn't exist
if ( has_post_thumbnail() ) {
    if ( is_single() ) {
        $gallery_image = get_the_post_thumbnail( get_the_ID(), 'gallery-thumb-single' );
    }
    else {
        $gallery_image = get_the_post_thumbnail( get_the_ID(), 'gallery-thumb' );
    }
    $gallery_image_link = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
}
else {
    $gallery_image      = '<img src="' . get_template_directory_uri() . '/theme-images/no-image.jpg">';
    $gallery_image_link = '#';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $columns ); ?>>



        <?php if ( is_single() ) : ?>

                <?php if ( ! empty( $video ) ) {  ?>

                        <figure class="featured-image scalable-wrapper">
                            <div class="scalable-element">
                                <?php if ( wp_oembed_get( $video ) ) : ?>
                                    <?php echo wp_oembed_get( $video ); ?>
                                <?php else : ?>
                                    <?php echo $video; ?>
                                <?php endif; ?>
                            </div>
                        </figure>

                <?php

                    } else {

                ?>

                    <figure class="featured-image">
                        <?php echo $gallery_image; ?>
                    </figure>

                <?php

                    }

                ?>

                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    <?php
                        printf( '<div class="post-meta"><span class="category-links">%s</span></div>',
                            get_the_term_list( get_the_ID(), 'ct_gallery', false, ', ', false )
                        );
                    ?>
                </header>

                <div class="entry-content <?php echo esc_attr( $empty_class ); ?>">
                    <?php the_content(); ?>
                </div>

        <?php else : ?>

                <figure class="featured-image">
                    <a href="<?php echo esc_url( $gallery_image_link ); ?>" class="fancybox" rel="home-gallery">
                        <?php echo $gallery_image; ?>
                    </a>

                    <figcaption>
                        <a href="<?php echo esc_url( the_permalink() ); ?>">
                            <?php esc_html( the_title() ); ?>
                        </a>
                    </figcaption>
                <figure class="featured-image">

        <?php endif; ?>

    </figure>

</article>
