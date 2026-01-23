<section class="cookie-consent-banner fixed inset-x-0 bottom-0 flex flex-col justify-between gap-x-8 gap-y-4 bg-white p-6 ring-1 ring-gray-900/10 md:flex-row md:items-center lg:px-8 z-[999999999]">
	
	<div class="max-w-4xl text-sm leading-6 text-gray-900 [&_a]:text-indigo-600 [&_a]:font-semibold [&_p]:mb-0">

		<?php the_field( 'cookie_consent_banner_text', 'option' ) ?>
	
	</div>
	
	<div class="flex flex-none items-center gap-x-5">
		
		<a class="cookie-consent-banner__button button ">
			<?php the_field( 'cookie_consent_banner_button_text', 'option' ) ?>
		</a><!-- .cookie-consent-banner__button -->
	
	</div>

</section><!-- .cookie-consent-banner -->