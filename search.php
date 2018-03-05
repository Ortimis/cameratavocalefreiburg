<?php
/**
 * The template for displaying search results pages.
 *
 * @package Eveny
 */

get_header(); ?>

<div class="container">
	<div class="row">

		<header class="page-header col-lg-2">
			<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'eveny' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		</header><!-- .page-header -->

		<section id="primary" class="content-area col-lg-7 col-md-8">
			<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						get_template_part( '/templates/contents/content', 'search' );
					?>

				<?php endwhile; ?>

				<?php eveny_page_numbers_pagination(); ?>

			<?php else : ?>

				<?php get_template_part( '/templates/contents/content', 'none' ); ?>

			<?php endif; ?>

			</main><!-- #main -->
		</section><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
