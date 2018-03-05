<?php
/**
 * The template for displaying news on template-front.php.
 *
 * @package Eveny
 */

// Get event page content
$news_category = esc_html( get_theme_mod( 'news_category_selected' ) );
$news_title    = esc_html( get_theme_mod( 'news_section_title' ) );
$news_text     = esc_html( get_theme_mod( 'news_section_text' ) );
$news_button   = esc_html( get_theme_mod( 'news_section_button_text' ) );
$posts_page    = get_home_url();

// Get news posts
$news         = eveny_get_news( $news_category );
$info_section = true;
$info_class   = '';

if ( get_option( 'page_for_posts' ) ) {
	$posts_page  = esc_url( get_permalink( get_option( 'page_for_posts' ) ) );
}

if ( empty( $news_title ) && empty( $news_text ) && empty( $news_button ) ) :
    $info_section = false;
    $info_class   = 'no-info';
endif;

?>

<div class="template-front-news <?php echo esc_attr( $info_class ); ?>">
    <div class="container clear">

    <?php if ( $news ) { ?>

        <?php if ( $news->have_posts() ) : ?>

			<?php if ( $info_section ) : ?>

                    <div class="template-content">

                        <?php
    				        if ( ! empty( $news_title ) ) :
                                printf( '<h1 class="entry-title">%1$s</h1>', esc_html( $news_title ) );
                            endif;
                        ?>

                        <div class="entry-content">

                            <?php if ( ! empty( $news_text ) ) : ?>
                                    <?php echo esc_html( $news_text ); ?>
                            <?php endif; ?>

                            <?php if ( ! empty( $news_button ) ) : ?>
                                    <a href="<?php echo esc_attr( $posts_page ); ?>" class="button">
                                        <?php echo esc_html( $news_button ); ?>
                                    </a>
                            <?php endif; ?>

                        </div>

                    </div>

            <?php endif; ?>

            <div class="news-list">
                <div class="row">
            		<?php while( $news->have_posts() ) : $news->the_post(); ?>

        		        <?php get_template_part( '/templates/contents/content', get_post_format() ); ?>

            		<?php endwhile; ?>
        		</div>
        	</div>

        <?php endif; ?>

	<?php } ?>

    </div><!-- container -->
</div><!-- template-front-news -->

<?php wp_reset_postdata(); ?>
