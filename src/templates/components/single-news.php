<div class="container">
	<div class="mx-auto mb-10 max-w-screen-lg ease-btm" data-scroll>
		<div class="mb-4">
			<a class="inline-flex items-center multi-underline-1"
				href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" class="block h-4 mr-2 fill-current" viewBox="0 0 20 20">
					<path d="M13.891 17.418a.697.697 0 0 1 0 .979a.68.68 0 0 1-.969 0l-7.83-7.908a.697.697 0 0 1 0-.979l7.83-7.908a.68.68 0 0 1 .969 0a.697.697 0 0 1 0 .979L6.75 10z" />
				</svg>
				<span><?php esc_html_e(" Back to all", "prosekwptheme"); ?></span>
			</a>
			<div class="flex flex-col gap-1 mt-6 mb-4 sm:flex-row sm:items-center sm:gap-3">
				<?php
				$categories = get_the_category();
				if (! empty($categories)) : ?>
					<div class="flex flex-wrap items-center gap-2 sm:gap-7">
						<?php $category_names = wp_list_pluck($categories, 'name'); ?>
						<span class="font-bold"><?php echo esc_html(implode(', ', $category_names)); ?></span>
					</div>
					<span class="w-0.5 h-5 bg-black max-sm:hidden"></span>				<?php endif; ?>

				<time datetime="<?php echo get_the_time('c'); ?>"><?php echo get_the_date(); ?></time>
			</div>
			<h1 class="h4"><?php echo esc_html(get_the_title()); ?></h1>
		</div>
	</div>
	<div class="mb-4 rounded-lg aspect-video overflow-hidden ease-btm" data-scroll>
		<?php $image = ['image' => get_post_thumbnail_id()]; ?>
		<?php echo get_attachment_fallback($image); ?>
	</div>

	<div class="mx-auto mt-10 max-w-screen-lg ease-btm" data-scroll>
		<?php if ($content = get_sub_field("content")): ?>
			<div class="clearfix content">
				<?php echo wp_kses_post($content); ?>
			</div>
		<?php endif; ?>
		<?php get_component('share-links', ['title' => get_the_title(), 'link' => get_permalink()]); ?>
	</div>
</div>

<?php
$news_args = array(
	'post_type'      => 'post',
	'orderby'        => 'date',
	'order'          => 'desc',
	'posts_per_page' => '10',
	'post_status'    => 'publish',
	'post__not_in'   => array(get_the_ID()),
	'tax_query'      => array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => wp_get_post_categories(get_the_ID()),
		),
	),
);
$news      = new WP_Query($news_args); ?>

<?php if ($news->have_posts()): ?>
	<div class="px-side-offset ease-btm swiper news" data-scroll>
		<h3><?php _e('Related news', 'prosekwptheme'); ?></h3>

		<div class="flex swiper-wrapper">
			<?php while ($news->have_posts()): $news->the_post(); ?>
				<div class="swiper-slide shrink-0">
					<?php get_component('loop-news'); ?>
				</div>
			<?php endwhile; ?>
		</div>
	</div>

	<div class="py-10 container">
		<div class="flex gap-x-8 mb-8 swiper-nav">
			<?php get_component('swiper-nav', ['prefix' => 'news']); ?>
		</div>
	</div>
<?php endif;
wp_reset_query(); ?>