<?php
/**
 * Index
 *
 * Standard loop for the search result page
 */
get_header(); ?>
	
	<main id="site-content">
		<div class="min-h-body search-page">
			<div class="container">
				<h1><?php printf( __( 'Search Results for: %s', 'default' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
				<div class="mb-11">
					<?php get_component( "search-form" ); ?>
				</div>
				<?php if ( have_posts() ) : ?>
					<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_component( "loop-news" ); ?>
						<?php endwhile; ?>
					</div>
					<?php starter_pagination(); ?>
				<?php else : ?>
					<h6><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'default' ); ?></h6>
				<?php endif; ?>
			</div>
		</div>
	</main>

<?php get_footer(); ?>