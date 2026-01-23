<?php

/**
 * The template for displaying the footer
 *
 * Contains the opening of the #site-footer div and all content after.
 *
 * *** IT'S BEST NOT TO EDIT THIS ***
 *
 * Use the footer-section.php file in template-parts instead.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @since 1.0.0
 *
 */

?>
<?php //get_template_part('/template-parts/cookie-consent-banner'); ?>

<?php get_template_part( '/template-parts/footer-section' ); ?>

<?php wp_footer(); ?>

<?php if ( DESKTOP_ONLY_MODE ) : ?>
	</div>
<?php endif; ?>

</div><!-- .page -->


</body>

</html>