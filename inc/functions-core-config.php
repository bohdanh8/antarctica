<?php

/**
 * All the constants that can be overriden by the config/theme-config.php file
 * 
 * *** DO NOT EDIT ***
 * 
 */

// If you would like to restrict the user from viewing the page below a certian screen width, you can do so by setting the DESKTOP_ONLY_MODE constant to 'true' and setting a minimum screen width (Ex: before the responsive version is built). 
if (!defined('DESKTOP_ONLY_MODE')) {

    define('DESKTOP_ONLY_MODE', true);
}
if (!defined('MIN_SCREEN_SIZE')) {

    define('MIN_SCREEN_SIZE', '1440px');
}

// Update post_content field with the HTML from ACF templates
if (!defined('ADD_HTML_TO_POST')) {

    define('ADD_HTML_TO_POST', true);
}

/**
 * Comments
 * 
 */

// Disable comments for all post types
if (!defined('DISABLE_COMMENTS')) {

    define('DISABLE_COMMENTS', true);
}

/**
 * Optimizations
 * 
 */

// Remove emoji support
if (!defined('REMOVE_EMOJI')) {

    define('REMOVE_EMOJI', true);
}
// Remove rss feed links
if (!defined('REMOVE_RSS')) {

    define('REMOVE_RSS', false);
}
// Remove wp-embed
if (!defined('REMOVE_WP_EMBED')) {

    define('REMOVE_WP_EMBED', true);
}
// Remove block library css and more
if (!defined('REMOVE_BLOCK_LIBRARY')) {

    define('REMOVE_BLOCK_LIBRARY', true);
}
// Remove comment reply JS and more
if (!defined('REMOVE_POST_COMMENTS')) {

    define('REMOVE_POST_COMMENTS', true);
}
// Remove Classic Theme Styles
if (!defined('REMOVE_CLASSIC_THEME_STYLING')) {

    define('REMOVE_CLASSIC_THEME_STYLING', true);
}

// Set the maximum number of post revisions to keep
if (!defined('MAX_WP_POST_REVISIONS')) {

    define('MAX_WP_POST_REVISIONS', false);
}

// Disable image lazy loading
if (!defined('DISABLE_IMAGE_LAZY_LOADING')) {

    define('DISABLE_IMAGE_LAZY_LOADING', false);
}

// Enable Shortcodes within Gravity Form elements
if (!defined('ENABLE_SHORTCODES_IN_GRAVITY_FORMS')) {

    define('ENABLE_SHORTCODES_IN_GRAVITY_FORMS', true);
}

/**
 * Fuzzy Url Redirect
 * 
 * Setting this to "true" will prevent WordPress from redirecting to a partial page/post match when the slug is not found.
 * 
 */
if (!defined('DISABLE_CANONICAL_REDIRECT')) {

    define('DISABLE_CANONICAL_REDIRECT', false);
}

/**
 * Security
 * 
 */
if (!defined('DISABLE_XMLRPC')) {

    define('DISABLE_XMLRPC', true);
}

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
if (!defined('MENUS')) {

    define(
        'MENUS',
        [
            [
                'name'            => 'primary',
                'label'            => 'Primary Menu',
                'menu_id'        => 'primary-menu',
                'menu_class'    => 'menu primary-menu group/primary-menu',
            ],
            [
                'name'            => 'secondary',
                'label'            => 'Secondary Menu',
                'menu_id'        => 'secondary-menu',
                'menu_class'    => 'menu secondary-menu group/secondary-menu flex gap-x-[50px] py-[25px]',
            ],
            [
                'name'            => 'footer',
                'label'            => 'Footer Menu',
                'menu_id'        => 'footer-menu',
                'menu_class'    => 'menu footer-menu group/footer-menu flex gap-x-[20px]',
            ]
        ]
    );
}

/**
 * Additional Media Library Image sizes
 * 
 * 'image_size_name' => 100 (size in pixels)
 */
if (!defined('IMAGE_SIZES')) {

    define(
        'IMAGE_SIZES',
        [
            'image-100w'    => 100,
            'image-300w'    => 300,
            'image-500w'    => 500,
            'image-700w'    => 700,
            'image-900w'    => 900,
            'image-1100w'    => 1100,
            'image-1300w'    => 1300,
            'image-1500w'    => 1500,
            'image-1700w'    => 1700,
            'image-1900w'    => 1900,
            'image-2100w'    => 2100,
            'image-2300w'    => 2300,
            'image-2500w'    => 2500,
            'image-2700w'    => 2700,
            'image-2900w'    => 2900,
        ]
    );
}

/**
 * Define the terms (Taxonomies) that should not allow the user to assign Parent items.
 */
if (!defined('DISABLE_PARENTS_FOR_TERMS')) {
    define('DISABLE_PARENTS_FOR_TERMS', [
        'test-taxonomy',
    ]);
}

/**
 * debug.log file path when using the function, debug_log(). Please specify the local path of the Github repo you are using.
 */
if (!defined('DEBUG_LOG_PATH')) {

    define('DEBUG_LOG_PATH', '/Users/username/Documents/Github/starter-wp-theme/');
}

/**
 * Enable/Disable Restricted Documents feature 
 * 
 * 
 */
if (!defined('DOCUMENT_RESTRICTION')) {
    define('DOCUMENT_RESTRICTION', false);
}

/**
 * Enable/Disable Restricted Content feature 
 * 
 * This supports multiple Post Types.
 * 
 */
if (!defined('CONTENT_RESTRICTION')) {
    define('CONTENT_RESTRICTION', [
        'enable' => false,
        'post_types' => ['page', 'post']
    ]);
}

/**
 * Enable/Disable renaming of the default Post (Blog) labels to "News"
 * 
 */
if (!defined('RENAME_POSTS_LABELS_TO_NEWS')) {
    define('RENAME_POSTS_LABELS_TO_NEWS', true);
}

/**
 * Enable/Disable the helper class 'WPGB_SEARCH_FILTER' for WP Grid Builder
 * 
 */
if (!defined('WPGB_SEARCH_FILTER')) {
    define(
        'WPGB_SEARCH_FILTER',
        [
            'enable' => false,
            'admin_cards_and_grids_interface' => false,
        ]
    );
}

/**
 * Overrides the default search function to search through meta fields (For ACF) instead of the default post_title, post_content and post_excerpt for the specified post types.
 * 
 */
if (!defined('SEARCH_META_FIELDS')) {
    define('SEARCH_META_FIELDS', [
        'enable' => false,
        'enable_for_admin' => true,
        'post_types' => ['post_type_1', 'post_type_2'],
        'meta_fields' => [
            'acf-group-name_sub-field-1',
            'acf-group-name_sub-field-1'
        ]
    ]);
}

/** 
 * ACF Excerpt field names 
 * 
 * Specify all the ACF field names (Both the section name and field name combined) that needs to update the excerpt field in the database when saving a post/page/cpt
 */
if (!defined('ACF_EXCERPT_FIELD_NAMES')) {
    define('ACF_EXCERPT_FIELD_NAMES', [
        'blog_post_-_excerpt_excerpt'
    ]);
}
