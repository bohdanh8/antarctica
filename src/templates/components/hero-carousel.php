<?php $hero_carousel = get_sub_field( "hero_carousel" ); ?>
<?php if ( ! empty( $slides = $hero_carousel["slider"] ) ): ?>
	<div class="hero-section group/hero-section overflow-hidden">
		<div class="swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $slides as $slide ) : ?>
					<div class="swiper-slide cursor-grab h-auto">
						<?php get_component( 'hero-section', $slide ); ?>
					</div><!-- .swiper-slider -->
				<?php endforeach; ?>
			</div><!-- .swiper-wrapper -->
		</div><!-- .swiper -->
	</div><!-- .hero-section -->
<?php endif; ?>
