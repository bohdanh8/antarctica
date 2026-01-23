<footer id="site-footer" class="bg-white ease-btm" data-scroll>
	<?php get_component('footer-banner'); ?>

	<?php $footer_section = get_field('footer_section_edit', 'option'); ?>

	<div class="overflow-hidden container">
		<nav class="columns-2 -mb-6 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">

			<?php
			wp_nav_menu([
				'theme_location' => 'footer',
				'depth'          => 1,
			]);
			?>

			<?php get_component("modal"); ?>
		</nav>
		<div class="flex justify-center space-x-10 mt-10">

			<?php $social_links = [
				'linkedin'  => 'LinkedIn',
				'facebook'  => 'Facebook',
				'instagram' => 'Instagram',
				'twitter'   => 'Twitter',
				'github'    => 'GitHub',
				'youtube'   => 'YouTube',
			]; ?>

			<?php foreach ($social_links as $key => $label): ?>
				<?php if (! empty($footer_section["{$key}_link"])): ?>
					<a href="<?php echo esc_url($footer_section["{$key}_link"]); ?>" target="_blank"
						rel="noopener" aria-label="<?php echo esc_attr($label) ?>" class="w-6 h-6 text-gray-400 [&_svg]:w-full [&_svg]:h-full hover:text-gray-500">
						<span class="sr-only"><?php echo esc_html($label); ?></span>
						<?php echo get_social_icons($key); ?>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

		<p class="mt-10 text-gray-500 text-xs text-center leading-5">
			&copy; <?php echo date('Y') ?> <?php echo $footer_section['copyright_text'] ?></p>
	</div>


</footer><!-- #site-footer -->