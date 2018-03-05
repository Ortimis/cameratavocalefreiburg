<?php
/**
 * Displays Event content
 *
 * @package Eveny
 */

$columns = array( 'col-lg-4', 'col-sm-6', 'clear' );
if ( is_single() ) {
	$columns = 'clear';
}

if ( 'video' == get_post_format() ) {
    $video = esc_attr( get_post_meta( get_the_ID(), 'eveny_video_link', true ) );
}

$event_place = esc_html( get_post_meta( get_the_ID(), 'eveny_event_location', true ) );
$content     = esc_html( get_the_content() );
$empty_class = '';

if ( ! is_single() && trim( $content ) == '' ) {
    $empty_class = 'empty';
}

// Get WordPress Setting date format
$date_format = get_option( 'date_format' );

// Calculate date difference
$start_date       = strtotime( esc_attr( get_post_meta( get_the_ID(), '_start_eventtimestamp', true ) ) );
$end_date         = strtotime( esc_attr( get_post_meta( get_the_ID(), '_end_eventtimestamp', true ) ) );
$start_time       = esc_attr( get_post_meta( get_the_ID(), '_start_hour', true ) );
$end_time         = esc_attr( get_post_meta( get_the_ID(), '_end_hour', true ) );
$date_diff        = $end_date - time();
$date_day_diff    = $end_date - $start_date;
$day_diff         = floor( $date_day_diff / ( 60 * 60 * 24 ) );
$event_start_date = date( $date_format, $start_date );
$event_end_date   = date( $date_format, $end_date );
$start_end        = '';

// Get and format time of event
$date_class = 'no-time';
if ( '' != $end_time && '' != $start_time ) {
	$wp_time_format   = get_option( 'time_format' );
	$event_start_time = date( $wp_time_format, $start_date );
	$event_end_time   = date( $wp_time_format, $end_date );
	$start_end        = $event_start_time . ' - ' . $event_end_time;
	$date_class       = '';
}

// Hours & Minutes
$start_hour   = get_post_meta( get_the_ID(), '_start_hour', true );
$start_minute = get_post_meta( get_the_ID(), '_start_minute', true );
$end_hour     = get_post_meta( get_the_ID(), '_end_hour', true );
$end_minute   = get_post_meta( get_the_ID(), '_end_minute', true );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $columns ); ?>>

	<?php if ( is_archive() || is_page_template( 'templates/template-events.php' ) ) : ?>

		<div class="event-post-wrapper">

	<?php endif; ?>

			<?php if ( is_single() ) : ?>

					<?php if ( ! empty( $video ) ) {  ?>

						<figure class="featured-image">
							<div class="scalable-wrapper">
								<div class="scalable-element">
									<?php if ( wp_oembed_get( $video ) ) : ?>
										<?php echo wp_oembed_get( $video ); ?>
									<?php else : ?>
										<?php echo $video; ?>
									<?php endif; ?>
								</div>
							</div>
						</figure>

					<?php } else { ?>

							<?php if ( has_post_thumbnail() ) : ?>

								<figure class="featured-image">
									<?php the_post_thumbnail( 'event-thumb' ); ?>
								</figure>

							<?php endif; ?>

					<?php } ?>

			<?php else : ?>

					<?php if ( has_post_thumbnail() ) : ?>

						<figure class="featured-image">
							<?php the_post_thumbnail( 'event-thumb' ); ?>
						</figure>

					<?php endif; ?>

			<?php endif; ?>

			<div class="event-content-wrapper">

				<!-- BUY TICKETS & GET DIRECTIONS -->
				<?php if ( is_page_template( 'templates/template-front.php' ) || is_page_template( 'templates/template-events.php' ) ) : ?>

					<?php eveny_tickets_directions(); ?>

				<?php endif; ?>

				<header class="entry-header">

					<!-- EVENT META -->
					<time class="<?php if ( $date_diff < 0 ) { ?> passed-event <?php } else { echo $date_class; } ?>">
						<?php if ( $day_diff > 0 ) : ?>
								<?php echo esc_html( $event_start_date ) . '-' . esc_html( $event_end_date ); ?>
						<?php else : ?>
								<?php echo esc_html( $event_start_date ); ?>
						<?php endif; ?>
					</time>
					<div class="event-time">

						<!-- Print text message if Event has passed -->
						<?php if ( $date_diff <= 0 ) : ?>
							<time>
								<?php printf( '<span>%s</span>', esc_html__( 'This event has passed', 'eveny' ) ); ?>
							</time>
						<?php else : ?>
								<!-- Start & End time -->
								<?php echo $start_end; ?>
						<?php endif; ?>

					</div><!-- .event-time -->

					<?php

						if ( is_single() ) {
							the_title( sprintf( '<h1 class="entry-title">', esc_url( get_permalink() ) ), '</h1>' );
						}
						else {
							the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
						}

						printf( '<address>%s</address>', esc_html( $event_place ) );

					?>

				</header><!-- .entry-header -->

				<?php if ( is_single() ) : ?>

					<?php eveny_tickets_directions(); ?>

					<div class="entry-content <?php echo esc_attr( $empty_class ); ?>">
						<?php the_content(); ?>
					</div>

					<?php eveny_post_nav(); ?>

				<?php endif; ?>

		    </div><!-- .event-content-wrapper -->

	<?php if ( is_archive() || is_page_template( 'templates/template-events.php' ) ) : ?>

			</div><!-- .event-post-wrapper -->

	<?php endif; ?>

</article><!-- #post-## -->
