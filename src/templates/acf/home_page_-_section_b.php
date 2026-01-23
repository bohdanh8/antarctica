<div class=" bg-gray-100 py-24 sm:py-32">
	<div class="container py-0">
		<div class="mx-auto max-w-7xl">
			
			<div class="mx-auto grid max-w-2xl grid-cols-1 items-start gap-x-8 gap-y-16 sm:gap-y-24 lg:mx-0 lg:max-w-none lg:grid-cols-2">
				
				<div class="lg:pr-4">
					<div class="relative overflow-hidden rounded-3xl h-[500px] px-6 pb-9 pt-64 shadow-2xl sm:px-12 lg:max-w-lg lg:px-8 lg:pb-8 xl:px-10 xl:pb-10">
						
						<div class="absolute inset-0 h-full w-full ">
							<?php render_image( get_sub_field( 'main_image' ), '25vw', '600px' ) ?>
						</div><!-- .absolute -->
					
					</div>
				</div>
				
				<div>
					<div class="text-base leading-7 text-gray-700 lg:max-w-lg">

						<?php if ( ! empty( get_sub_field( 'heading_1' ) ) ) : ?>
							<p class="text-base font-semibold leading-7 text-indigo-600">
								<?php the_sub_field( 'heading_1' ) ?>
							</p>
						<?php endif; ?>
						
						<h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
							<?php the_sub_field( 'heading_2' ) ?>
						</h1>
						
						<div class="max-w-xl">
							<?php the_sub_field( 'text' ) ?>
						</div>
					
					</div>
				</div>
			
			</div>
		
		</div>
	</div><!-- .container -->
</div>