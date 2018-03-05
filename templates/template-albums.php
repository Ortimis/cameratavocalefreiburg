<?php
/**
 * Template Name: Albums
 *
 * Page for displaying child Album pages
 *
 * @package Eveny
 */

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
    'post_type'      => 'album',
    'post_status'    => 'publish',
   	'posts_per_page' => 10,
    'paged'			 => $paged
);

$albums_query = new WP_Query( $args );

?>

<div class="container">
	<div class="row">

		<header class="page-header col-lg-12">

			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

		</header><!-- .page-header -->

		<div id="primary" class="content-area grid col-lg-12">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				<?php endwhile; ?>

				<!-- Album list -->
				<?php if ( $albums_query->have_posts() ) : ?>

					<div class="row">
						<div class="grid-wrapper">

							<?php while ( $albums_query->have_posts() ) : $albums_query->the_post(); ?>

								<?php get_template_part( '/templates/contents/content', 'album' ); ?>

							<?php endwhile; ?>

						</div><!-- .grid-wrapper -->
					</div><!-- .row -->

					<!-- ALBUMS PAGINATION -->

					<?php

					    $albums_query->query_vars['paged'] > 1 ? $current = $albums_query->query_vars['paged'] : $current = 1;

					    $pagination = array(
					        'base'      => @add_query_arg( 'paged', '%#%' ),
					        'format'    => '',
					        'total'     => $albums_query->max_num_pages,
					        'current'   => $current,
					        'type'      => 'list',
					        'prev_next' => true,
					        'prev_text' => __( 'Prev', 'eveny' ),
					        'next_text' => __( 'Next', 'eveny' )
					    );

					    if ( $wp_rewrite->using_permalinks() )
					        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

					    if ( ! empty( $wp_query->query_vars['s'] ) )
					        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

					    // Display pagination
					    printf( '<nav class="navigation paging-navigation"><h1 class="screen-reader-text">%1$s</h1>%2$s</nav>',
					        esc_html_x( 'Page navigation', 'eveny' ),
					        paginate_links( $pagination )
					    );

					?>

				<?php else : ?>

					<?php get_template_part( '/templates/contents/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php wp_reset_postdata(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>

