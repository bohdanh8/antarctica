<?php

/**
 * The main template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.0.0
 */

get_header();
?>
	
	<main id="site-content">

		<?php get_loop(); ?>
	
	</main><!-- #site-content -->

<?php
get_footer();
