<?php
/**
 * Template Name: Front Page Template
 * The template for displaying page with sections.
 *
 * @package Eveny
 * @since Eveny 1.0
 */

 get_header();

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <!-- Section One -->
        <?php
            $section_one = esc_attr( get_theme_mod( 'eveny_section_one', 'albums' ) );
            if ( $section_one != 'disable' ) {
                get_template_part( '/templates/sections/section', $section_one );
            }
        ?>
        <!-- Custom Section 
        -- Added Section for Custom Post Type Quotes
        -->
        <?php 
             get_template_part( '/templates/sections/section', 'quotes');
        ?>

        <!-- Section Two -->
        <?php
            $section_two = esc_attr( get_theme_mod( 'eveny_section_two', 'events' ) );
            if ( $section_two != 'disable' ) {
                get_template_part( '/templates/sections/section', $section_two );
            }
        ?>



        <!-- Section Three -->
        <?php
            $section_three = esc_attr( get_theme_mod( 'eveny_section_three', 'news' ) );
            if ( $section_three != 'disable' ) {
               get_template_part( '/templates/sections/section', $section_three );
            }
        ?>

        <!-- Section Four -->
        <?php
            $section_four = esc_attr( get_theme_mod( 'eveny_section_four', 'gallery' ) );
            if ( $section_four != 'disable' ) {
               get_template_part( '/templates/sections/section', $section_four );
            }
        ?>

        <!-- Section Five -->
        <?php
            $section_five = esc_attr( get_theme_mod( 'eveny_section_five', 'page' ) );
            if ( $section_five != 'disable' ) {
               get_template_part( '/templates/sections/section', $section_five );
            }
        ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
