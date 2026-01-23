<?php

/**
 * Blog page template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @since 1.6.9
 */

get_header();
?>
	
	<main id="site-content">
		<?php $blog_page = get_option( 'page_for_posts' );
		get_loop( $blog_page ); ?>
	</main><!-- #site-content -->

<?php
get_footer();
