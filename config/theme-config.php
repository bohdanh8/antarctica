<?php

/**
 * All theme configuration options go here.
 *
 * Please refer the inc/functions-core.php file to see all the options which can be used here.
 *
 * @since 1.0.0
 *
 */


/**
 * If you would like to restrict the user from viewing the page below a certian screen width, you can do so by setting the DESKTOP_ONLY_MODE constant to 'true' and setting a minimum screen width (Ex: before the responsive version is built).
 *
 */
const DESKTOP_ONLY_MODE = false;
const MIN_SCREEN_SIZE   = '1440px';

/**
 * Menus
 *
 *  [
 *       'name' => 'primary',
 *       'label' => 'Header Menu',
 *       'menu_id' => 'header-menu', // Add an id to the wrapper ul element
 *       'menu_class' => 'menu primary-menu group/primary-menu', // Add classes to the wrapper ul element
 *       'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' // Define the structure of the wrapper element
 *   ]
 */
const MENUS = [
	[
		'name'       => 'primary',
		'label'      => 'Primary Menu',
		'menu_id'    => 'primary-menu',
		'menu_class' => 'menu primary-menu group/primary-menu max-lg:flex-col flex lg:gap-5 3xl:gap-10 1xl:max-3xl:gap-6 justify-end before:gradient-menu lg:relative',
	],
	[
		'name'       => 'footer',
		'label'      => 'Footer Menu',
		'menu_id'    => 'footer-menu',
		'menu_class' => 'menu footer-menu group/footer-menu flex gap-x-[20px]',
		'items_wrap' => '%3$s'
	]
];

/**
 * Additional Media Library Image sizes
 *
 * 'image_size_name' => 100 (size in pixels)
 *
 */
const IMAGE_SIZES = [
	'image-100w'  => 100,
	'image-300w'  => 300,
	'image-500w'  => 500,
	'image-700w'  => 700,
	'image-900w'  => 900,
	'image-1100w' => 1100,
	'image-1300w' => 1300,
	'image-1500w' => 1500,
	'image-1700w' => 1700,
	'image-1900w' => 1900,
	'image-2100w' => 2100,
	'image-2300w' => 2300,
	'image-2500w' => 2500,
	'image-2700w' => 2700,
	'image-2900w' => 2900,
];

/**
 * Define the terms (Taxonomies) that should not allow the user to assign Parent items.
 */
const DISABLE_PARENTS_FOR_TERMS = [
	'test-taxonomy',
];

/**
 * Update post_content field with the HTML from ACF templates
 *
 */
const ADD_HTML_TO_POST = true;

/**
 * Comments
 *
 */
const DISABLE_COMMENTS = true; // Disable comments for all post types.

/**
 * Optimizations
 *
 */
const REMOVE_EMOJI                 = true; // Remove emoji support
const REMOVE_RSS                   = false; // Remove rss feed links
const REMOVE_WP_EMBED              = true; // Remove wp-embed
const REMOVE_BLOCK_LIBRARY         = true; // Remove block library css and more
const REMOVE_POST_COMMENTS         = true; // Remove comment reply JS and more
const REMOVE_CLASSIC_THEME_STYLING = true; // Remove Classic Theme Styles
const MAX_WP_POST_REVISIONS        = 100; // Set the maximum number of post revisions to keep
const DISABLE_IMAGE_LAZY_LOADING   = false; // Disable Image lazy loading

/**
 * Fuzzy Url Redirect
 *
 * Setting this to "true" will prevent WordPress from redirecting to a partial page/post match when the slug is not found.
 *
 */
const DISABLE_CANONICAL_REDIRECT = false;

/**
 * Security
 *
 */
const DISABLE_XMLRPC = true; // Disable the Xmlrpc service

/**
 * Enable/Disable Restricted Documents feature
 *
 * This currently supports PDF files only.
 *
 */
const DOCUMENT_RESTRICTION = false;

/**
 * Enable/Disable Restricted Content feature
 *
 */
const CONTENT_RESTRICTION = ['enable' => false, 'post_types' => ['page', 'post']];

/**
 * Enable/Disable renaming of the default Post (Blog) labels to "News"
 *
 */
const RENAME_POSTS_LABELS_TO_NEWS = true;

/**
 * Enable/Disable the helper class 'WPGB_SEARCH_FILTER' for WP Grid Builder
 *
 */
const WPGB_SEARCH_FILTER = [
	'enable'                          => true,
	'admin_cards_and_grids_interface' => false,
];

/**
 * Overrides the default search function to search through meta fields (For ACF) instead of the default post_title, post_content and post_excerpt for the specified post types.
 *
 */
const SEARCH_META_FIELDS = [
	'enable'           => false,
	'enable_for_admin' => true,
	'post_types'       => ['post_type_1', 'post_type_2'],
	'meta_fields'      => [
		'acf-group-name_sub-field-1',
		'acf-group-name_sub-field-1'
	]
];

/**
 * ACF Excerpt field names
 *
 * Specify all the ACF field names (Both the section name and field name combined) that needs to update the excerpt field in the database when saving a post/page/cpt
 */

const ACF_EXCERPT_FIELD_NAMES = ['blog_post_-_excerpt_excerpt'];
