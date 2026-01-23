<?php

/**
 * Create a new WP Grid Builder template when the WPGB_Search_Filter class is instantiated.
 * 
 * *** DO NOT EDIT ***
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.2.0 Initial release
 *
 * @param  array $templates
 *
 * @return array $templates 
 */
function register_search_filter_templates($templates = [])
{

    $templates_transient = get_transient('wp_search_filter_templates');

    if (!empty($templates_transient) && is_array($templates_transient)) {

        return array_merge(get_transient('wp_search_filter_templates'), $templates);
    } else {

        return $templates;
    }
}
add_filter('wp_grid_builder/templates', 'register_search_filter_templates', 10, 1);

/**
 * Remove unwanted submenus from the WP Grid Builder Admin panel.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.2.0 Initial release
 *
 */
function remove_unwanted_wpgb_sub_menus()
{
    if (empty(WPGB_SEARCH_FILTER['admin_cards_and_grids_interface'])) {
        remove_submenu_page('wp-grid-builder', 'wp-grid-builder&menu=cards'); // Remove Cards page.
        remove_submenu_page('wp-grid-builder', 'wp-grid-builder&menu=grids'); // Remove Grids page.
        remove_submenu_page('wp-grid-builder', 'wp-grid-builder&menu=styles'); // Remove Styles page.
    }
}
add_action('admin_menu', 'remove_unwanted_wpgb_sub_menus', 20);

/**
 * Remove Elements from the Grid Builder Interface if they are not needed.
 *
 * @author Prosek Partners
 *  
 * @since 1.2.0 Initial release
 *
 */
function hide_unwanted_wpgb_items()
{
    if (empty(WPGB_SEARCH_FILTER['admin_cards_and_grids_interface'])) {
        ob_start();
?>
        <style id="hide-unwanted-wpgb-items-inline-css" type="text/css">
            #wpgb-admin-header li:nth-of-type(3),
            #wpgb-admin-header li:nth-of-type(4),
            #wpgb-admin-header li:nth-of-type(5) {
                display: none !important;
            }

            .wp-admin.edit-tags-php .wpgb-settings {
                display: none !important;
            }
        </style>
    <?php
        echo ob_get_clean();
    }
}
add_action('admin_head', 'hide_unwanted_wpgb_items');


function load_more_button($output, $facet, $number, $offset, $remain)
{

    if ($facet['load_more_event'] === 'onscroll') {
        ob_start();
    ?>
        <div class="wpgb-search-filter-load-more-button-wrapper w-full relative">
            <button type="button" class="wpgb-button wpgb-load-more h-[1px] p-0 invisible overflow-hidden">Loading</button>

            <div class="wpgb-loader">
                <div class="wpgb-loader-12">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

        </div><!-- .load-more-button-wrapper -->
<?php
        $output = ob_get_clean();
    }

    return $output;
}
add_filter('wp_grid_builder/facet/load_more', 'load_more_button', 10, 5);


/**
 * Load additional styles when the filter functionality is in use.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.2.0 Initial release
 *
 * @param  array $core_styles CSS files that are part of the wpgb core.
 *
 * @return array $core_styles 
 */
function wpgb_register_styles($core_styles = [])
{
    $styles = [
        'handle'  => 'wpgb-search-filter',
        'source'  => get_stylesheet_directory_uri() . '/inc/modules/wpgb-search-filter/css/main.css',
        'version' => wp_get_theme()->get('Version'),
    ];

    $core_styles[] = $styles;

    return $core_styles;
}
add_filter('wp_grid_builder/frontend/register_styles', 'wpgb_register_styles');


/**
 * Load additional scripts when the filter functionality is in use.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.2.0 Initial release
 *
 * @param  array $core_scripts Script files that are part of the wpgb core.
 *
 * @return array $core_scripts 
 */
function wpgb_register_scripts($core_scripts = [])
{
    $scripts = [
        'handle'  => 'wpgb-search-filter',
        'source'  => get_stylesheet_directory_uri() . '/inc/modules/wpgb-search-filter/js/main.js',
        'version' => wp_get_theme()->get('Version'),
    ];

    $core_scripts[] = $scripts;

    return $core_scripts;
}
add_filter('wp_grid_builder/frontend/register_scripts', 'wpgb_register_scripts');
