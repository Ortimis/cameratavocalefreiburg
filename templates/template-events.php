<?php
/**
 * Template Name: Events
 *
 * Page for displaying child Events pages
 *
 * @package Eveny
 */

get_header();

// Get all Events children
$events = eveny_get_events();

// Event categories filter
$args = array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => false,
	'posts_per_page' => -1
);

$categories = get_terms( 'ct_events', $args );

?>

<div class="container">
	<div class="row">

		<!-- CATEGORY FILTER -->
		<header class="page-header col-lg-2">

			<?php the_title( '<h1 class="page-title">', '</h1>' ); ?>

			<?php if ( ! empty( $categories ) ) : ?>
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
			<?php endif; ?>

		</header><!-- .page-header -->

		<div id="primary" class="content-area grid col-lg-10">
			<main id="main" class="site-main" role="main">

				<?php if ( $events->have_posts() ) : ?>

						<div class="row">
							<div class="grid-wrapper">

								<?php while ( $events->have_posts() ) : $events->the_post(); ?>

									<?php get_template_part( '/templates/contents/content', 'event' ); ?>

								<?php endwhile; ?>

							</div><!-- .grid-wrapper -->
						</div><!-- .row -->

				<?php else : ?>

						<?php get_template_part( '/templates/contents/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->
		</div><!-- .content-area -->

	</div><!-- .container -->
</div><!-- .row -->

<?php wp_reset_postdata(); ?>

<?php get_footer(); ?>