<?php $news_repeater = isset( $args['news'] ) ? $args['news'] : []; ?>
<?php $post_list = wp_list_pluck( $news_repeater, 'featured_post' ); ?>
<?php if ( $post_list ): ?>
	<div class="w-full pb-4">
		<h6><?php _e( 'News', 'prosekwptheme' ); ?></h6>
		<div class="w-full">
			<?php foreach ( $post_list as $post_item ): ?>
				<article class="mt-8 first:mt-0">
					<a class="block w-full link-with-zoom-img"
					   href="<?php echo esc_url( get_permalink( $post_item ) ); ?>">
						<?php $image = [ 'image' => get_post_thumbnail_id( $post_item ) ]; ?>
						<div class="aspect-video">
							<?php echo get_attachment_fallback( $image ); ?>
						</div>
						<h6><?php echo esc_html( get_the_title( $post_item ) ); ?></h6>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
