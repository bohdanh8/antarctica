<?php

/**
 * Adds the Theme options section to the General Settings page and add all the required fields.
 * 
 * *** DO NOT EDIT ***
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.0 Initial release
 *
 */
function general_settings_page_init()
{

    // Add Theme Options Section.
    add_settings_section(
        'theme_options', // Section ID
        '', // Section title
        'theme_options_section_callback', // Callback function to render the section
        'general' // Settings page (General)
    );


    // Add Minify HTML setting.
    add_settings_field(
        'minify_html', // Field ID
        'Minify HTML', // Field label
        'minify_html_callback', // Callback function to render the field
        'general', // Settings page (General)
        'theme_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'minify_html' // Option name
    );


    // Add Remove HTML Comments setting.
    add_settings_field(
        'remove_html_comments', // Field ID
        'Remove HTML Comments', // Field label
        'remove_html_comments_callback', // Callback function to render the field
        'general', // Settings page (General)
        'theme_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'remove_html_comments' // Option name
    );


    // Add Google Tag Manager setting.
    add_settings_field(
        'gtm_id', // Field ID
        'Google Tag Manager ID', // Field label
        'gtm_id_callback', // Callback function to render the field
        'general', // Settings page (General)
        'theme_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'gtm_id' // Option name
    );
}
add_action('admin_init', 'general_settings_page_init');


/**
 * This renders the Title and the description for the Theme Options section
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.0 Initial release
 *
 */
function theme_options_section_callback()
{
    echo '<br /><br /><h1>Prosek ST Framework v' . PST_FRAMEWORK_VERSION . '</h1><hr /><h2>Theme Options </h2><p>This section allows you to control certain functions of the theme.</p>';
}

/**
 * This renders the checkbox field HTML for the Minify HTML setting
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.0 Initial release
 *
 */
function minify_html_callback()
{
    $value = get_option('minify_html');
    echo '<label><input type="checkbox" name="minify_html" value="1" ' . checked(1, $value, false) . ' /> Minify the final HTML output.</label>';
}

/**
 * This renders the checkbox HTML for the Remove HTML Comments setting.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.0 Initial release
 *
 */
function remove_html_comments_callback()
{
    $value = get_option('remove_html_comments');
    echo '<label><input type="checkbox" name="remove_html_comments" value="1" ' . checked(1, $value, false) . ' /> Remove comments from the final HTML output.</label>';
}

/**
 * This renders the textbox for the GTM ID setting.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.0 Initial release
 *
 */
function gtm_id_callback()
{
    $value = sanitize_text_field(get_option('gtm_id'));
    echo '<input type="text" name="gtm_id" value="' . $value . '" /> <br /><label>Leave this empty to disable GTM</label>';
}
