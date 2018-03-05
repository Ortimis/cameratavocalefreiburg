<?php
/**
 * Displays theme navigation menu
 *
 * @package Eveny
 */
?>

<div class="menu-container">

	<a href="#" class="close-menu">
		<i class="icon-close"></i>
	</a>

	<!-- PRIMARY NAVIGATION -->
	<?php

		if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
						'theme_location'  => 'primary',
						'menu'            => '',
						'menu_id'         => 'navigation',
						'depth'           => 0,
						'container'       => 'div',
						'container_class' => 'menu verticalize-container',
						'menu_class'      => 'verticalize',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
					)
				);
		} else {
				wp_page_menu( array(
						'depth'       => 0,
						'sort_column' => 'menu_order, post_title',
						'menu_class'  => 'menu',
						'include'     => '',
						'exclude'     => '',
						'echo'        => true,
						'show_home'   => false,
						'link_before' => '',
						'link_after'  => ''
					)
				);
		}

	?>

</div><!-- .menu-container -->