<?php
/**
 * Displays Qoute post format
 *
 * @package Eveny
 */

$quote_text   = esc_attr( get_post_meta( get_the_ID(), 'eveny_quote', true ) );
$quote_author = esc_attr( get_post_meta( get_the_ID(), 'eveny_quote_author', true ) );

$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
    $empty_class = 'empty';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php if ( is_single() ) : ?>
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        <?php endif; ?>
    </header><!-- .entry-header -->

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

        <div class="entry-content <?php echo esc_attr( $empty_class ); ?>">
            <?php
                printf( '<blockquote>%s</blockquote><p>%s</p>',
                    $quote_text,
                    $quote_author
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