<?php
/**
 * Template Name: Galleries
 *
 * Page for displaying child Album pages
 *
 * @package Eveny
 */

get_header();

// Get all galleries
$galleries = eveny_get_galleries();

// Gallery categories filter
$args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => true
);

$categories = get_terms( 'ct_gallery', $args );

?>

<div class="container">
	<div class="row">

		<!-- CATEGORY FILTER -->
		<header class="page-header col-lg-2">

			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

			<nav class="filter-nav">
				<ul class="nav-categories" id="filters">
					<li class="category selected">
						<a href="#" class="all"><?php _e( 'All', 'eveny' ) ?></a>
					</li>
					<?php
					foreach ( $categories as $category ) {
						echo '<li class="category ' . $category->slug.'-nav"><a href="#" class="' . $category->slug . '">' . $category->name . '</a></li>';
					}
					?>
				</ul>
			</nav>

		</header><!-- .page-header -->

		<div id="primary" class="content-area grid col-lg-10">
			<main id="main" class="site-main" role="main">

				<!-- Album list -->
				<?php if ( $galleries->have_posts() ) : ?>

					<div class="row">
						<div class="grid-wrapper">

							<?php while ( $galleries->have_posts() ) : $galleries->the_post(); ?>

								<?php get_template_part( '/templates/contents/content', 'gallery' ); ?>

							<?php endwhile; ?>

						</div><!-- .grid-wrapper -->
					</div><!-- .row -->

				<?php else : ?>

					<?php get_template_part( '/templates/contents/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- #primary -->

		<?php wp_reset_postdata(); ?>

	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>
