<?php
/**
 * The template for displaying Events on template-front.php.
 *
 * @package Eveny
 * @since Eveny 1.0
 */

// Get all albums children
$albums           = eveny_get_albums();
$full_album_class = 'one-album';
$single_album     = false;

if ( $albums->post_count > 1 ) {
    $full_album_class = '';
    $single_album     = true;
}

$album_archive       = get_page_by_title( eveny_get_page_archive_name( 'albums' ) );
$template_album_link = '#';

if ( $album_archive ) {
    $template_album_link = esc_url( get_permalink( $album_archive->ID ) );
}

?>

<div class="template-front-albums <?php echo esc_attr( $full_album_class ); ?>">
    <div class="container clear">

        <?php if ( $albums ) { ?>

            <?php if ( $albums->have_posts() ) : ?>

                <?php if ( $single_album ) : ?>
                    <nav class="prev">
                        <a href="#">
                            <h3></h3>
                            <aside><i class="icon-left"></i> <span><?php _e( 'Prev Album', 'eveny' ); ?></span></aside>
                        </a>
                        <a href="<?php echo esc_url( $template_album_link ); ?>" class="view-albums vertical-middle">
                            <h3><?php esc_html_e( 'View All Albums', 'eveny' ); ?></h3>
                            <aside><i class="icon-left"></i> <span><?php esc_html_e( 'All Albums', 'eveny' ); ?></span></aside>
                        </a>
                    </nav>
                <?php endif; ?>

                <div class="album-slider-wrapper">
                    <div class="album-slidee">
                        <?php
                            while ( $albums->have_posts() ) : $albums->the_post();
                                get_template_part( '/templates/contents/content', 'album' );
                            endwhile;
                        ?>
                    </div><!-- album-slidee -->
                </div>

                <?php if ( $single_album ) : ?>
                    <nav class="next">
                        <a href="#">
                            <h3></h3>
                            <aside><span><?php esc_html_e( 'Next Album', 'eveny' ); ?></span> <i class="icon-right"></i></aside>
                        </a>
                        <a href="<?php echo $template_album_link; ?>" class="view-albums vertical-middle">
                            <h3><?php esc_html_e( 'View All Albums', 'eveny' ) ?></h3>
                            <aside><span><?php esc_html_e( 'All Albums', 'eveny' ); ?></span> <i class="icon-right"></i></aside>
                        </a>
                    </nav>
                <?php endif; ?>

            <?php else : ?>

                <?php
                    printf( '<h3>%s</h3><a href="%s">%s</a>',
                        esc_html__( 'There are no albums yet.', 'eveny' ),
                        esc_url( admin_url() . 'post-new.php?post_type=page' ),
                        esc_html__( 'Add new album', 'eveny' )
                    );
                ?>

            <?php endif; ?>

        <?php } else { ?>

            <?php
                printf( '<h3>%s</h3><a href="%s">%s</a>',
                    esc_html__( 'There are no albums yet.', 'eveny' ),
                    esc_url( admin_url() . 'post-new.php?post_type=page' ),
                    esc_html__( 'Add new album', 'eveny' )
                );
            ?>

        <?php } ?>

    </div><!-- container -->
</div><!-- template-front-albums -->

<?php wp_reset_postdata(); ?>
