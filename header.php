<?php

/**
 * Header file for the Prosek Theme WordPress default theme.
 *
 * *** IT'S BEST NOT TO EDIT THIS ***
 *
 * Use the header-section.php file in template-parts instead.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @since 1.0.0
 */
?>
	
	<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>
	
	<head>
		
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="profile" href="https://gmpg.org/xfn/11">
		
		<!-- Font Preloading -->
		<?php get_template_part( 'template-parts/font-preloading' ); ?>

		<?php wp_head(); ?>
		
		<!-- Header Scripts -->
		<?php get_template_part( 'template-parts/head-tag-scripts' ); ?>
	
	</head>

<body <?php body_class( 'group group/body group/id-' . get_the_ID() . ' group/type-' . get_post_type() . ' group/' . get_post_field( 'post_name' ) . ' ' . ( ( get_post_field( 'post_parent' ) ) ? 'group/has-parent' : '' ) . '' ); ?>>

<div class="page min-h-screen overflow-hidden">

<?php if ( DESKTOP_ONLY_MODE ) : ?>
	
	<!-- Desktop only mode -->
	<div id="desktop-only">
		<?php
		$file_location = STYLESHEETPATH . "/inc/templates/desktop-only.php";

		if ( file_exists( $file_location ) ) :

			load_template( $file_location, true, MIN_SCREEN_SIZE );

		endif;
		?>
	</div><!-- #desktop-only -->
	
	<div id="body-section" class="h-full">

<?php endif; ?>

<?php get_template_part( 'template-parts/header-section' ); ?>