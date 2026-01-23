<?php
$external_link = get_field( 'news_-_content_external_link', get_the_ID() );
?>

<article <?php post_class(); ?>>
	<a href="<?php echo esc_url( get_permalink() ); ?>" <?php echo $external_link ? 'target="_blank"' : ''; ?> class="link-with-zoom-img">
		<div class="overflow-hidden mb-2 aspect-video rounded-lg">
			<?php $image = [ 'image' => get_post_thumbnail_id() ]; ?>
			<?php echo get_attachment_fallback( $image ); ?>
		</div>
		<div>
			<div class="flex gap-2 sm:gap-7 items-center mb-2">
				<?php
				$categories = get_the_category();
				if ( ! empty( $categories ) ) :
					$category_names = wp_list_pluck( $categories, 'name' ); ?>
					<span><?php echo esc_html( implode( ', ', $category_names ) ); ?></span>
				<?php endif; ?>
			</div>
			<div class="mb-4 line-clamp-3">
				<h6 class="multi-underline-2 inline"><?php echo esc_html( get_the_title() ); ?></h6>
			</div>
			<time datetime="<?php echo get_the_time( 'c' ); ?>"><?php echo get_the_date(); ?></time>
		</div>
	</a>
</article>