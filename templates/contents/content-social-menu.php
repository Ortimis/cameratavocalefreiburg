<?php
/**
 * Displays social menu content
 *
 * @package Section
 */
?>

<?php
	wp_nav_menu(
		array(
			'theme_location'  => 'social',
			'container'       => 'div',
			'container_id'    => 'menu-social',
			'container_class' => 'menu verticalize-container',
			'menu_id'         => 'menu-social-items',
			'menu_class'      => 'menu-items verticalize',
			'depth'           => 1,
			'link_before'     => '<span class="screen-reader-text">',
			'link_after'      => '</span>',
			'fallback_cb'     => '',
		)
	);
?>