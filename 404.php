<?php

/**
 * The template for displaying the 404 template in the Prosek Theme theme.
 *
 *
 * @since 1.0.0
 *
 */

get_header();
?>
	<main id="site-content" class="bg-slate-100">

		<?php
		$page_not_found = get_field( '404_page', 'options' );
		?>
		
		<div class="container text-center py-[50px] md:py-[150px] flex grow flex-col justify-center min-h-[inherit]">
			
			<h1 class=""><?php echo $page_not_found['heading'] ?></h1>
			
			<div class="pt-4 pb-8">
				<p><?php echo $page_not_found['text'] ?></p>
			</div>
			<a href="/" class="button button-black mx-auto">Back Home</a><!-- .button -->
		
		
		</div><!-- .section-inner -->
	
	</main><!-- #site-content -->

<?php
get_footer();
