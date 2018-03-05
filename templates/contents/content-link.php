<?php
/**
 * Displays Link post format
 *
 * @package Eveny
 */

$link_text = esc_attr( get_post_meta( get_the_ID(), 'eveny_link_text', true ) );
$link_url  = esc_attr( get_post_meta( get_the_ID(), 'eveny_link_url', true ) );

$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
    $empty_class = 'empty';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-box">

        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="featured-image">
                <?php if ( is_single() ) : ?>
                        <?php the_post_thumbnail(); ?>
                <?php else : ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <header class="entry-header">
            <?php if ( is_single() ) : ?>
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <?php else : ?>
                <?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-content <?php echo esc_attr( $empty_class ); ?>">

            <?php

                printf( '<a href="%s">%s</a>',
                    $link_url,
                    $link_text
                );

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'eveny' ),
                    'after'  => '</div>',
                ) );
            ?>

        </div><!-- .entry-content -->

        <?php eveny_post_meta(); ?>

    </div><!-- .post-box -->

    <?php if ( is_single() ) : ?>

        <footer class="entry-footer">
            <?php eveny_entry_footer(); ?>
        </footer><!-- .entry-footer -->

    <?php endif; ?>

</article><!-- #post-## -->