<header id="header" class="relative z-50 group/header-menu">
	<nav class="header-inner duration-300 transition-[top] bg-white">
		<div class="container py-14 max-w-full relative z-20">
			<div class="flex justify-between max-lg:items-center w-full gap-10">
				<a href="<?php echo home_url(); ?>">
					<?php echo get_start_logo(); ?>
				</a>
				
				<div id="mobile-menu" class="max-lg:drilldown-menu flex max-lg:flex-col lg:items-center lg:justify-center gap-6">
					<div class="lg:ml-6 lg:flex group/deskop-menu [&_a]:multi-underline-1 [&_a]:cursor-pointer [&_a]:pointer-events-auto">
						<?php
						wp_nav_menu( [
							'theme_location' => 'primary',
						] );
						?>
					</div>

				</div>
				<!-- Mobile menu button -->
				<button type="button"
				        class="group/nav-button relative inline-flex items-center justify-center rounded-md lg:hidden"
				        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only"><?php _e('Open main menu', 'prosekwptheme'); ?></span>
                    <?php get_component('menu-icon'); ?>
				</button>
			</div>
		</div>
	</nav>

</header><!-- #header -->